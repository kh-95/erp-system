<?php

use App\Modules\CustomerService\Http\Controllers\CallController;
use App\Modules\CustomerService\Http\Controllers\EmployeeController;
use App\Modules\CustomerService\Http\Controllers\MessageController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('convert_call/{call}', [CallController::class, 'convertCall']);
    Route::get('calls', [CallController::class, 'index']);
    Route::get('messages', [MessageController::class, 'index']);
    Route::resource('customer_service_employees',EmployeeController::class)->only('index','show');
});
