<?php

namespace App\Modules\User\Tests\Unit\Auth;

use App\Modules\HR\Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Modules\User\Entities\User;
use App\Providers\RouteServiceProvider;

class UserLoginTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private $baseUrl = RouteServiceProvider::ROUTE_PREFIX . '/login/';

    public function testEmployeenumberAndPasswordRequired()
    {
        $loginData = ['employee_number'=>'','password'=>''];
        $this->json('POST', $this->baseUrl, $loginData, ['Accept' => 'application/json'])
            ->assertStatus(422)
            ->assertJsonStructure([
                'code',
                'errors',
                'exception'
            ]);
    }

    public function testSuccessfulLogin()
    {
        $user = User::factory()->create();

        $loginData = ['employee_number' => $user->employee_number, 'password' => '123456'];

        $this->json('POST', $this->baseUrl, $loginData, ['Accept' => 'application/json'])
            ->assertStatus(200)
            ->assertJsonStructure([
                'code',
                'data',
            ]);

    }
}
