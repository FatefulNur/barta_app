<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware("guest")->group(function () {
    Route::get("register", [RegisterController::class, "index"])->name("register.index");
    Route::post("register", [RegisterController::class, "register"])->name("register");

    Route::get("login", [LoginController::class, "index"])->name("login.index");
    Route::post("login", [LoginController::class, "authenticate"])->name("login");
});

Route::middleware("auth")->group(function () {
    Route::get("signout", [LoginController::class, "signOut"])->name("signout");

    Route::get("profile", [ProfileController::class, "index"])->name("profile");
    Route::get("profile/edit", [ProfileController::class, "edit"])->name("profile.edit");
    Route::put("profile/update", [ProfileController::class, "update"])->name("profile.update");
});
