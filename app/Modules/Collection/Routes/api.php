<?php
namespace App\Modules\Collection\Http\Controllers;

namespace App\Modules\Collection\Http\Controllers;
use App\Modules\Collection\Http\Controllers\InstallmentController;
use Illuminate\Http\Request;
use App\Modules\Collection\Http\Controllers\OperationController;
use App\Modules\Collection\Http\Controllers\OrderController;
use App\Modules\Collection\Http\Controllers\RasidMaeakController;
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

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('collection')->group(function () {
        Route::resource('operations', OperationController::class)->only('index', 'show');

        Route::resource('/order', OrderController::class)->except(['edit']);
        Route::delete('/order/attachment/{id}', [OrderController::class, 'removeAttachment']);
        Route::get('/order/activity/{id}', [OrderController::class, 'activities']);
        Route::get('/order/customer_mobile/{mobile}', [OrderController::class, 'getCustomerByMobile']);
        Route::get('/order/customer_identity/{identity}', [OrderController::class, 'getCustomerByIdentity']);
        Route::resource('installments', InstallmentController::class)->only(['index','show']);
    });


        Route::get('/rasid_maeak',  [RasidMaeakController::class, 'index']);
        Route::get('/rasid_maeak/{id}',  [RasidMaeakController::class, 'show']);
});


