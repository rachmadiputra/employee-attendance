<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ShiftController; 
use App\Http\Controllers\API\HolidayController;
use App\Http\Controllers\API\CutiController; 
use App\Http\Controllers\API\AssignmentController; 
use App\Http\Controllers\API\AbsenController; 

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function() {
    
    Route::get('/employee', [EmployeeController::class, 'index']);
    Route::post('/employee/create', [EmployeeController::class, 'create']);
    Route::get('/employee/edit/{id}', [EmployeeController::class, 'edit']);
    Route::post('/employee/update/{id}', [EmployeeController::class, 'update']);
    Route::post('/employee/delete/{id}', [EmployeeController::class, 'delete']);

    Route::get('/shift', [ShiftController::class, 'index']);
    Route::post('/shift/create', [ShiftController::class, 'create']);
    Route::get('/shift/edit/{id}', [ShiftController::class, 'edit']);
    Route::post('/shift/update/{id}', [ShiftController::class, 'update']);
    Route::post('/shift/delete/{id}', [ShiftController::class, 'delete']);

    Route::get('/holiday', [HolidayController::class, 'index']);
    Route::post('/holiday/create', [HolidayController::class, 'create']);
    Route::get('/holiday/edit/{id}', [HolidayController::class, 'edit']);
    Route::post('/holiday/update/{id}', [HolidayController::class, 'update']);
    Route::post('/holiday/delete/{id}', [HolidayController::class, 'delete']);

    Route::get('/assignment', [AssignmentController::class, 'index']);
    Route::post('/assignment/add/', [AssignmentController::class, 'assignment']);
    Route::post('/assignment/remove/{id}', [AssignmentController::class, 'unassignment']);

    Route::get('/cuti', [CutiController::class, 'index']);
    Route::post('/cuti/add/', [CutiController::class, 'add']);
    Route::post('/cuti/remove/{id}', [CutiController::class, 'remove']);

    Route::get('/absen', [AbsenController::class, 'index']);
    Route::post('/absen/check_in', [AbsenController::class, 'check_in']);
    Route::post('/absen/check_out', [AbsenController::class, 'check_out']);

    Route::get('/logout', [AuthController::class, 'logout']);

});

Route::post('/login', [AuthController::class, 'login']);
