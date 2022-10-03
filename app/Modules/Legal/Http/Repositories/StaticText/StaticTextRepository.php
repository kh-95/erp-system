<?php

namespace App\Modules\Legal\Http\Repositories\StaticText;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\Legal\Entities\StaticText\StaticText;
use App\Modules\Legal\Http\Requests\StaticTextRequest;
use App\Repositories\CommonRepository;

class StaticTextRepository extends CommonRepository implements StaticTextRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return StaticText::class;
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

    public function store(StaticTextRequest $request)
    {
        $data = $request->validated();
        $agenecy = $this->model()::create($data);

        return $agenecy;
    }

    public function updateStaticText(StaticTextRequest $request, StaticText $staticText)
    {
        $data = $request->validated();
        $staticText->update($data);

        return $staticText;
    }

    public function show($id)
    {
        return  $this->model()::findOrFail($id);
    }
}
