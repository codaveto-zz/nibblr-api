<?php

use App\Http\Controllers\DinnerController;
use App\Http\Controllers\DinnerInviteController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
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

Route::prefix( 'user' )->group( function () {
    Route::post( '/loginrequest', [ UserController::class, 'login' ] );
    Route::post( '/createrequest', [ UserController::class, 'create' ] );
    Route::middleware( 'auth:api' )->group( function () {
        Route::get( '/{id}', [ UserController::class, 'show' ] );
        Route::put( '/{id}', [ UserController::class, 'update' ] );
        Route::get( '/', [ UserController::class, 'index' ] );
    } );
} );

Route::middleware( 'auth:api' )->group( function () {
    Route::apiResource( '/dinner', DinnerController::class );
    Route::post( '/dinner/{dinnerId}/joinrequest', [ DinnerInviteController::class, 'joinDinner'] );
    Route::get( '/dinner/{dinnerId}/user', [ DinnerInviteController::class, 'getAllUsers'] );
} );
