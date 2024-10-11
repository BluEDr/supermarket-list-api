<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class,'showLoginForm']);

Route::post('/login',[AuthController::class,'webLogin']);

Route::post('/logout',[AuthController::class,'webLogout']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
