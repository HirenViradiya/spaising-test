<?php

use App\Http\Controllers\EmployeesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/create', [EmployeesController::class, 'create']);
Route::get('/show', [EmployeesController::class, 'show']);
Route::get('/edit/{id}', [EmployeesController::class, 'edit']);
Route::post('/update', [EmployeesController::class, 'update']);
Route::post('/delete/{id}', [EmployeesController::class, 'destroy']);
