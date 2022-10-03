<?php

namespace App\Modules\HR\Tests;

use App\Modules\HR\Database\factories\EmployeeJobInformationFactory;
use App\Modules\HR\Entities\Employee;
use App\Modules\HR\Entities\EmployeeJobInformation;
use App\Modules\User\Entities\Permission;
use App\Modules\User\Entities\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\CreatesApplication;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    private function getUserWithPermission(string $permission)
    {
        $permission = Permission::firstOrCreate([
            'name' => $permission,
            'slug' => $permission
        ]);
        $employeeJobInformation = EmployeeJobInformation::factory()->create();
        $user = User::create([
        'employee_number' => $employeeJobInformation->employee_number,
        'employee_id' => $employeeJobInformation->employee_id,
        'password' => 123456,
        ]);
        $user->givePermissionTo($permission);
        return $user;

    }

    public function actingAsWithPermission(string $permission)
    {
        $user = $this->getUserWithPermission($permission);
        return $this->actingAs($user, 'sanctum');
    }

}
