<?php

namespace App\Modules\RiskManagement\Http\Repositories\VendorClass;


use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Entities\VendorClass;
use App\Modules\RiskManagement\Http\Repositories\VendorClass\VendorClassRepositoryInterface;
use App\Repositories\CommonRepository;


class VendorClassRepository extends CommonRepository implements VendorClassRepositoryInterface
{
    use  ApiResponseTrait;

    public function model()
    {
        return VendorClass::class;
    }

    public function filterColumns()
    {
        return [
            'id',
            'name',
            'is_active',

        ];
    }


    public function listClasses()
    {
        return $this->ListsTranslations('name')
            ->addSelect('rm_vendor_classes.id')
            ->get();
    }
}
