<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::post('createCategory', [AdmController::class, 'createCategory']);
    Route::post('createSubCategory', [AdmController::class, 'createSubCategory']);
    Route::post('createProduct', [AdmController::class, 'createProduct']);
    Route::post('addToCart', [UserController::class, 'addToCart']);
    Route::delete('deleteItemCart/{id}', [UserController::class, 'deleteItemCart']);
    Route::post('createAddress', [userController::class, 'createAddress']);
    Route::get('getAddress/{id}', [userController::class, 'getAddress']);
    Route::get('getProductsThisUser/{id}', [UserController::class, 'getProductsThisUser']);
});

Route::get('getCategories', [UserController::class, 'getCategories']);
Route::get('getSubCategories/{name}', [UserController::class, 'getSubCategories']);
Route::get('getCategoryDefault', [UserController::class, 'getCategoryDefault']);
Route::get('getProducts', [UserController::class, 'getProduct']);
Route::get('getProductThisSubCategory/{id}', [UserController::class, 'getProductThisSubCategory']);
Route::get('getSizeThisProduct/{id}', [UserController::class, 'getSizeThisProduct']);
Route::post('getPriceCor', [UserController::class, 'getPriceCor']); // correios
Route::post('createUser', [UserController::class, 'createUser']);
Route::post('login', [UserController::class, 'login']);
