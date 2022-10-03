<?php

namespace App\Modules\Legal\Http\Repositories\Agenecy;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Legal\Entities\Agenecy;
use App\Modules\Legal\Http\Requests\AgenecyRequest;
use App\Repositories\CommonRepository;
use Arr;

class AgenecyRepository extends CommonRepository implements AgenecyRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    public function model()
    {
        return Agenecy::class;
    }

    public function filterColumns()
    {
        return [
            'clientEmployee.first_name',
            'agentEmployee.first_name',
            'agenecy_number',
            'agency_type',
            'duration',
            'created_at'
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            'clientEmployee.first_name',
            'agentEmployee.first_name',
            'agenecy_number',
            'agency_type',
            'duration',
            'created_at'
        ];
    }

    public function store(AgenecyRequest $request)
    {
        $data = $request->validated();
        $agenecy = $this->model()::create(Arr::except($data, [
            'attachments',
            'agency_type_id',
            'agenecy_type_term_id',
            'static_text_id'
        ]));

        $this->storeRelationships($agenecy, $data, $request);

        return $agenecy;
    }

    public function updateAgenecy(AgenecyRequest $request, Agenecy $agenecy)
    {
        $data = $request->validated();
        $agenecy->update(Arr::except($data, 'attachments'));
        $this->storeRelationships($agenecy, $data, $request);

        return $agenecy;
    }

    public function show($id)
    {
        return  $this->model()::findOrFail($id)->load([
            'attachments',
            'clientManagement',
            'clientEmployee',
            'previousAgenecy',
            'agentManagement',
            'agentEmployee',
            'country',
        ]);
    }

    private function storeRelationships($agenecy, $data, AgenecyRequest $request)
    {
        if (isset($data['agency_type_id'])) {
            $agenecy->types()->sync($data['agency_type_id']);
        }

        if (isset($data['agenecy_type_term_id'])) {
            $agenecy->types()->sync($data['agenecy_type_term_id']);
        }

        if (isset($data['static_text_id'])) {
            $agenecy->types()->sync($data['static_text_id']);
        }

        if ($request->isMethod('PUT')) {
            $agenecy->attachments()->delete();
            $agenecy->attachments->map(function ($item, $key) {
                $this->deleteImage($item, 'agenecy_attachments');
            });
        }

        if ($request->has('attachments') && $request->attachments != null) {
            $attachments = collect($request->attachments)->map(function ($item, $key) {
                $data['media'] = $this->storeImage($item, 'agenecy_attachments');
                $data['type'] = $key;
                return $data;
            })->values()->toArray();

            $agenecy->attachments()->createMany($attachments);
        }
    }
}
