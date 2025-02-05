<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::middleware("auth.api")->group(function () {
    Route::get("/summary", [DashboardController::class, 'summary'])->middleware("permission:read_summary");
    Route::patch("/profile", [ProfileController::class, 'update']);

    Route::prefix("/project")->group(function () {
        Route::post("/", [ProjectController::class, 'create'])->middleware("permission:create_project");

        Route::prefix("/{id}")->group(function () {
            Route::get("/", [ProjectController::class, 'read'])->middleware("permission:read_project");
            Route::patch("/", [ProjectController::class, 'update'])->middleware("permission:update_project");
            Route::delete("/", [ProjectController::class, 'delete'])->middleware("permission:delete_project");
        });
    });

    Route::prefix("/invoice")->group(function () {
        Route::post("/", [InvoiceController::class, 'create'])->middleware("permission:create_invoice");

        Route::prefix("/{id}")->group(function () {
            Route::get("/", [InvoiceController::class, 'read'])->middleware("permission:read_invoice");
            Route::patch("/", [InvoiceController::class, 'update'])->middleware("permission:update_invoice");
            Route::delete("/", [InvoiceController::class, 'delete'])->middleware("permission:delete_invoice");

            Route::patch("/status", [InvoiceController::class, 'status'])->middleware("permission:update_invoice_status");
        });
    });

    Route::prefix("/expense")->group(function () {
        Route::post("/", [ExpenseController::class, 'create'])->middleware("permission:create_expense");

        Route::prefix("/{id}")->group(function () {
            Route::get("/", [ExpenseController::class, 'read'])->middleware("permission:read_expense");
            Route::patch("/", [ExpenseController::class, 'update'])->middleware("permission:update_expense");
            Route::delete("/", [ExpenseController::class, 'delete'])->middleware("permission:delete_expense");

            Route::patch("/status", [ExpenseController::class, 'status'])->middleware("permission:update_expense_status");
        });
    });

    Route::prefix("/role")->group(function () {
        Route::post("/", [RoleController::class, 'create'])->middleware("permission:create_role");

        Route::prefix("/{id}")->group(function () {
            Route::get("/", [RoleController::class, 'read'])->middleware("permission:read_role");
            Route::patch("/", [RoleController::class, 'update'])->middleware("permission:update_role");
            Route::delete("/", [RoleController::class, 'delete'])->middleware("permission:delete_role");
        });
    });
    
    Route::prefix("/datatable")->group(function () {        
        Route::post("/projects", [ProjectController::class, 'datatable'])->middleware("permission:read_project");
        Route::post("/invoices", [InvoiceController::class, 'datatable'])->middleware("permission:read_invoice");
        Route::post("/expenses", [ExpenseController::class, 'datatable'])->middleware("permission:read_expense");
        Route::post("/roles", [RoleController::class, 'datatable'])->middleware("permission:read_role");
    });
});