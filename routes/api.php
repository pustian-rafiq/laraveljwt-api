<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//User routes

//1st option -- it is good for api
Route::prefix('auth')->group(function (){

    Route::post("/login",[AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function (){
        Route::get("/users",[AuthController::class, 'index']);
        Route::get("/users/{id}",[AuthController::class, 'show']);
        Route::post("/users",[AuthController::class, 'store']);
        Route::post("/users/{id}",[AuthController::class, 'update']);
        Route::get("/users/delete/{id}",[AuthController::class, 'delete']);
        Route::get("/logout",[AuthController::class, 'logout']);
    });
});

//Page routes

Route::group(['middleware'=>'auth:api','prefix'=>'page'], function($router) {
    Route::post("/create",[PageController::class, 'store']);
});

// Route::prefix('page')->group(function (){
//     Route::middleware('auth:api')->group(function (){
//         Route::get("/users",[AuthController::class, 'index']);
//         Route::get("/users/{id}",[AuthController::class, 'show']);
//         Route::post("/users",[AuthController::class, 'store']);
//         Route::post("/users/{id}",[AuthController::class, 'update']);
//         Route::get("/users/delete/{id}",[AuthController::class, 'delete']);
//         Route::get("/logout",[AuthController::class, 'logout']);
//     });
// });

//2nd option

// Route::group(['middleware'=>'auth:api','prefix'=>'auth'], function($router) {
//     Route::get("/users",[AuthController::class, 'index']);
//     Route::get("/users/{id}",[AuthController::class, 'show']);
//     Route::post("/users",[AuthController::class, 'store']);
//     Route::post("/users/{id}",[AuthController::class, 'update']);
//     Route::get("/users/delete/{id}",[AuthController::class, 'delete']);
//     Route::get("/logout",[AuthController::class, 'logout']);
// });


 //ekhane delete method o use kora jabe

// Route::post("/login",[AuthController::class, 'login']);