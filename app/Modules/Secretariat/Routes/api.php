<?php


namespace App\Modules\Secretariat\Http\Controllers;

use Illuminate\Support\Facades\Route;
use App\Modules\Secretariat\Http\Controllers\AppointmentController;
use App\Modules\Secretariat\Http\Controllers\EmployeeMeetingController;
use App\Modules\Secretariat\Http\Controllers\MeetingController;
use App\Modules\Secretariat\Http\Controllers\MeetingDecisionController;
use App\Modules\Secretariat\Http\Controllers\MeetingDiscussionPointController;
use App\Modules\Secretariat\Http\Controllers\MeetingRoomController;
use App\Modules\Secretariat\Http\Controllers\MessageController;
use Illuminate\Http\Request;
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

Route::middleware('auth:sanctum')->group(function () {

     /*Appointment routing*/
     Route::get('/appointments/only_trashed', [AppointmentController::class, 'onlyTrashed']);
     Route::get('/appointments/restore/{id}', [AppointmentController::class, 'restore']);
     Route::resource('appointments', AppointmentController::class);
     /*End Appointment Routing */

    Route::resource('meeting_rooms', MeetingRoomController::class)->except(['create', 'edit', 'show']);
    Route::prefix('meetings')->group(function () {

        Route::get('/{id}/edit', [MeetingController::class, 'edit']);
        Route::get('', [MeetingController::class, 'index']);
        Route::post('', [MeetingController::class, 'store']);
        Route::put('/{id}', [MeetingController::class, 'update']);
        Route::get('/{id}', [MeetingController::class, 'show']);
        Route::delete('/{id}', [MeetingController::class, 'destroy']);
        Route::resource('/{id}/decisions', MeetingDecisionController::class)->only(['store', 'update', 'destroy']);
        Route::get('/activity/{id}', [MeetingController::class, 'activities']);

        Route::post('/{id}/discussion_points', [MeetingDiscussionPointController::class,'store']);
        Route::put('/discussion_points/{id}/update', [MeetingDiscussionPointController::class, 'update']);
        Route::delete('/discussion_points/{id}', [MeetingDiscussionPointController::class, 'destroy']);
        Route::get('discussion_points/activity/{id}', [MeetingDiscussionPointController::class, 'activities']);

    });

    Route::resource('message',MessageController::class)->except('edit');
    Route::get('message/activity/{id}',[MessageController::class,'activities']);
    Route::get('message/restore/{id}',[MessageController::class,'restore']);


    Route::resource('employee_meetings', EmployeeMeetingController::class)->only(['index', 'update']);

});
