<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\UserSectionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
 * Promo site pages
 */
Route::group([], function () {
    Route::view('/', 'promo.index');
    Route::view('features', 'promo.features');
    Route::view('pricing', 'promo.pricing');
    Route::view('contact', 'promo.contact');
    Route::view('about', 'promo.about');
    Route::view('privacy', 'promo.privacy');
    Route::view('cookie', 'promo.cookie');
    Route::view('conditions', 'promo.conditions');
    Route::view('how_traxr_works', 'promo.how_traxr_works');
    Route::view('bot', 'promo.bot');
    Route::view('comparison-linkody', 'promo.comparison-linkody', ['page_class' => 'comp-page']);
    Route::view('comparison-linkcheetah', 'promo.comparison-linkcheetah', ['page_class' => 'comp-page']);
    Route::view('comparison-seranking', 'promo.comparison-seranking', ['page_class' => 'comp-page']);
    Route::view('comparison-monitorbacklinks', 'promo.comparison-monitorbacklinks', ['page_class' => 'comp-page']);
    Route::view('comparison-linkokay', 'promo.comparison-linkokay', ['page_class' => 'comp-page']);
    Route::view('complete-comparison', 'promo.complete-comparison', ['page_class' => 'comp-page']);

    Route::post('sendmail', PromoController::class . '@sendMail');

    Route::group(['prefix' => 'app'], function () {
        Route::get('login', AuthController::class . '@login')->name('login');
        Route::post('login', AuthController::class . '@authorize');
        Route::any('logout', AuthController::class . '@logout')->name('logout');
        Route::get('resetpassword', AuthController::class . '@resetPwdForm');
        Route::post('resetpassword', AuthController::class . '@resetPwd');
        Route::get('signup', AuthController::class . '@signupForm');
        Route::post('signup', AuthController::class . '@signup');
    });
});

Route::group(['middleware' => ['auth:web', 'authorizedOnly', 'verifyPlan'], 'prefix' => 'app'], function () {
    Route::view('guide', 'app.guide');
    Route::get('dashboard', UserSectionController::class . '@dashboard');
    Route::get('links', UserSectionController::class . '@links');
    Route::get('domains', UserSectionController::class . '@domains');
    Route::any('myaccount', UserSectionController::class . '@myAccount');
    Route::get('invoices', UserSectionController::class . '@invoices');
    Route::get('myplan', UserSectionController::class . '@myPlan');
});

Route::get('app', function () {
    if (!Auth::check()) {
        return redirect('/app/login');
    }
    return redirect('/app/dashboard');
});

/*
 * Redirects section
 */
Route::get('/features.php', function () {return redirect('/features');});
Route::get('/pricing.php', function () {return redirect('/pricing');});
Route::get('/contact.php', function () {return redirect('/contact');});
Route::get('/sentmail.php', function () {return redirect('/sendmail');});
Route::get('/privacy.php', function () {return redirect('/privacy');});
Route::get('/cookie.php', function () {return redirect('/cookie');});
Route::get('/conditions.php', function () {return redirect('/conditions');});
Route::get('/how_traxr_works.php', function () {return redirect('/how_traxr_works');});
Route::get('/bot.php', function () {return redirect('/bot');});
Route::get('/comparison-linkody.php', function () {return redirect('/comparison-linkody');});
Route::get('/comparison-linkcheetah.php', function () {return redirect('/comparison-linkcheetah');});
Route::get('/comparison-seranking.php', function () {return redirect('/comparison-seranking');});
Route::get('/comparison-monitorbacklinks.php', function () {return redirect('/comparison-monitorbacklinks');});
Route::get('/comparison-linkokay.php', function () {return redirect('/comparison-linkokay');});
Route::get('/complete-comparison.php', function () {return redirect('/complete-comparison');});
