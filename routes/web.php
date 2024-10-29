<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartnerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class,'showLoginForm']);

Route::post('/login',[AuthController::class,'webLogin']);

Route::post('/logout',[AuthController::class,'webLogout']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addNewPartner', [PartnerController::class, 'createPartnership'])->name('addPartner');
});