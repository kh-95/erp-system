<?php

namespace App\Modules\Secretariat\Http\Repositories\Appointment;

use App\Modules\Secretariat\Http\Requests\AppointmentRequest;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;
use App\Repositories\CommonRepositoryInterface;

interface AppointmentRepositoryInterface extends CommonRepositoryInterface
{
    public function destroy($id);
    public function updateappointment(AppointmentRequest $request,$id);

}
