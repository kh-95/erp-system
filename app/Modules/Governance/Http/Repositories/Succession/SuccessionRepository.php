<?php

namespace App\Modules\Governance\Http\Repositories\Succession;


use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Governance\CustomFilter\FilterPlanAtBetween;
use App\Modules\Governance\Entities\Succession;
use App\Modules\Governance\Entities\SuccessionItem;
use App\Modules\Governance\Http\Requests\SuccessionRequest;
use App\Modules\HR\Entities\Job;
use App\Modules\HR\Entities\JobTranslation;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Entities\ManagementTranslation;
use App\Repositories\AttachesRepository;
use App\Repositories\CommonRepository;
use Illuminate\Support\Arr;
use Spatie\QueryBuilder\AllowedFilter;

class SuccessionRepository extends CommonRepository implements SuccessionRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function planAtBetween($value)
    {
        return AllowedFilter::custom($value, new FilterPlanAtBetween);
    }


    public function filterColumns()
    {
        return [
            $this->translated('name'),
            $this->planAtBetween('plan_from'),
            $this->planAtBetween('plan_to'),
            'management_id',
            'job_id',
            'is_active',
            'percentage',
        ];
    }

    public function sortColumns()
    {
        return [
            'id',
            $this->sortingTranslated('name', 'name'),
            'plan_from',
            'plan_to',
            $this->sortUsingRelationship('management-name',ManagementTranslation::getTableName().'.'. Succession::getTableName().'.'.'management_id.name'),
            $this->sortUsingRelationship('job-name',JobTranslation::getTableName().'.'. Succession::getTableName().'.'.'job_id.name'),
            'is_active',
            'percentage',
        ];
    }

    public function model()
    {
        return Succession::class;
    }

    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function store(SuccessionRequest $request)
    {
        $data = $request->validated();
        $succession = $this->model()::make()->fill(Arr::except($data, ['items', 'attachments', 'file_type']));
        $succession->save();
        $succession?->items()->createMany($data['items']);
        if (array_key_exists('attachments', $request->validated())) {
            $attaches = new AttachesRepository('succession_attachments', $request, $succession);
            $attaches->addAttaches();
        }
        $succession->load('attachments', 'items');
        return $succession;
    }


    public function updateSuccession(SuccessionRequest $request, $id)
    {
        $succession = Succession::findOrFail($id);
        $data = $request->validated();
        $succession->fill(Arr::except($data, ['items', 'attachments', 'file_type']));
        $succession->save();
        $oldItemsIds = $succession->items()->pluck('id');
        $newItemsIds = array_column($data['items'] ?? [], 'id');
        foreach ($oldItemsIds as $id) {
            if (!in_array($id, $newItemsIds)) {
                SuccessionItem::find($id)->delete();
            }
        }

        foreach ($data['items'] ?? [] as $index => $item) {
            if (SuccessionItem::find(@$item['id'])) {
                SuccessionItem::find(@$item['id'])->update(Arr::except($data['items'][$index], ['id']));
            } else {
                $succession->items()->create(Arr::except($data['items'][$index], ['id']));
            }
        }

        if (array_key_exists('attachments', $request->validated())) {
            $this->deleteSuccessionImage($succession->attachments);
            $attaches = new AttachesRepository('succession_attachments', $request, $succession);
            $attaches->addAttaches();
        }
        $succession->load('items', 'attachments');
        return $succession;
    }

    private function deleteSuccessionImage($succession_attaches)
    {
        $succession_attaches->map(function ($item) {
            $this->deleteImage($item->file, 'committee_attachments', $item->type);
            $item->delete();
        });
    }

    public function destroy($id)
    {
        $succession = $this->findOrFail($id);
        if (!$succession->is_active) {
            $this->delete($id);
            return $this->successResponse(['message' => __('governance::messages.general.successfully_deleted')]);
        }
        return $this->errorResponse(['message' => __('governance::messages.succession.canot_delete_succession')]);

     }


}
