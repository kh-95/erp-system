<?php

namespace App\Modules\Legal\Http\Repositories\AgenecyType;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\AgenecyType\AgenecyType;
use App\Modules\Legal\Http\Requests\AgenecyTypeRequest;
use App\Repositories\CommonRepository;
use Arr;

class AgenecyTypeRepository extends CommonRepository implements AgenecyTypeRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return AgenecyType::class;
    }

    public function filterColumns()
    {
        return [
            $this->translated('name'),
            $this->translated('description'),
            'is_active',
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            $this->sortingTranslated('name', 'name'),
            $this->sortingTranslated('description', 'description'),
            'is_active',
        ];
    }

    public function store(AgenecyTypeRequest $request)
    {
        $data = $request->validated();
        $agenecy = $this->model()::create($data);

        return $agenecy;
    }

    public function updateAgenecyType(AgenecyTypeRequest $request, AgenecyType $agenecyType)
    {
        $data = $request->validated();
        $agenecyType->update($data);

        return $agenecyType;
    }

    public function show($id)
    {
        return  $this->model()::findOrFail($id)->load('agenecyTerms');
    }
}
