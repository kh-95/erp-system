<?php

namespace App\Modules\HR\Services;

use App\Modules\HR\Entities\AttendanceFingerprint;
use Carbon\Carbon;

class CheckAttendance
{
    public static function checkAttendacne($EmployeeFingerprint)
    {
        $rasid_attend_time = date("H:i", strtotime("09:00:00"));
        $rasid_late_time = date("H:i", strtotime("09:30:00"));
        $rasid_early_leave_time = date("H:i", strtotime("16:30:00"));
        $rasid_leave_time = date("H:i", strtotime("17:00:00"));

        // check if attendance late
        if ($EmployeeFingerprint && $EmployeeFingerprint->attened_at) {
            if ($EmployeeFingerprint->attened_at->gt(Carbon::parse($rasid_late_time))) {
                if (!$EmployeeFingerprint->has_permission) {
                    $EmployeeFingerprint->update([
                        'punishment' => AttendanceFingerprint::LATE,
                        'punishment_status' => AttendanceFingerprint::WAITING,
                    ]);
                }
            }
        }

        // check if early leave
        if ($EmployeeFingerprint && $EmployeeFingerprint->leaved_at) {
            if (Carbon::parse($EmployeeFingerprint->leaved_at)->lt(Carbon::parse($rasid_early_leave_time))) {
                if (!$EmployeeFingerprint->has_permission) {
                    $EmployeeFingerprint->update([
                        'punishment' => AttendanceFingerprint::EARLY_LEAVE,
                        'punishment_status' => AttendanceFingerprint::WAITING,
                    ]);
                }
            }
        }

        if (!$EmployeeFingerprint || $EmployeeFingerprint->attended_at == null) {
            if (!$EmployeeFingerprint->has_vacation) {
                AttendanceFingerprint::updateOrCreate(
                    ['employee_id' => $EmployeeFingerprint->employee_id],
                    ['punishment' => AttendanceFingerprint::ABSENCE],
                    ['punishment_status' => AttendanceFingerprint::WAITING]
                );
            }
        }

        if ($EmployeeFingerprint->attended_at == null || $EmployeeFingerprint->leaved_at == null || !$EmployeeFingerprint) {
            $EmployeeFingerprint->updateOrCreate(
                ['employee_id' => $EmployeeFingerprint->employee_id],
                ['punishment' => AttendanceFingerprint::ABSENCE],
                ['punishment_status' => AttendanceFingerprint::WAITING]
            );
        }
    }
}
