<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\RentalsController;
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
Route::group([ 'middleware' => ['api', 'cors'] ], function ($router) { 
    Route::post('registerUser', [AuthController::class, 'registerUser']); 
    Route::post('loginUser', [AuthController::class, 'loginUser']); 
});   
Route::prefix('auth')->group(function () {
    Route::prefix('profile')->group(function () {
        Route::post('logoutUser', [AuthController::class, 'logoutUser']); 
        Route::get('profileUser', [AuthController::class, 'profileUser']);
    });
    Route::apiResources([
        'books'   => BooksController::class,
        'categories'   => CategoriesController::class,
        'rentails' => RentalsController::class
    ]);
});
