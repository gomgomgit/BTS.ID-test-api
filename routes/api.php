<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix' => 'users'], function () {
    Route::post('/signin', [AuthController::class, 'signin']);
    Route::post('/signup', [AuthController::class, 'signup']);
    
    Route::get('', [UserController::class, 'getAll'])->middleware('jwt.verify');
});

Route::group(['prefix' => 'shopping', 'middleware' => 'jwt.verify'], function () {
    Route::get('', [ShoppingController::class, 'getAll']);
    Route::get('/{id}', [ShoppingController::class, 'getById']);
    Route::post('', [ShoppingController::class, 'create']);
    Route::post('/{id}', [ShoppingController::class, 'update']);
    Route::delete('/{id}', [ShoppingController::class, 'delete']);
});
