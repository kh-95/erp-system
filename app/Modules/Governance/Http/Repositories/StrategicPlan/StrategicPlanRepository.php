<?php

namespace App\Modules\Governance\Http\Repositories\StrategicPlan;

use Illuminate\Support\Arr;
use App\Repositories\CommonRepository;
use App\Repositories\AttachesRepository;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Governance\Http\Requests\StrategicPlanRequest;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlan;
use App\Modules\Governance\Entities\StrategicPlan\StrategicPlanAttribute;
use App\Foundation\Traits\ImageTrait;

class StrategicPlanRepository extends CommonRepository implements StrategicPlanRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    public function model()
    {
        return StrategicPlan::class;
    }

    public function filterColumns()
    {
        return [
            $this->translated('title'),
            'from',
            'to',
            'is_active',
            'achieved',
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            $this->sortingTranslated('title', 'title'),
            'from',
            'achieved',
            $this->sortingTranslated('vision', 'vision'),
            'is_active',
        ];
    }

    public function store(StrategicPlanRequest $request)
    {
        $data = $request->validated();
        $strategicPlan = $this->model()::create($data);

        $this->storePlanAttributes('tasks', $strategicPlan);
        $this->storePlanAttributes('goals', $strategicPlan);
        $this->storePlanAttributes('terms', $strategicPlan);
        $this->storePlanAttributes('requirements', $strategicPlan);

        if (array_key_exists('attachments', $request->validated())) {
            $attaches = new AttachesRepository('strategic_plans_attachments', $request, $strategicPlan);
            $attaches->addAttaches();
        }

        return $strategicPlan;
    }

    public function updateStrategicPlan(StrategicPlanRequest $request, StrategicPlan $strategicPlan)
    {

        $data = $request->validated();
        $strategicPlan->fill($data)->save();

        $this->updatePlanAttributes('tasks', $data, $strategicPlan);
        $this->updatePlanAttributes('goals', $data, $strategicPlan);
        $this->updatePlanAttributes('terms', $data, $strategicPlan);
        $this->updatePlanAttributes('requirements', $data, $strategicPlan);

        // update attachments
        if ($request->isMethod('PUT')) {
            $strategicPlan->attachments()->delete();
            $strategicPlan->attachments->map(function ($item) {
                return $this->deleteImage($item, 'strategic_plans_attachments');
            });
        }

        if ($request->has('attachments') && $request->attachments != null) {

            $attachments = collect($request->attachments)->map(function ($item) {
                $data['file'] = $this->storeImage($item, 'strategic_plans_attachments');
                $data['type'] = request()->file_type;
                return $data;
            })->values()->toArray();
            $strategicPlan->attachments()->createMany($attachments);
        }


        return $strategicPlan->load('attachments');
    }

    public function show($id)
    {
        return  $this->model()::findOrFail($id)->load('attachments');
    }

    private function storePlanAttributes($type, $strategicPlan)
    {
        request()->{$type} = array_map(function ($arr) use ($type) {
            return $arr + ['type' => $type];
        }, request()->{$type});
        $strategicPlan->planAttributes()->createMany(request()->{$type});
    }

    private function updatePlanAttributes($type, $data, $strategicPlan)
    {
        $oldIds = $strategicPlan->planAttributes()->where('type', $type)->pluck('id');
        $newIds = array_column($data[$type] ?? [], 'id');

        foreach ($oldIds as $id) {
            if (!in_array($id, $newIds)) {
                StrategicPlanAttribute::find($id)->delete();
            }
        }

        foreach ($data[$type] ?? [] as $index => $key) {
            if (StrategicPlanAttribute::find(@$key['id'])) {
                StrategicPlanAttribute::find(@$key['id'])->update(Arr::except($data[$type][$index], ['id']));
            } else {

                $strategicPlan->planAttributes()->create(Arr::except($data[$type][$index], ['id']) + ['type' => $type]);
            }
        }
    }

    public function destroy($id)
    {
        $strategicPlan = $this->find($id);
        $files = $strategicPlan->attachments;
        foreach ($files as $file) {
            $this->deleteFile($file->media, $file->type, StrategicPlan::STRATEGICPLAN);
        }
        return   $strategicPlan->delete($id);

    }
}
