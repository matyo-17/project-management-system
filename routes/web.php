<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get("/login", [AuthController::class, "login"])->name("login");
Route::get("/register", [AuthController::class, "register"])->name("register");
Route::get("/logout", [AuthController::class, "logout"])->name("logout");
Route::post("/authenticate", [AuthController::class, "authenticate"])->name("authenticate");
Route::post("/sign-up", [AuthController::class, "sign_up"])->name("sign-up");

Route::middleware("auth.web")->group(function () {
    Route::get("/", [DashboardController::class, "dashboard"])->name("dashboard");

    Route::prefix("/projects")->middleware("permission:read_project")->group(function () {
        Route::get("/", [ProjectController::class, "projects"])->name("projects");
        Route::get("/{id}", [ProjectController::class, "project_info"])->name("project-info");
    });

    Route::prefix("/invoices")->middleware("permission:read_invoice")->group(function () {
        Route::get("/", [InvoiceController::class, "invoices"])->name("invoices");
        Route::get("/{id}", [InvoiceController::class, "invoice_info"])->name("invoice-info");
    });

    Route::prefix("/expenses")->middleware("permission:read_expense")->group(function () {
        Route::get("/expenses", [ExpenseController::class, "expenses"])->name("expenses");
        Route::get("/expenses/{id}", [ExpenseController::class, "expense_info"])->name("expense-info");
    });
});