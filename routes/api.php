<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Login para usuarios y vendedores

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/logout', [UserController::class, 'logout']);

//Vendedor

Route::prefix('seller')->group(function(){
    Route::post('/store/list', [StoreController::class, 'list']);
    Route::post('/store/get', [StoreController::class, 'get']);
    Route::post('/store/create', [StoreController::class, 'create']);
    Route::post('/store/delete', [StoreController::class, 'delete']);
    Route::post('/store/update', [StoreController::class, 'update']);

    Route::post('/product/list', [ProductController::class, 'list']);
    Route::post('/product/get', [ProductController::class, 'get']);
    Route::post('/product/create', [ProductController::class, 'create']);
    Route::post('/product/delete', [ProductController::class, 'delete']);
    Route::post('/product/update', [ProductController::class, 'update']);

})->middleware('auth:api');