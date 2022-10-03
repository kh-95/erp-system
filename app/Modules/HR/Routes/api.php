<?php

namespace App\Modules\HR\Http\Controllers;

use App\Modules\HR\Entities\Allowance;
use App\Modules\HR\Http\Controllers\Contracts\ContractClauseController;
use Illuminate\Support\Facades\Route;
use App\Modules\HR\Http\Controllers\NationalityController;
use Illuminate\Http\Request;
use App\Modules\HR\Http\Controllers\ManagementController;
use App\Modules\HR\Http\Controllers\JobController;
use App\Modules\HR\Http\Controllers\VacationTypeController;
use App\Modules\HR\Http\Controllers\VacationController;

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
    /*Nationality routing*/
    Route::get('/nationalities/toggle_status/{id}', [NationalityController::class, 'togglestatus']);
    Route::get('/nationalities/only_trashed', [NationalityController::class, 'onlyTrashed']);
    Route::get('/nationalities/restore/{id}', [NationalityController::class, 'restore']);
    Route::get('/nationalities/get_list', [NationalityController::class, 'forExternalServices']);
    Route::resource('nationalities', NationalityController::class);
    /*End Nationality Routing */


    /*VacationType routing*/
    Route::get('/vacationtypes/toggle_status/{id}', [VacationTypeController::class, 'togglestatus']);
    Route::get('/vacationtypes/restore/{id}', [VacationTypeController::class, 'restore']);
    Route::get('/vacationtypes/get_list', [VacationTypeController::class, 'forExternalServices']);
    Route::get('/vacationtypes/edit/{id}', [VacationTypeController::class, 'edit']);
    Route::resource('vacationtypes', VacationTypeController::class);
    /*End VacationType Routing */

    /*Vacations routing*/
    Route::get('/vacations/toggle_status/{id}', [VacationController::class, 'togglestatus']);
    Route::get('/vacations/edit/{id}', [VacationController::class, 'edit']);
    Route::get('/vacations/calculatebalance/{id}/{type}', [VacationController::class, 'calculatebalance']);
    Route::resource('vacations', VacationController::class);
    /*End Vacations Routing */
    Route::get('/managements/check_name/{name}', [ManagementController::class, 'checkManagementName']);

    /*resignation routing*/
    Route::get('/resignations/toggle_status/{id}', [ResignationController::class, 'togglestatus']);
    Route::get('/resignations/edit/{id}', [ResignationController::class, 'edit']);
    Route::resource('resignations', ResignationController::class);
    /*End resignation Routing */

    Route::get('/managements/deactivated/{id}', [ManagementController::class, 'deactivated']);
    Route::get('/managements/activities/{id}', [ManagementController::class, 'activities']);
    Route::get('/managements/list', [ManagementController::class, 'forExternalServices']);
    Route::get('/managements/edit/{id}', [ManagementController::class, 'edit']);
    Route::get('/managements/archive', [ManagementController::class, 'archive']);
    Route::get('/managements/restore/{id}', [ManagementController::class, 'restore']);
    Route::get('/managements/check_name/{name}', [ManagementController::class, 'checkManagementName']);
    Route::get('/managements/list_parents', [ManagementController::class, 'listParents']);
    Route::get('/managements/export', [ManagementController::class, 'export']);
    Route::resource('managements', ManagementController::class)->except(['create']);



    Route::get('/jobs/check_name/{name}/{management_id}', [JobController::class, 'checkJobName']);

    Route::get('/jobs/deactivated/{id}', [JobController::class, 'deactivated']);
    Route::get('/jobs/list', [JobController::class, 'forExternalServices']);
    Route::get('/jobs/edit/{id}', [JobController::class, 'edit']);
    Route::get('/jobs/archive', [JobController::class, 'archive']);
    Route::get('/jobs/restore/{id}', [JobController::class, 'restore']);
    Route::get('/jobs/activities/{id}', [JobController::class, 'activities']);
    Route::resource('jobs', JobController::class)->except(['create']);

    Route::get('/salaries/months', [SalaryController::class, 'getSalariesMonths']);
    Route::get('/salaries/status/{id}', [SalaryController::class, 'getSalaryStatus']);
    Route::post('/salaries/change_status', [SalaryController::class, 'changeSalaryStatus']);
    Route::resource('salaries', SalaryController::class);

    Route::prefix('employees')->group(function () {
        Route::get('/uniqueEmployeeNumber', [EmployeeController::class, 'uniqueEmployeeNumber']);
        // Route::post('/{id}/blacklist', [BlackListEmployeeController::class, 'store']);
        Route::post('/{id}/custodies', [CustodyController::class, 'store']);
        Route::put('/custodies/{id}', [CustodyController::class, 'update']);
        Route::delete('/custodies/{id}', [CustodyController::class, 'destroy']);
        Route::post('/{id}/attachments', [AttachmentEmployeeController::class, 'store']);
        Route::put('/attachments/{id}', [AttachmentEmployeeController::class, 'update']);
        Route::delete('/attachments/{id}', [AttachmentEmployeeController::class, 'destroy']);
    });

    Route::resource('employees', EmployeeController::class)->except(['create', 'edit', 'destroy']);
    Route::prefix('store/{employeeId}/')->group(function () {
        Route::post('job-information', [EmployeeController::class, 'storeJobInformation']);
        Route::post('attachments', [EmployeeController::class, 'storeAttachements']);
        Route::post('allowences', [EmployeeController::class, 'storeAllowence']);
        Route::post('custodies', [EmployeeController::class, 'storeCustodies']);
    });

    Route::get('/employees/export', [EmployeeController::class, 'export']);

    Route::resource('blacklists', BlackListController::class)->except(['create', 'destroy']);
    Route::get('/blacklists/activities/{id}', [BlackListController::class, 'activities']);
    Route::resource('service_requests', ServiceRequestController::class);
    Route::delete('service_requests/attachment/{id}', [ServiceRequestController::class, 'removeAttachment']);
    Route::get('service_request/activity/{id}', [ServiceRequestController::class, 'activities']);

    Route::post('service_response/{id}', [ServiceResponseController::class, 'store']);
    Route::delete('service_response/attachment/{id}', [ServiceResponseController::class, 'removeAttachment']);
    Route::get('service_response/activity/{id}', [ServiceResponseController::class, 'activities']);


    Route::get('list_managements', [AttendanceFingerprintController::class, 'listManagements']);
    Route::get('list_employees', [AttendanceFingerprintController::class, 'listEmployees']);
    Route::resource('attendances_fingerprint', AttendanceFingerprintController::class);

    //Deducts Routes
    Route::get('deducts/list_managements', [DeductsController::class, 'listActiveManagements']);
    Route::get('deducts/list_employees', [DeductsController::class, 'listActiveEmployees']);
    Route::get('deducts/get-employee/{employee_number}', [DeductsController::class, 'getEmployeeByNumber']);
    Route::post('deduct_status/{id}', [DeductsController::class, 'deductStatus']);
    Route::resource('deducts', DeductsController::class);
    Route::put('/deducts/{id}', [CustodyController::class, 'update']);


    // Bonus Routes
    Route::resource('bonuses', BonusesController::class)->except(['create']);
    Route::post('bonus_paid/{id}', [BonusesController::class, 'bonusPaid']);
    Route::post('bonus_status/{id}', [BonusesController::class, 'bonusStatus']);


    Route::resource('item', ItemsController::class)->except(['create']);

    Route::get('applications', [ApplicationController::class,'index']);
    Route::get('applications/{id}', [ApplicationController::class,'show']);

    Route::get('interviews/applications', [InterviewsController::class,'indexInteviewApplication']);
    Route::resource('interviews', InterviewsController::class)->except(['create']);

    //    Route::resource('employees', EmployeeController::class)->except(['createManyeate', 'edit', 'destroy']);

    Route::get('list_fingerprint', [AttendanceFingerprintController::class, 'listFingerprint']);
    Route::get('list_managements', [AttendanceFingerprintController::class, 'listManagements']);
    Route::get('list_employees', [AttendanceFingerprintController::class, 'listEmployees']);
    Route::get('list_customer_service_employees', [EmployeeController::class, 'listCustomerServiceEmployees']);
    Route::get('list_methods', [AttendanceFingerprintController::class, 'listMethods']);
    Route::get('list_branches', [AttendanceFingerprintController::class, 'listBranches']);
    Route::get('list_punishments', [AttendanceFingerprintController::class, 'listPunishments']);
    Route::get('list_punishment_status', [AttendanceFingerprintController::class, 'listPunishmentStatus']);
    Route::post('attendance_fingerprints/{employee}', [AttendanceFingerprintController::class, 'updateAttend']);

    Route::resource('attendance_fingerprints', AttendanceFingerprintController::class)->only('index', 'store');

    Route::post('update_status_by_manager/{permission_request}', [PermissionRequestController::class, 'updateStatusByManager']);
    Route::post('update_status_by_hr/{permission_request}', [PermissionRequestController::class, 'updateStatusByHr']);
    Route::get('permission_requests/archive', [PermissionRequestController::class, 'archive']);
    Route::get('permission_request_managements', [PermissionRequestController::class, 'permission_request_managements']);
    Route::resource('permission_requests', PermissionRequestController::class)->only(['index', 'store', 'show', 'destroy']);

    Route::get('job_for_employee', [EmployeeEvaluationController::class, 'getJobForEmpolyee']);
    Route::resource('evaluate_employees', EmployeeEvaluationController::class);

    Route::prefix('Harmless')->group(function () {
        Route::get('', [HoldHarmlessController::class, 'index']);
        Route::get('/archive', [HoldHarmlessController::class, 'archive']);
        Route::get('/show/{id}', [HoldHarmlessController::class, 'show']);
        Route::get('/restore/{id}', [HoldHarmlessController::class, 'restore']);
        Route::delete('/{id}', [HoldHarmlessController::class, 'delete']);
        Route::post('', [HoldHarmlessController::class, 'store']);
        Route::post('/dm_request/{id}', [HoldHarmlessController::class, 'DMstore']);
        Route::post('/hr_request/{id}', [HoldHarmlessController::class, 'HRstore']);
        Route::post('/it_request/{id}', [HoldHarmlessController::class, 'ITstore']);
        Route::post('/legal_request/{id}', [HoldHarmlessController::class, 'Legalstore']);
        Route::post('/finance_request/{id}', [HoldHarmlessController::class, 'Financestore']);
    });
});

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('contract/clause')->group(function () {
        Route::get('/', [ContractClauseController::class, 'index']);
        Route::get('/{id}', [ContractClauseController::class, 'show']);
        Route::get('/{id}/edit', [ContractClauseController::class, 'edit']);
        Route::post('/store', [ContractClauseController::class, 'store']);
        Route::post('/{id}/update', [ContractClauseController::class, 'update']);
    });

    Route::prefix('training-course')->group(function () {
        Route::get('/', [TrainingCourseController::class, 'index']);
        Route::get('/{id}', [TrainingCourseController::class, 'show']);
        Route::get('/{id}/edit', [TrainingCourseController::class, 'edit']);
        Route::post('/store', [TrainingCourseController::class, 'store']);
        Route::post('/{id}/update', [TrainingCourseController::class, 'update']);
        Route::delete('{id}/delete', [TrainingCourseController::class, 'destroy']);
        Route::get('activity/{id}', [TrainingCourseController::class, 'activities']);
    });
});

