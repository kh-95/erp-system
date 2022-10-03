<?php

namespace App\Modules\RiskManagement\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\RiskManagement\Http\Repositories\VendorClass\VendorClassRepositoryInterface;
use App\Modules\RiskManagement\Transformers\VendorClassResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClassController extends Controller
{
    use ApiResponseTrait;
    public function __construct(private VendorClassRepositoryInterface $classRepository)
    {
        // $this->middleware('permission:list-vendor_class')->only(['index']);
    }

    public function index(Request $request)
    {
        $classes = $this->classRepository
            ->setFilters()
            ->paginate(Helper::getPaginationLimit($request));

        $data = VendorClassResource::collection($classes);
        return $this->paginateResponse($data, $classes);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('riskmanagement::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('riskmanagement::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }

    public function listClasses()
    {
        return $this->successResponse($this->classRepository->listClasses());
    }
}
