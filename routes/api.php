<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShipmentController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {

    Route::post('login', [AuthController::class, 'login']);
    
    Route::group(['middleware' => ['auth:api']], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
    
});

Route::group(['middleware' => ['auth:api']], function() {
    Route::group(['middleware' => ['role:admin']], function() {
        Route::resource('users', UserController::class);
    });

    Route::group(['middleware' => ['role:admin|developer']], function() {
        Route::resource('shipments', ShipmentController::class);
        Route::get('print_shipments', [ShipmentController::class, 'printShipments']);
        Route::post('shipments/file_upload', [ShipmentController::class, 'file_upload']);
    });
    Route::group(['middleware' => ['role:admin|developer|driver']], function() {
        Route::get('shipments/get_status/{shipment}', [ShipmentController::class, 'get_status']);
        Route::put('shipments/update_status/{shipment}', [ShipmentController::class, 'update_status']);
        Route::put('shipments/schedule_delivery/{shipment}', [ShipmentController::class, 'schedule_delivery']);
    });

    Route::group(['middleware' => ['role:driver']], function() {
        Route::put('shipments/assign_shipment_driver/{shipment}', [ShipmentController::class, 'assign_shipment_driver']);
    });
});


