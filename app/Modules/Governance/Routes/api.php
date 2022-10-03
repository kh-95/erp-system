<?php

use App\Modules\Governance\Http\Controllers\MemberController;
use App\Modules\Governance\Http\Controllers\MeetingController;
use App\Modules\Governance\Http\Controllers\CommitteeController;
use App\Modules\Governance\Http\Controllers\SuccessionController;
use App\Modules\Governance\Http\Controllers\RegulationsController;

use App\Modules\Governance\Http\Controllers\MeetingPlaceController;
use App\Modules\Governance\Http\Controllers\NotificationController;
use App\Modules\Governance\Http\Controllers\StrategicPlanController;
use App\Modules\Governance\Http\Controllers\CandidacyApplicationController;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('strategic_plans', StrategicPlanController::class);
    Route::get('directorship_members/get_single_member/{id}', [MemberController::class, 'getSingleMember']);
    Route::get('directorship_members/get_active_directories', [MemberController::class, 'getActiveDirectories']);
    Route::get('directorship_members/is_there_another_director', [MemberController::class, 'isThereAnotherDirector']);
    Route::post('directorship_members/assign_as_director/{id}', [MemberController::class, 'assignAsPresidentOfDirectorship']);
    Route::post('governance_meetings/accept_meeting_from_super_admin/{meeting_id}/{employee_id}', [MeetingController::class,'acceptMeetingFromSuperAdmin']);
    Route::post('governance_meetings/reject_meeting_from_super_admin/{meeting_id}/{employee_id}', [MeetingController::class,'rejectMeetingFromSuperAdmin']);
    Route::post('governance_meetings/accept_meeting/{meeting_id}', [MeetingController::class,'acceptMeeting']);
    Route::post('governance_meetings/reject_meeting/{meeting_id}', [MeetingController::class,'rejectMeeting']);
    Route::post('governance_meetings/cancel_meeting/{meeting_id}', [MeetingController::class,'cancelMeeting']);
    Route::resource('directorship_members', MemberController::class)->only(['show', 'update', 'index']);
    Route::resource('governance_notifications', NotificationController::class)->only(['index', 'store', 'update', 'show']);
    Route::post('governance_notifications/storeResponse/{id}', [NotificationController::class, 'storeResponse']);
    Route::resource('meeting_places', MeetingPlaceController::class);
    Route::resource('governance_meetings', MeetingController::class);
    // Route::get()


    Route::resource('regulations', RegulationsController::class)->except(['create']);

    Route::delete('delete_attachment_regulation/{id}', [RegulationsController::class, 'deleteAttachmentRegulation']);

    Route::resource('successions', SuccessionController::class)->except('create', 'edit');

    Route::resource('committees', CommitteeController::class)->except(['create','edit']);

    Route::resource('candidacy_applications', CandidacyApplicationController::class)->except(['create']);
    Route::delete('delete_attachment_candidacy/{id}', [CandidacyApplicationController::class, 'deleteAttachmentCandidacy']);


});
