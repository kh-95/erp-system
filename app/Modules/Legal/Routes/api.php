<?php

use App\Modules\Legal\Http\Controllers\CaseAgainestCompanyController;
use App\Modules\Legal\Http\Controllers\AgenecyController;
use App\Modules\Legal\Http\Controllers\DraftController;
use App\Modules\Legal\Http\Controllers\ConsultController;
use App\Modules\Legal\Http\Controllers\AgenecyTermController;
use App\Modules\Legal\Http\Controllers\AgenecyTypeController;
use Illuminate\Support\Facades\Route;
use App\Modules\Legal\Http\Controllers\CompanyCaseController;
use App\Modules\Legal\Http\Controllers\InvestigationController;
use App\Modules\Legal\Http\Controllers\OrderModelsController;
use App\Modules\Legal\Http\Controllers\StaticTextController;

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('agenecy_types', AgenecyTypeController::class);

    Route::resource('agenecies', AgenecyController::class);
    Route::resource('agenecy_terms', AgenecyTermController::class);
    Route::resource('static_texts', StaticTextController::class);

    Route::resource('company_cases', CompanyCaseController::class)->except('create', 'edit');

    Route::resource('draft_requests', DraftController::class)->except(['create', 'destroy']);

    Route::resource('order_models', OrderModelsController::class)->except(['create']);
    Route::delete('delete_attachment_order/{id}', [OrderModelsController::class, 'deleteAttachmentOrder']);

    Route::resource('investigations', InvestigationController::class);

    Route::resource('consult_requests', ConsultController::class)->except(['create', 'destroy']);

    Route::post('consult_response/{id}', [ConsultController::class,'responseConsult']);


    Route::resource('case_againest_companies', CaseAgainestCompanyController::class)->except('destroy');
    Route::resource('judicial_departments', JudicialDepartmentController::class);
});
