<?php

use App\Http\Controllers\DinnerController;
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
    Route::post( '/login', [ UserController::class, 'login' ] );
    Route::post( '/create', [ UserController::class, 'create' ] );
    Route::middleware( 'auth:api' )->group( function () {
        Route::get( '/{id}', [ UserController::class, 'show' ] );
        Route::put( '/{id}', [ UserController::class, 'update' ] );
    } );
} );

Route::middleware( 'auth:api' )->group( function () {
    Route::apiResource( '/dinner', DinnerController::class );
} );
