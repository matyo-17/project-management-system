<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Middleware\PermissionGuard;
use App\Http\Middleware\WebGuard;
use Illuminate\Support\Facades\Route;

Route::get("/login", [AuthController::class, "login"])->name("login");
Route::get("/register", [AuthController::class, "register"])->name("register");
Route::get("/logout", [AuthController::class, "logout"])->name("logout");
Route::post("/authenticate", [AuthController::class, "authenticate"])->name("authenticate");
Route::post("/sign-up", [AuthController::class, "sign_up"])->name("sign_up");

Route::middleware([WebGuard::class, PermissionGuard::class])->group(function () {
    Route::get("/", [DashboardController::class, "dashboard"])->name("dashboard");

    Route::get("/projects", [ProjectController::class, "projects"])->name("projects");
    Route::get("/expenses", [DashboardController::class, "dashboard"])->name("expenses");
    Route::get("/invoices", [DashboardController::class, "dashboard"])->name("invoices");
});