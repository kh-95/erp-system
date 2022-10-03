<?php

namespace App\Modules\HR\Http\Repositories\Employee;

use App\Foundation\Classes\Helper;
use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\HR\Entities\Allowance;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\Management;
use App\Modules\HR\Http\Requests\Employee\StoreRequest;
use App\Modules\HR\Http\Requests\Employee\UpdateRequest;
use App\Modules\HR\Transformers\AllowanceResource;
use App\Modules\HR\Transformers\AttachmentResource;
use App\Modules\HR\Transformers\CustodyResource;
use App\Modules\HR\Transformers\Employee\JobInformationResource;
use App\Modules\HR\Transformers\EmployeeResource;
use App\Repositories\CommonRepository;
use Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeRepository extends CommonRepository implements EmployeeRepositoryInterface
{
    use ImageTrait, ApiResponseTrait;

    public function filterColumns()
    {
        return [
            'id',
            'jobInformation.employee_number',
            'jobInformation.email',
            'first_name',
            'second_name',
            'third_name',
            'last_name',
            'job.id',
            'job.management.id',
            'identification_number',
            'phone',
            'nationally.name',
            'job.receiving_work_date'

        ];
    }

    public function model()
    {
        return Employee::class;
    }

    public function index(Request $request)
    {
        $employees = $this->setFilters()->withOutBlackList()->paginate(Helper::getPaginationLimit($request));
        return $this->paginateResponse(EmployeeResource::collection($employees), $employees);
    }

    public function listEmployees(Request $request)
    {
        return \DB::table('hr_management')->distinct()
            ->when(($request->has('is_active') && $request->is_active), fn($q) => $q->active())
            ->when($request->managment_id, fn($q) => $q->where('hr_management.id', $request->managment_id))
            ->select(
                'hr_employees.id',
                DB::raw('CONCAT(hr_employees.first_name ," ", hr_employees.second_name," " , hr_employees.third_name ," " ,hr_employees.last_name) as name')
            )
            ->join('hr_jobs', 'hr_jobs.management_id', 'hr_management.id')
            ->leftJoin('hr_employee_job_information', 'hr_jobs.id', 'hr_employee_job_information.job_id')
            ->join('hr_employees', 'hr_employees.id', 'hr_employee_job_information.employee_id')
            ->get();
    }

    public function listCustomerServiceEmployees()
    {
        return $this->where(['deactivated_at' => null, 'is_customer_service' => 'true'])->get();
    }

    public function uniqueEmployeeNumber()
    {
        return $this->successResponse($this->model->generateEmployeeNumber());
    }

    public function store($request)
    {
        try {
            $data = $request->except('image');

            $data['image'] = $this->storeImage($request->image, 'employees');

            $employee = $this->create($data);

            // $this->storeRelations($request, $employee);

            // $employee->load(['jobInformation', 'attachments', 'allowances', 'custodies', 'nationality']);

            return $this->successResponse(new EmployeeResource($employee));
        } catch (\Exception $exception) {

            $employee->forceDelete();

            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    // public function storeEmployeeMetaData($requestData)
    // {
    //     $employee = DB::table('employee_meta_data')->where('data->employee_number', $requestData['employee_number'])->first();

    //     if (empty($employee)) {

    //         DB::table('employee_meta_data')->Insert([
    //             'data' => $requestData['data'],
    //         ]);
    //     } else {
    //         $data = json_decode($employee->data, true);
    //         unset($data['step']);
    //         $newStepData = array_unique(array_merge($data, $requestData), SORT_REGULAR);
    //         $employee->update([
    //             'data' => json_encode($newStepData),
    //             'step' => $requestData['step'],
    //         ]);
    //     }

    //     if ($requestData['step'] == 4) {
    //         $data = json_decode($employee->data);
    //         unset($data['step']);
    //         $this->store($data);
    //     }
    // }

    /*-------------deviding store employee into four steps --------------------------*/

    public function storeJobInformation(int $employeeId, $request)
    {
        $employee = $this->find($employeeId);
        $jobInfo = $employee->jobInformation()->create($request);
        return $this->successResponse(new JobInformationResource($jobInfo));
    }

    public function storeAttachements(int $employeeId, $request)
    {
        $employee = $this->find($employeeId);

        $attachments['identity_photo']['file'] = $this->storeImage($request['attachments']['identity_photo'], 'attachments');
        $attachments['identity_photo']['type'] = 'identity_photo';
        $attachments['qualification_photo']['file'] = $this->storeImage($request['attachments']['qualification_photo'], 'attachments');
        $attachments['qualification_photo']['type'] = 'qualification_photo';

        $attachments = $employee->attachments()->createMany($attachments);

        return $this->successResponse(AttachmentResource::collection(collect($attachments)));
    }

    public function storeAllowence(int $employeeId, $request)
    {
        $employee = $this->find($employeeId);
        $employee->allowances()->sync($request);
        $allowances = $employee->allowances;
        return $this->successResponse(AllowanceResource::collection($allowances));
    }

    public function storeCustodies(int $employeeId, $request)
    {
        $employee = $this->find($employeeId);
        $employee->custodies()->createMany($request);
        return $this->successResponse(CustodyResource::collection($employee->custodies));
    }

    /*-------------end deviding store employee into four steps -----------------------*/

    private function storeRelations($request, $employee)
    {
        $employee->jobInformation()->create($request->all());

        $attachments = collect($request->attachments)->map(function ($item, $key) {
            $data['file'] = $this->storeImage($item, 'attachments');
            $data['type'] = $key;
            return $data;
        })->values()->toArray();

        $employee->attachments()->createMany($attachments);

        $employee->allowances()->sync($request->allowances);

        $employee->custodies()->createMany($request->custodies);
    }

    public function show($id)
    {
        $employee = $this->find($id)->load(['jobInformation', 'attachments', 'allowances', 'custodies', 'nationality']);
        return $this->successResponse(new EmployeeResource($employee));
    }

    public function edit($request, $id)
    {
        try {
            $employee = $this->find($id);

            $data = $request->except('image');

            $data['image'] = $request->image
                ? $this->updateImage($request->image, $employee->image, 'employees')
                : $employee->image;

            $employee->update($data);

            $this->updateRelations($request, $employee);

            $employee->load(['jobInformation', 'attachments', 'allowances', 'custodies', 'nationality']);

            return $this->successResponse(new EmployeeResource($employee));
        } catch (\Exception $exception) {

            return $this->errorResponse(null, 500, $exception->getMessage());
        }
    }

    private function updateRelations($request, $employee)
    {
        $employee->jobInformation->update($request->all());

        if ($request->allowances) {
            $employee->allowances()->sync($request->allowances);
        }

        if ($request->attachments) {
            $attachments = collect($request->attachments)->map(function ($item, $key) {
                $data['file'] = $this->storeImage($item, 'attachments');
                $data['type'] = $key;
                return $data;
            })->values()->toArray();

            $employee->attachments()->createMany($attachments);
        }
    }
}
