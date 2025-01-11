<?php

use App\Http\Controllers\ProjectController;
use App\Http\Middleware\ApiGuard;
use App\Http\Middleware\PermissionGuard;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiGuard::class, PermissionGuard::class])->group(function () {
    Route::prefix("/datatable")->group(function () {        
        Route::post("/projects", [ProjectController::class, 'datatable']);
    });
});