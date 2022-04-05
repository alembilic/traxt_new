<?php

use App\Http\Controllers\DomainApiController;
use App\Http\Controllers\NotificationsApiController;
use App\Http\Controllers\VatApiController;
use App\Http\Controllers\WebhookApiController;
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

Route::group(['middleware' => ['auth:api']], function () {
    Route::get('notifications', NotificationsApiController::class . '@index');
    Route::put('notifications/markAsReadAll', NotificationsApiController::class . '@markAsReadAll');
    Route::put('notifications/{notification}/markAsRead', NotificationsApiController::class . '@markAsRead');
    Route::post('domain/{domain}/importBackLinks', DomainApiController::class . '@importBackLinks');
    Route::get('domain/{domain}/retrieveBackLinks', DomainApiController::class . '@retrieveBackLinks');
    Route::resource('domains', DomainApiController::class);
});
Route::any('webhook/{type}', WebhookApiController::class . '@handle');
