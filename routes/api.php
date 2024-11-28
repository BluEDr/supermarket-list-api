<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SuperListController;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Protected routes that require authentication
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/addNewPartner', [PartnerController::class, 'createPartnership'])->name('addPartner');
    Route::get('/checkPartnership', [PartnerController::class, 'checkPartnership'])->name('checkPartnership');
    Route::post('/createANewSuperList',[SuperListController::class, 'createANewSuperList'])->name('createANewSuperList');
    Route::post('/addNewProduct',[ProductController::class, 'addNewProduct'])->name('addProduct');
    Route::get('/getAllProducts',[ProductController::class, 'getAllProducts'])->name('getAllProducts');
});