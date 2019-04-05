<?php

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

Route::post('employee/create', 'EmployeeController@createEmployee');
Route::get('employees', 'EmployeeController@getAllEmployees');
Route::get('departments', 'DepartmentController@getAllDepartments');
Route::post('department/create', 'DepartmentController@createDepartment');
Route::patch('employee/update/{id}', 'EmployeeController@updateEmployee');
Route::patch('department/update/{id}', 'DepartmentController@updateDepartment');
