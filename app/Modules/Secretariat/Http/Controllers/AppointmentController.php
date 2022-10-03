<?php

namespace App\Modules\Secretariat\Http\Controllers;

use App\Foundation\Classes\Helper;
use App\Modules\Secretariat\Http\Requests\AppointmentRequest;
use App\Modules\Secretariat\Http\Repositories\Appointment\AppointmentRepositoryInterface;
use App\Modules\Secretariat\Transformers\AppointmentResource;
use App\Modules\Secretariat\Entities\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Foundation\Traits\ApiResponseTrait;
use Illuminate\Http\Request;


class AppointmentController extends Controller
{
    use ApiResponseTrait;
    /**
     * @var AppointmentRepository
     */
    private AppointmentRepositoryInterface  $appointmentRepository;
    /**
     * Create a new AppointmentController instance.
     *
     * @param AppointmentRepository $appointmentRepository
     */
    public function __construct(AppointmentRepositoryInterface $appointmentRepository)
    {
        $this->appointmentRepository = $appointmentRepository;
        $this->middleware('permission:list-appointment')->only(['index', 'show']);
        $this->middleware('permission:create-appointment')->only(['store']);
        $this->middleware('permission:edit-appointment')->only(['update']);
        $this->middleware('permission:delete-appointment')->only(['destroy']);
        $this->middleware('permission:archive-appointment')->only(['onlyTrashed','restore']);

    }

    /**
     * Get all appointments
     *
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $appointments = $this->appointmentRepository->setfilters()
        ->defaultSort('-created_at')
        ->allowedSorts($this->appointmentRepository->sortColumns())
        ->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(AppointmentResource::collection($appointments),$appointments);
    }

    /**
     * Create a appointment.
     *
     * @param appointmentRequest $request
     * @return JsonResponse
     */
    public function store(AppointmentRequest $request): JsonResponse
    {
          return  $appointment = $this->appointmentRepository->store($request);
    }

    /**
     * Show the specified appointment.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $appointment = $this->appointmentRepository->find($id);
        return $this->successResponse(new AppointmentResource($appointment));
    }

    /**
     * Update the specified appointment.
     *
     * @param AppointmentRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(AppointmentRequest $request, $id): JsonResponse
    {
       return $this->appointmentRepository->updateappointment($request, $id);
    }

    /**
     * Remove the specified appointment.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        return $this->appointmentRepository->destroy($id);
    }


    /**
     * Get all trashed appointments
     *
     * @return JsonResponse
     */
    public function onlyTrashed()
    {
        return $this->successResponse($this->appointmentRepository->onlyTrashed()->get());
    }

     /**
     * restore trashed appointment
     *
     * @return JsonResponse
     */
    public function restore($id)
    {
        return $this->appointmentRepository->restore($id);
    }
}
