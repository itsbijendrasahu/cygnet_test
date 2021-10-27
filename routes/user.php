<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('user/login', 'APIController@userLogin')->name('userLogin');
Route::group(['prefix' => 'user', 'middleware' => ['auth:user-api', 'scopes:user']], function () {
    // authenticated staff routes here
    Route::get('dashboard', 'APIController@userDashboard');
});
