<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => 'admin'], function () {
Route::resource('company', CompanyController::class);
Route::resource('employee', EmployeeController::class);
Route::get('/index1/company',[CompanyController::class , 'index1']);
Route::get('/index1/employee',[EmployeeController::class , 'index1']);
});