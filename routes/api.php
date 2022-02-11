<?php

use App\Http\Controllers\DomainApiController;
use App\Http\Controllers\VatApiController;
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

Route::get('vat', VatApiController::class . '@index');

//TODO: make this route authorized only
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('domain/{domain}/importBackLinks', DomainApiController::class . '@importBackLinks');
    Route::get('domain/{domain}/retrieveBackLinks', DomainApiController::class . '@retrieveBackLinks');
});
