<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\CommentController;

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
//categories routes
Route::get('/categories', [CategoryController::class,"get"]);

//tags routes
Route::get('/tags', [TagController::class,"get"]);

//article routes
Route::resource("/articles", ArticleController::class);

//favourite routes
Route::resource("/fav", FavouriteController::class)->only(['index','store','destroy'])->middleware("auth:sanctum");

//comment routes
Route::resource('/comment', CommentController::class)->only(['store','update','destroy'])->middleware('auth:sanctum');


//auth routes
Route::post('/register', [AuthController::class,"register"]);
Route::post('/login', [AuthController::class,"login"]);
Route::post('/verify', [AuthController::class,"verify"]);
Route::post('/logout', [AuthController::class,"logout"])->middleware('auth:sanctum');
