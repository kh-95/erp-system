<?php

namespace App\Modules\RiskManagement\Http\Repositories\Vendor;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Entities\Vendor;
use App\Modules\RiskManagement\Http\Repositories\Vendor\VendorRepositoryInterface;
use App\Modules\RiskManagement\Transformers\VendorResource;
use App\Repositories\CommonRepository;

class VendorRepository extends CommonRepository implements VendorRepositoryInterface
{
    use ApiResponseTrait;

    public function model()
    {
        return Vendor::class;
    }

    public function filterColumns()
    {
        return [
            'name',
            'tax_number',
            'commercial_record',
            'class',
            $this->createdAtBetween('created_from'),
            $this->createdAtBetween('created_to'),
            $this->totalPaysBetween('total_pays_from'),
            $this->totalPaysBetween('total_pays_to'),
            'bank',
            'rasid_jack',
            'rasid_maak',
            'rasid_pay',
            'type',
            'subscription',
            'is_active',
        ];
    }


    public function sortColumns()
    {
        return [
            'name',
            $this->sortUsingRelationship('class_name', 'rm_vendor_classes.rm_vendor.class_id.name'),
            'type',
            'commercial_record',
            'tax_number',
            'rasid_jack',
            'rasid_maak',
            'rasid_pay',
            'total_pays',
            'is_active',
        ];
    }


    public function show($id)
    {
        return $this->model()::findOrFail($id);
    }

    public function getVendor($identity_number)
    {
        return $this->model()::firstWhere('identity_number', $identity_number);
    }
}
