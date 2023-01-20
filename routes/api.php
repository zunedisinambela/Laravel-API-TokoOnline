<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionApiController;

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

// users
Route::get('users', [UsersController::class, 'index']);
Route::get('users/{iduser}', [UsersController::class, 'user']);
Route::post('auth/login', [UsersController::class, 'login']);
Route::post('auth/register', [UsersController::class, 'register']);
Route::post('auth/update/{iduser}', [UsersController::class, 'update']);
Route::get('logout/{iduser}', [UsersController::class, 'logout']);

// product
Route::get('/products', [ProductController::class, 'products']);
Route::get('/product/{idproduct}', [ProductController::class, 'product']);

// transaction
Route::get('/transaction', [TransactionApiController::class, 'index']);
Route::post('/transaction', [TransactionApiController::class, 'store']);
