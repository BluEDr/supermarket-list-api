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
    //For the partners table
    Route::post('/addNewPartner', [PartnerController::class, 'createPartnership'])->name('addPartner');
    Route::delete('/deletePartner/{id}', [PartnerController::class, 'deletePartner'])->name('delete.partner');
    Route::get('/checkPartnership', [PartnerController::class, 'checkPartnership'])->name('checkPartnership');
    //For the products table
    Route::post('/addNewProduct',[ProductController::class, 'addNewProduct'])->name('addProduct');
    Route::delete('/deleteProduct/{id}', [ProductController::class, 'deleteAProduct'])->name('delete.product');
    Route::put('/updateProduct/{id}', [ProductController::class, 'updateProduct'])->name('update.product');
    Route::get('/getAllProducts',[ProductController::class, 'getAllProducts'])->name('getAllProducts');
    //For the super_lists table
    Route::post('/createANewSuperList',[SuperListController::class, 'createANewSuperList'])->name('createANewSuperList');
    Route::put('/updateSuperList/{id}',[SuperListController::class, 'updateSuperList'])->name('update.superlist');
});