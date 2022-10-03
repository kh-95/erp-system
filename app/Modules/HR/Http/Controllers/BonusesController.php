<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\DeductBonus;
use App\Modules\HR\Http\Repositories\Bonus\BonusesRepositoryInterface;
use App\Modules\HR\Http\Requests\BonusRequest;
use App\Modules\HR\Http\Requests\BounsStatusRequest;
use App\Modules\HR\Transformers\AttendanceResource;
use App\Modules\HR\Transformers\BonusResource;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\HR\Http\Requests\BounsPaidRequest;


class BonusesController extends Controller
{
    use ApiResponseTrait;

    private BonusesRepositoryInterface $bonusesRepository;

    public function __construct(BonusesRepositoryInterface $bonusesRepository)
    {
         $this->bonusesRepository = $bonusesRepository;
        // $this->middleware('permission:list-ponuses')->only('index');
        // $this->middleware('permission:show-ponuses')->only(['show']);
        // $this->middleware('permission:create-ponuses')->only('store');
        // $this->middleware('permission:edit-ponuses')->only('update');
        // $this->middleware('permission:bonusStatus-ponuses')->only('bonusStatus');

    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $bonuses = $this->bonusesRepository->setFilters()
            ->allowedIncludes('employee')
            ->where('type', 'bonus')
            ->defaultSort('-created_at')
            ->allowedSorts($this->bonusesRepository->sortColumns())
            ->with(['employee', 'addedBy', 'management'])
            ->paginate(Helper::getPaginationLimit($request));
        $data = BonusResource::collection($bonuses);
        return $this->paginateResponse($data, $bonuses);
    }


    /**
     * Store a newly created resource in storage.
     * @param BonusRequest $request
     * @return Renderable
     */
    public function store(BonusRequest $request)
    {
        $data = $this->bonusesRepository->store($request);
        return $this->apiResource(data: BonusResource::make($data), message: __('Common::message.success_create'));
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $data = $this->bonusesRepository->show($id);
        return $this->apiResource(BonusResource::make($data));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data = $this->bonusesRepository->edit($id);
        return $this->apiResource(data: BonusResource::make($data));
    }

    /**
     * Update the specified resource in storage.
     * @param BonusRequest $request
     * @param int $id
     * @return Renderable
     */
    public function update(BonusRequest $request, $id)
    {
        $data = $this->bonusesRepository->updateBonus($request, $id);
        return $this->apiResource(data: BonusResource::make($data), message: __('Common::message.success_update'));
    }


    public function bonusStatus(BounsStatusRequest $request, $id)
    {
        $data = $this->bonusesRepository->bonusStatus($request, $id);
        return $this->apiResource(data: BonusResource::make($data), message: __('Common::message.success_update'));
    }


    public function bonusPaid(BounsPaidRequest $request, $id)
    {
        $data = $this->bonusesRepository->bonusPaid($request, $id);
        return $this->apiResource(data: BonusResource::make($data), message: __('Common::message.success_update'));
    }

    public function destroy($id)
    {
        return $this->bonusesRepository->destroy($id);
    }



}
