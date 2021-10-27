<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('login');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::group(['middleware' => ['auth']], function () {
    // Resource Route for Employees.
    Route::resource('/employees', 'EmployeeController');
    Route::get('/get-employees', 'EmployeeController@getEmployees');
    // Route for get employees for yajra post request.
    Route::get('get-employees', [ProductController::class, 'getProducts'])->name('get-products');
});
