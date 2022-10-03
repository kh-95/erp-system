<?php

use App\Modules\RiskManagement\Http\Controllers\ClassController;
use App\Modules\RiskManagement\Http\Controllers\NotificationController;
use App\Modules\RiskManagement\Http\Controllers\NotificationVendorController;
use App\Modules\RiskManagement\Http\Controllers\VendorController;
use App\Modules\RiskManagement\Http\Controllers\TransactionController;
use App\Modules\RiskManagement\Http\Controllers\BankController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('notifications_vendors/take_action/{notificationVendor}', [NotificationVendorController::class,'takeAction']);
    Route::get('/notifications/activities/{notification}', [NotificationController::class, 'activities']);
    Route::get('/notifications_vendors/activities/{notificationVendor}', [NotificationVendorController::class, 'activities']);
    Route::resource('notifications_vendors', NotificationVendorController::class)->only(['index', 'show']);
    Route::resource('notifications', NotificationController::class);

    Route::resource('vendors', VendorController::class)->only(['index', 'show']);
    Route::resource('vendor_class', ClassController::class)->only('index');

    Route::get('get_vendor/{identity_number}', [VendorController::class, 'getVendor']);

    Route::resource('transactions', TransactionController::class)->only(['index', 'show']);
    Route::get('list_banks', [BankController::class, 'listBanks']);
    Route::resource('banks', BankController::class);
    Route::get('list_classes', [ClassController::class, 'listClasses']);

});
