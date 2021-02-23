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
    Route::post('register', [AuthController::class, 'register']);
    
    Route::group(['middleware' => ['auth:api', 'role:admin']], function() {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);
    });
    
});

Route::group(['middleware' => ['auth:api']], function() {
    Route::resource('shipments', ShipmentController::class);
    Route::group(['middleware' => ['role:admin']], function() {
        Route::resource('users', UserController::class);
        
        Route::get('test', function() {
            if(\Auth::user()->hasrole('admin')) {
                return 'fuck you';
            } else {
                return 'hey man';
            }
        });
    });

    // Route::group(['middleware' => ['role:admin']], function() {
        
    // });
   
});


