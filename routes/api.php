<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
//Route::post('/users', [UserController::class, 'store']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/validate-token', [AuthController::class, 'validateToken']);

    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/getById', [UserController::class, 'getById']);
    
    // Route::put('/users', [UserController::class, 'update']);
    // Route::delete('/users', [UserController::class, 'destroy'])->middleware(CheckRole::class);

    Route::middleware(['role:manager,admin'])->group(function (){
        Route::post('/users', [UserController::class, 'store']);
        
        Route::delete('/users', [UserController::class, 'destroy']);
        Route::get('/users/getByRegistrationDate', [UserController::class, 'getByRegistrationDate']);
        Route::get('/users/getbyname', [UserController::class, 'getByName']);
    });
});
