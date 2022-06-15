<?php

use App\Http\Controllers\Api\AuthController;
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
Route::get("/users",[AuthController::class, 'index']);
Route::get("/users/{id}",[AuthController::class, 'show']);
Route::post("/users",[AuthController::class, 'store']);
Route::post("/users/{id}",[AuthController::class, 'update']);
Route::get("/users/delete/{id}",[AuthController::class, 'delete']); //ekhane delete method o use kora jabe