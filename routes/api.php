<?php

use App\Http\Controllers\MovieController;
use App\Http\Middleware\AuthenticateApi;
use Illuminate\Support\Facades\Route;

Route::middleware([AuthenticateApi::class])->group(function () {
    Route::group(['prefix' => 'movies'], function () {
        Route::get('/', [MovieController::class, 'index']);
        Route::post('/', [MovieController::class, 'store']);
        Route::get('/{movie}', [MovieController::class, 'show']);
        Route::put('/{movie}', [MovieController::class, 'update']);
        Route::delete('/{movie}', [MovieController::class, 'destroy']);
    });

    Route::group(['prefix' => 'movies/{movie}/broadcasts'], function () {
        Route::post('/', [MovieController::class, 'addBroadcast']);
    });
});
