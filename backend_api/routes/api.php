<?php

use App\Http\Controllers\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes for useraccount CRUD Operations

Route::get('account', [AccountController::class, 'index']);
Route::post('account', [AccountController::class,'store']);
Route::get('account/{id}', [AccountController::class,'show']);
Route::get('account/{id}/edit', [AccountController::class,'edit']);
Route::put('account/{id}/edit', [AccountController::class,'update']);
Route::delete('account/{id}/delete', [AccountController::class,'destroy']);

// API Routes for product CRUD operations

Route::get('products', [ProductController::class,'index']);
Route::post('products', [ProductController::class,'store']);
Route::get('products/{id}', [ProductController::class,'show']);
Route::get('products/{id}/edit', [ProductController::class,'edit']);
Route::put('products/{id}/edit', [ProductController::class,'update']);
Route::delete('products/{id}/delete', [ProductController::class,'destroy']);


