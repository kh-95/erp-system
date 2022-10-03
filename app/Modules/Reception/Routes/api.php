<?php

namespace App\Modules\Reception\Routes;

use App\Modules\Reception\Http\Controllers\ReceptionReportController;
use Illuminate\Support\Facades\Route;
use App\Modules\Reception\Http\Controllers\VisitController;
use App\Modules\Reception\Http\Controllers\VisitorController;

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/reception_report/update_status/{id}/{status}', [ReceptionReportController::class, 'updateStatus']);
    Route::get('/reception_report/archive', [ReceptionReportController::class, 'archive']);
    Route::get('/reception_report/restore/{id}', [ReceptionReportController::class, 'restore']);
    Route::get('/reception_report/activities/{id}', [ReceptionReportController::class, 'activities']);
    Route::resource('reception_report', ReceptionReportController::class);

    Route::resource('/visit', VisitController::class)->except(['create']);
    Route::get('/visit/restore/{id}', [VisitController::class,'restore']);
    Route::get('/visit/activity/{id}', [VisitController::class,'activities']);

    Route::put('/visitStatus/{id}', [VisitController::class,'updateStatus']);
    Route::post('/visitor/visit/{id}',[VisitorController::class,'store']);
    Route::put('/visitor/{id}',[VisitorController::class,'update']);
    Route::delete('/visitor/{id}',[VisitorController::class,'destroy']);
    Route::get('/visitor/{id}/edit',[VisitorController::class,'edit']);
    Route::get('/visitors/{visit_id}',[VisitorController::class,'index']);
    Route::get('/visitor/activity/{id}', [VisitController::class,'activities']);

});

