<?php

use App\Modules\User\Http\Controllers\AuthController;
use App\Modules\User\Http\Controllers\PermissionController;
use App\Modules\User\Http\Controllers\RoleController;
use App\Modules\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/login', [AuthController::class, 'login']);
Route::post('/acceptForgetPassword', [AuthController::class, 'acceptForgetPassword']);
Route::post('/validateOtp', [AuthController::class, 'validateOtp']);
Route::post('/forgetPassword', [AuthController::class, 'forgetPassword']);

Route::middleware('auth:sanctum')->group(function () {

    Route::resource('users', UserController::class)->except(['create', 'edit']);
    Route::delete('userImage/{id}', [UserController::class, 'destroyImage']);
    Route::put('userImage/{id}', [UserController::class, 'updateImage']);

    Route::get('permissions/forExternalServices', [PermissionController::class, 'forExternalServices']);
    Route::resource('permissions', PermissionController::class)->except(['create', 'edit', 'show']);

    Route::get('roles/forExternalServices', [RoleController::class, 'forExternalServices']);
    Route::resource('roles', RoleController::class)->except(['create', 'edit']);

    Route::post('/logout', [AuthController::class, 'logout']);
});


