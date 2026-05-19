<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\AuthController::class)
    ->group(function () {
        Route::get("login", 'LoginView')->name("login");
        Route::post("login", "Login")->name("login.store");
        Route::get("register", "RegisterView")->name("register");
        Route::post("register" , "Register")->name("register.store");
        Route::post("logout", "Logout")->name("logout");
    });

Route::get("/", \App\Http\Controllers\MainController::class)->name("main");
Route::get("/account", \App\Http\Controllers\AccountController::class)->middleware("auth")->name("account");
Route::view("/about", 'about')->name("about");

Route::middleware("auth")->group(function () {
    Route::get("/order/create", [\App\Http\Controllers\OrderController::class, 'create'])->name("order.create");
    Route::post("/order", [\App\Http\Controllers\OrderController::class, 'store'])->name("order.store");
    Route::delete("/order/{order}", [\App\Http\Controllers\OrderController::class, 'destroy'])->name("order.destroy");
    Route::post("/feedback", [\App\Http\Controllers\FeedbackController::class, 'store'])->name("feedback.store");
});

Route::prefix("admin")->name("admin.")->group(function () {
    Route::get("/login", [\App\Http\Controllers\AdminController::class, 'loginView'])->name("login");
    Route::post("/login", [\App\Http\Controllers\AdminController::class, 'login'])->name("login.store");
});

Route::middleware("admin")->prefix("admin")->name("admin.")->group(function () {
    Route::get("/", [\App\Http\Controllers\AdminController::class, 'index'])->name("index");
    Route::patch("/order/{order}/status", [\App\Http\Controllers\AdminController::class, 'updateStatus'])->name("order.updateStatus");
});
