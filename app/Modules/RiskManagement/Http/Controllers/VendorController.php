<?php

namespace App\Modules\RiskManagement\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Http\Repositories\Vendor\VendorRepositoryInterface;
use App\Modules\RiskManagement\Transformers\VendorResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VendorController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private VendorRepositoryInterface $vendorRepository,
    )
    {

//        $this->middleware('permission:vendors')->only(['index']);
//        $this->middleware('permission:show-vendors')->only(['show']);

    }

    public function index(Request $request)
    {
        $fingerprints = $this->vendorRepository->setFilters()
            ->defaultSort('-created_at')
            ->customDateFromTo($request)
            ->allowedSorts($this->vendorRepository->sortColumns())
            ->paginate(Helper::getPaginationLimit($request));
        $data = VendorResource::collection($fingerprints);

        return $this->paginateResponse($data, $fingerprints);
    }

    public function show($id)
    {
        $vendor = $this->vendorRepository->show($id);
        return $this->successResponse(VendorResource::make($vendor));
    }

    public function getVendor($identity_number)
    {
        $vendor = $this->vendorRepository->getVendor($identity_number);
        return $this->successResponse(VendorResource::make($vendor));
    }
}
