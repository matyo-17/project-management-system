<?php

use App\Http\Controllers\ProjectController;
use App\Http\Middleware\ApiGuard;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiGuard::class)->group(function () {
    Route::prefix("/datatable")->group(function () {        
        Route::post("/projects", [ProjectController::class, 'datatable']);
    });
});