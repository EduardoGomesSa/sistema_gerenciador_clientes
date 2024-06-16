<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/validate-token', [AuthController::class, 'validateToken']);

    Route::post('/users/update', [UserController::class, 'update']);
    Route::get('/users/getById', [UserController::class, 'getById']);

    Route::middleware(['role:manager,admin'])->group(function (){
        Route::post('/users', [UserController::class, 'store']);
        
        Route::delete('/users', [UserController::class, 'destroy']);
        Route::get('/users/getByRegistrationDate', [UserController::class, 'getByRegistrationDate']);
        Route::get('/users/getbyname', [UserController::class, 'getByName']);
    });
});
