<?php

namespace App\Modules\Finance\Http\Repositories;

use App\Repositories\CommonRepository;
use App\Modules\Finance\Entities\Asset;
use App\Modules\Finance\Entities\AssetTranslation;
use App\Modules\Finance\Http\Repositories\AssetRepositoryInterface;

class AssetRepository extends CommonRepository implements AssetRepositoryInterface
{
    protected function filterColumns(): array
    {
        return [
            'name',
            'category',
            'measure_unit'
        ];
    }

    public function store($request)
    {
       return $this->model->create($request);
    }

    public function update($request, $id)
    {
        return $this->model->find($id)->update($request);
    }

    public function destroy($id)
    {
        $this->model->find($id)->delete();
        $translations = AssetTranslation::where('asset_id',$id)->get();
        foreach($translations as $translation){
            $translation->delete();
        }
    }

    public function model()
    {
        return Asset::class;
    }
}
