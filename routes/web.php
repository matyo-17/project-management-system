<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get("/login", [AuthController::class, "login"])->name("login");
Route::get("/register", [AuthController::class, "register"])->name("register");
Route::get("/logout", [AuthController::class, "logout"])->name("logout");
Route::post("/authenticate", [AuthController::class, "authenticate"])->name("authenticate");
Route::post("/sign-up", [AuthController::class, "sign_up"])->name("sign_up");