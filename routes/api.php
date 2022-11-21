<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductApiController;
use App\Http\Controllers\SellerApiController;
use App\Http\Controllers\OrderApiController;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('oauth/token', 
'Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');

Route::post('product', [ProductApiController::class, 'store']);
Route::get('product', [ProductApiController::class, 'index']);
Route::get('product/{id}', [ProductApiController::class, 'getById']);

//Route::post('order', [ProductApiController::class, 'Orders']);

Route::post('seller', [SellerApiController::class, 'store']);
Route::get('seller', [SellerApiController::class, 'index']);
Route::get('seller/{id}', [SellerApiController::class, 'getById']);

Route::post('order', [OrderApiController::class, 'store']);
Route::get('order', [OrderApiController::class, 'index']);
Route::get('order/{email}', [OrderApiController::class, 'getByEmail']);