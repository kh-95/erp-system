<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('artisan_command/{command}', function ($command) {
    ini_set('max_execution_time', 300);
    if ($command) {
        \Artisan::call($command);
    }
});

Route::get('test',function(){
    dd(\App\Modules\HR\Entities\Interviews\Interview::first()->addedBy);
});
