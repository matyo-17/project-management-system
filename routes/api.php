<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\ApiGuard;
use App\Http\Middleware\PermissionGuard;
use Illuminate\Support\Facades\Route;

Route::middleware([ApiGuard::class, PermissionGuard::class])->group(function () {
    Route::prefix("/project")->group(function () {
        Route::post("/", [ProjectController::class, 'create']);

        Route::prefix("/{id}")->group(function () {
            Route::get("/", [ProjectController::class, 'read']);
            Route::patch("/", [ProjectController::class, 'update']);
            Route::delete("/", [ProjectController::class, 'delete']);
        });
    });

    Route::prefix("/invoice")->group(function () {
        Route::post("/", [InvoiceController::class, 'create']);

        Route::prefix("/{id}")->group(function () {
            Route::get("/", [InvoiceController::class, 'read']);
            Route::patch("/", [InvoiceController::class, 'update']);
            Route::delete("/", [InvoiceController::class, 'delete']);

            Route::patch("/status", [InvoiceController::class, 'status']);
        });
    });
    
    Route::prefix("/datatable")->group(function () {        
        Route::post("/projects", [ProjectController::class, 'datatable']);
        Route::post("/invoices", [InvoiceController::class, 'datatable']);
    });
});