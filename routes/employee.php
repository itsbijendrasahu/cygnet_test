<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('employee/login', 'APIController@employeeLogin')->name('employeeLogin');
Route::group(['prefix' => 'employee', 'middleware' => ['auth:employee-api', 'scopes:employee']], function () {
    // authenticated staff routes here
    Route::get('dashboard', 'APIController@employeeDashboard');
});
