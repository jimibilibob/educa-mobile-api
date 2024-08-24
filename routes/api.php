<?php

use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveRequestTypesController;
use App\Models\LeaveRequestType;
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

Route::apiResource('leave-request-types', LeaveRequestTypesController::class)
    ->only('index', 'show', 'destroy');

Route::apiResource('leave-requests', LeaveRequestController::class)
    ->only('index', 'show', 'destroy', 'store')
    ->names([
        'index' => 'leave-requests.index',
        'show' => 'leave-requests.show',
        'destroy' => 'leave-requests.destroy',
        'store' => 'leave-requests.store'
    ]);;
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
