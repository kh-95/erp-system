<?php

namespace App\Modules\Governance\Http\Repositories\Member;

use App\Foundation\Traits\ApiResponseTrait;
use App\Foundation\Traits\ImageTrait;
use App\Modules\Governance\Http\Requests\Member\MemberRequest;
use App\Modules\Governance\Http\Requests\Member\AssigneAsDirectorRequest;
use App\Modules\Governance\Transformers\MemberResource;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Repositories\CommonRepository;
use Arr;

class MemberRepository extends CommonRepository implements MemberRepositoryInterface
{
    use ApiResponseTrait, ImageTrait;

    public function model()
    {
        return Employee::class;
    }

    public function filterColumns()
    {
        return [
            'first_name',
            'second_name',
            'third_name',
            'last_name',
            'identification_number',
            'jobInformation.receiving_work_date',
            'phone',
            'qualification',
            'nationality_id',
            'directorate'
        ];
    }


    public function sortColumns()
    {
        return [
            'id',
            'first_name',
            'identification_number',
            'phone',
            'qualification',
            'deactivated_at',
            $this->sortUsingRelationship('receiving_work_date',EmployeeJobInformation::getTableName().'.'. Employee::getTableName().'.'.'employee_id.receiving_work_date'),

        ];
    }

    public function updateMember(MemberRequest $request, $id)
    {
        $employee = $this->model()::directorMemeber()->findOrFail($id);
        $data = $request->validated();
        $employee->update(Arr::except($data, ['attachments', 'another_certifications', 'courses']));
        $this->storeRelationships($employee, $request);

        return $employee;
    }

    public function assignAsDirector(AssigneAsDirectorRequest $request, $id)
    {
        $employee = $this->model()::directorMemeber()->findOrFail($id);
        $employee->update(['is_directorship_president' => (bool)$request->is_president]);

        return $employee;
    }

    public function show($id)
    {
        return $this->model()::directorMemeber()->findOrFail($id);
    }

    public function getSingleMember($id)
    {
        $member = Employee::query()
            ->where('id', $id)
            ->directorMemeber()
            ->active()
            ->first();

        if (!$member) $this->errorResponse(message: trans('governance::messages.general.employee_not_found'));

        return $this->apiResource(MemberResource::make($member));
    }

    private function storeRelationships($employee, $request)
    {
        if ($request->isMethod('PUT') && $request->attachments != null) {
            $employee->attachments()->delete();
            $employee->attachments->map(function ($item, $key) {
                $this->deleteImage($item, 'attachments');
            });
        }

        if ($request->has('attachments') && $request->attachments != null) {
            $attachments = collect($request->attachments)->map(function ($item, $key) {
                $data['file'] = $this->storeImage($item, 'attachments');
                $data['type'] = $key;
                return $data;
            })->values()->toArray();

            $employee->attachments()->createMany($attachments);
        }
    }


    public function getActiveDirectories()
    {
        $members = Employee::query()
            ->directorMemeber()
            ->active()
            ->get();
        return $members;
    }
}
