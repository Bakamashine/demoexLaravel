<?php

use Illuminate\Support\Facades\Route;

Route::controller(\App\Http\Controllers\AuthController::class)
    ->middleware("guest")
    ->group(function () {
        Route::prefix("login")
            ->name("login")
            ->group(function () {
                Route::get("", 'LoginView')->name("");
                Route::post("", "Login")->name(".store");
            });
        Route::prefix("register")
            ->name("register")
            ->group(function () {
                Route::get("", "RegisterView")->name("");
                Route::post("", "Register")->name(".store");
            });

        Route::post("logout", "Logout")->name("logout")
            ->withoutMiddleware("guest")
            ->middleware("auth");
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
