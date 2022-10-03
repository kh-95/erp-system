<?php

namespace App\Modules\HR\Http\Controllers;

use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Http\Repositories\HoldHarmless\HoldHarmlessRepositoryInterface;
use App\Modules\HR\Http\Requests\HoldHarmless\DmRequest;
use App\Modules\HR\Http\Requests\HoldHarmless\StoreRequest;
use App\Modules\HR\Http\Requests\HoldHarmless\HrRequest;
use App\Modules\HR\Http\Requests\HoldHarmless\ItRequest;
use App\Modules\HR\Http\Requests\HoldHarmless\LegalRequest;
use App\Modules\HR\Http\Requests\HoldHarmless\FinanceRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class HoldHarmlessController extends Controller
{
    use ApiResponseTrait;

    private HoldHarmlessRepositoryInterface $harmlessRepository;

    public function __construct(HoldHarmlessRepositoryInterface $harmlessRepository)
    {
        $this->harmlessRepository = $harmlessRepository;
        $this->middleware('permission:list-harmless_hold')->only(['index', 'show']);
        $this->middleware('permission:delete-harmless_hold')->only('delete');
        $this->middleware('permission:dm_store-harmless_hold')->only('DMstore');
        $this->middleware('permission:hr_store-harmless_hold')->only('HRstore');
        $this->middleware('permission:it_store-harmless_hold')->only('ITstore');
        $this->middleware('permission:legal_store-harmless_hold')->only('Legalstore');
        $this->middleware('permission:finance_store-harmless_hold')->only('Financestore');
        $this->middleware('permission:archive-harmless_hold')->only('archive');
        $this->middleware('permission:restore-harmless_hold')->only('restore');
    }

    public function index(Request $request)
    {
       return $this->harmlessRepository->index($request);
    }

    public function store(StoreRequest $request)
    {
       return $this->harmlessRepository->store($request->validated());
    }

    public function DMstore(DmRequest $request, $id){
        return $this->harmlessRepository->storeStatusDM($request->validated(), $id);
     }

    public function HRstore(HrRequest $request, $id){
       return $this->harmlessRepository->storeStatusHR($request->validated(), $id);
    }

    public function ITstore(ItRequest $request, $id){
        return $this->harmlessRepository->storeStatusIT($request->validated(), $id);
    }

    public function Legalstore(LegalRequest $request, $id){
        return $this->harmlessRepository->storeStatusLegal($request->validated(), $id);
    }

    public function Financestore(FinanceRequest $request, $id){
        return $this->harmlessRepository->storeStatusFinance($request->validated(), $id);
    }

    public function delete($id){
        return $this->harmlessRepository->remove($id);
    }

    public function show($id){
        return $this->harmlessRepository->show($id);
    }

    public function archive(Request $request){
        return $this->harmlessRepository->archive($request);
    }

    public function restore($id){
        return $this->harmlessRepository->restore($id);
    }

}
