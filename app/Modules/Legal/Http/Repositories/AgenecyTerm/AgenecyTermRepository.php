<?php

namespace App\Modules\Legal\Http\Repositories\AgenecyTerm;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\AgenecyTerm\AgenecyTerm;
use App\Modules\Legal\Http\Requests\AgenecyTermRequest;
use App\Repositories\CommonRepository;

class AgenecyTermRepository extends CommonRepository implements AgenecyTermRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return AgenecyTerm::class;
    }

    public function filterColumns()
    {
        return [
            $this->translated('name'),
            $this->translated('description'),
            'is_active',
            'agenecyType.translations.name'
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            $this->sortingTranslated('name', 'name'),
            $this->sortingTranslated('description', 'description'),
            'is_active',
            'type'
        ];
    }

    public function store(AgenecyTermRequest $request)
    {
        $data = $request->validated();
        $agenecy = $this->model()::create($data);

        return $agenecy;
    }

    public function updateAgenecyTerm(AgenecyTermRequest $request, AgenecyTerm $agenecyTerm)
    {
        $data = $request->validated();
        $agenecyTerm->update($data);

        return $agenecyTerm;
    }

    public function show($id)
    {
        return  $this->model()::findOrFail($id)->load('agenecyType');
    }
}
