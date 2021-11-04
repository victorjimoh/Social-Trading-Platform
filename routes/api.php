<?php

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
],
function ($router){
    
}
);

Route::get('/api/allstocks', [App\Http\Controllers\ApiController::class, 'getAllStocks']);
Route::get('/api/cash', [App\Http\Controllers\ApiController::class, 'getCash']);
Route::post('/api/buy', [App\Http\Controllers\ApiController::class, 'buyStock'])->middleware('api');
Route::post('/api/sell', [App\Http\Controllers\ApiController::class, 'sellStock'])->middleware('api');
