<?php

use Illuminate\Http\Request;
use App\Modules\Finance\Http\Controllers\AssetController;
use App\Modules\Finance\Http\Controllers\ExpenseTypeController;
use App\Modules\Finance\Http\Controllers\ReceiptTypeController;
use App\Modules\Finance\Http\Controllers\CashRegisterController;
use App\Modules\Finance\Http\Controllers\NotificationController;

use App\Modules\Finance\Http\Controllers\AccountingTreeController;
;


use App\Modules\Finance\Http\Controllers\AssetCategoryController;
use App\Modules\Finance\Http\Controllers\ConstraintTypeController;
use App\Modules\Finance\Http\Controllers\FinancialCustodyController;



use App\Modules\Finance\Http\Controllers\NotificationNameController;
use App\Modules\Finance\Http\Controllers\{ReceiptController,ExpensesController};

Route::middleware('auth:sanctum')->group(function(){
    Route::prefix('asset')->group(function () {
        Route::get('/', [AssetController::class, 'index']);
        Route::get('/{id}', [AssetController::class, 'show']);
        Route::get('/{id}/edit', [AssetController::class, 'edit']);
        Route::post('/store', [AssetController::class, 'store']);
        Route::post('/{id}/update', [AssetController::class, 'update']);
        Route::delete('{id}/delete', [AssetController::class, 'destroy']);
    });

    Route::prefix('custody')->group(function () {
        Route::get('/', [FinancialCustodyController::class, 'index']);
        Route::get('/{id}', [FinancialCustodyController::class, 'show']);
        Route::get('/{id}/edit', [FinancialCustodyController::class, 'edit']);
        Route::post('/store', [FinancialCustodyController::class, 'store']);
        Route::post('/{id}/update', [FinancialCustodyController::class, 'update']);
        Route::delete('{id}/delete', [FinancialCustodyController::class, 'destroy']);
    });

    /*accounts routing*/
    Route::get('/accountingtrees/toggle_status/{id}', [AccountingTreeController::class, 'togglestatus']);
    Route::get('/accountingtrees/edit/{id}', [AccountingTreeController::class, 'edit']);
    Route::get('/accountingtrees/uniqueaccountnumber', [AccountingTreeController::class, 'uniqueaccountNumber']);
    Route::get('/accountingtrees/parentaccounts/{id}', [AccountingTreeController::class, 'parentaccounts']);
    Route::get('/accountingtrees/childsaccounts/{id}', [AccountingTreeController::class, 'childsaccounts']);
    Route::post('/accountingtrees/updateparentaccount/{id}', [AccountingTreeController::class, 'updateparentaccount']);
    Route::post('/accountingtrees/updatechildaccount/{id}', [AccountingTreeController::class, 'updatechildaccount']);
    Route::get('/accountingtrees/forExternalServices', [AccountingTreeController::class, 'forExternalServices']);
    Route::resource('accountingtrees', AccountingTreeController::class);
    /*End resignation Routing */

    /*Asset Category routing*/
    Route::get('/assetcategories/toggle_status/{id}', [AssetCategoryController::class, 'togglestatus']);
    Route::get('/assetcategories/edit/{id}', [AssetCategoryController::class, 'edit']);
    Route::get('/assetcategories/uniqueaccountnumber', [AssetCategoryController::class, 'uniqueaccountNumber']);
    Route::resource('assetcategories', AssetCategoryController::class);
    /*End Asset Category Routing */

    /*Constrait type routing*/
    Route::get('/constraittypes/toggle_status/{id}', [ConstraintTypeController::class, 'togglestatus']);
    Route::get('/constraittypes/edit/{id}', [ConstraintTypeController::class, 'edit']);
    Route::resource('constraittypes', ConstraintTypeController::class);
    /*End Constrait type Routing */

     /*Expense type routing*/
     Route::get('/expensetypes/toggle_status/{id}', [ExpenseTypeController::class, 'togglestatus']);
     Route::get('/expensetypes/edit/{id}', [ExpenseTypeController::class, 'edit']);
     Route::resource('expensetypes', ExpenseTypeController::class);
     /*End Expense type Routing */

     /*Receipt type routing*/
     Route::get('/receipttypes/toggle_status/{id}', [ReceiptTypeController::class, 'togglestatus']);
     Route::get('/receipttypes/edit/{id}', [ReceiptTypeController::class, 'edit']);
     Route::resource('receipttypes', ReceiptTypeController::class);
     /*End Receipt type Routing */

     /*Notification Name routing*/
     Route::get('/notificationnames/toggle_status/{id}', [NotificationNameController::class, 'togglestatus']);
     Route::get('/notificationnames/edit/{id}', [NotificationNameController::class, 'edit']);
     Route::resource('notificationnames', NotificationNameController::class);
     /*End NotificationName Routing */

    Route::resource('notification',NotificationController::class)->except('create');
    Route::delete('notification/attachment/{id}',[NotificationController::class, 'removeAttachment']);


    Route::resource('cashRegister',CashRegisterController::class)->except('create');
    Route::delete('cashRegister/attachment/{id}',[CashRegisterController::class, 'removeAttachment']);


    Route::resource('receipt',ReceiptController::class)->except('create');
    Route::delete('receipt/attachment/{id}',[ReceiptController::class, 'removeAttachment']);

    Route::resource('expense',ExpensesController::class)->except('create');
    Route::delete('expense/attachment/{id}',[ExpensesController::class, 'removeAttachment']);


});

