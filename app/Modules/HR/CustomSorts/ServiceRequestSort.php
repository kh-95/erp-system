<?php

namespace App\Modules\HR\CustomSorts;

use Builder;
class ServiceRequestSort {

    public function __invoke(Builder $query, bool $descending, $request)
    {
        $direction = $descending ? 'DESC' : 'ASC';
        if($request->has('management_id') && $request->management_id){
            $query->join('managements','managements.id','hr_service_requests.management_id')
            ->orderBy('managements.name',$direction);
        }elseif($request->has('employee_id') && $request->employee_id){
            $query->join('employees','employees.id','hr_service_requests.employee_id')
            ->orderBy('employees.first_name',$direction)
            ->orderBy('employees.second_name',$direction)
            ->orderBy('employees.third_name',$direction)
            ->orderBy('employees.last_name',$direction);
        }

    }
}
