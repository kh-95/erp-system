<?php

namespace App\Modules\Secretariat\Http\Repositories\Appointment;

use App\Foundation\Classes\Helper;
use App\Modules\Secretariat\Http\Requests\AppointmentRequest;
use App\Modules\Secretariat\Entities\Appointment;
use App\Repositories\CommonRepository;
use Spatie\QueryBuilder\QueryBuilder;
use App\Foundation\Traits\ApiResponseTrait;
use App\Modules\HR\Entities\Employee;
use App\Modules\Secretariat\Transformers\AppointmentResource;
use App\Repositories\CommonRepositoryInterface;

class AppointmentRepository extends CommonRepository implements AppointmentRepositoryInterface
{
    use ApiResponseTrait;
    protected function filterColumns() :array
    {
        return [
            $this->translated('title'),
            'appointment_date',
            $this->getTimeAttribute('appointment_time'),
            $this->getTimeFormatAttribute('appointment_am'),
            'employee_id',
            'id',
            'status'

        ];
    }
    public function sortColumns()
    {
        return [
            $this->sortUsingRelationship('employee-name',Employee::getTableName().'.'. Appointment::getTableName().'.'.'employee_id.first_name'),
            'appointment_date',
            $this->getTimeAttribute('appointment_date'),
            $this->sortingTranslated('title', 'title'),
            'status',
            'details'

        ];
    }
    public function model()
    {
        return Appointment::class;
    }


    public function destroy($id)
    {
        $appointment = $this->find($id);
        $this->delete($id);
        return $this->successResponse(['message'=>__('secretariat::messages.appointment.deleted_successfuly')]);
    }


    public function restore($id)
    {
        $record=$this->withTrashed()->find($id);
        $record->update([
            'deleted_at' => NULL
        ]);
        return $this->successResponse(['message'=>__('secretariat::messages.appointment.restored_successfuly')]);

    }

    public function store(AppointmentRequest $request)
    {
        try {
        $data = $request->except(['date', 'time', 'time_format']);
        $data['appointment_date'] = Helper::ConcatenateDateTime($request->date, $request->time, $request->time_format);
        $appointment = $this->create($data);
        return $this->successResponse(new AppointmentResource($appointment), message : trans('secretariat::messages.appointment.added_successfuly'));
        } catch (\Exception $exception) {
        return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

    public function updateappointment(AppointmentRequest $request,$id)
    {
        try {
        $appointment = $this->find($id);
        $data = $request->except(['date', 'time', 'time_format']);
        if ($request->has(['date', 'time', 'time_format'])) {
         $data['appointment_date'] = Helper::ConcatenateDateTime($request->date, $request->time, $request->time_format);
        }
        $appointment = $this->update($data, $id);
        $appointment->status = 'future';
         $appointment->save();
        return $this->successResponse(new AppointmentResource($appointment), message : trans('secretariat::messages.appointment.edit_successfuly'));
        } catch (\Exception $exception) {
          return $this->errorResponse(null, 500 , $exception->getMessage());
        }
    }

}
