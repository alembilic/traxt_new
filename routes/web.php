<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PromoController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
 * Promo site pages
 */
Route::group([], function () {
    Route::get('/', function () {
        return view('promo.index');
    });
    Route::get('features', function () {
        return view('promo.features');
    });
    Route::get('pricing', function () {
        return view('promo.pricing');
    });
    Route::get('contact', function () {
        return view('promo.contact');
    });
    Route::get('about', function () {
        return view('promo.about');
    });
    Route::get('privacy', function () {
        return view('promo.privacy');
    });
    Route::get('cookie', function () {
        return view('promo.cookie');
    });
    Route::get('conditions', function () {
        return view('promo.conditions');
    });
    Route::get('how_traxr_works', function () {
        return view('promo.how_traxr_works');
    });
    Route::get('bot', function () {
        return view('promo.bot');
    });
    Route::get('comparison-linkody', function () {
        return view('promo.comparison-linkody', ['page_class' => 'comp-page']);
    });
    Route::get('comparison-linkcheetah', function () {
        return view('promo.comparison-linkcheetah', ['page_class' => 'comp-page']);
    });
    Route::get('comparison-seranking', function () {
        return view('promo.comparison-seranking', ['page_class' => 'comp-page']);
    });
    Route::get('comparison-monitorbacklinks', function () {
        return view('promo.comparison-monitorbacklinks', ['page_class' => 'comp-page']);
    });
    Route::get('comparison-linkokay', function () {
        return view('promo.comparison-linkokay', ['page_class' => 'comp-page']);
    });
    Route::get('complete-comparison', function () {
        return view('promo.complete-comparison', ['page_class' => 'comp-page']);
    });

    Route::post('sendmail', PromoController::class . '@sendMail');

    Route::group(['prefix' => 'app'], function () {
        Route::get('login', AuthController::class . '@login')->name('login');
        Route::post('login', AuthController::class . '@authorize');
        Route::any('logout', AuthController::class . '@logout')->name('logout');
    });
});

Route::group(['middleware' => ['auth:web'], 'prefix' => 'app'], function () {
    Route::get('dashboard', AuthController::class . '@dashboard')->name('dashboard');
//    Route::get('login', [CustomAuthController::class, 'index'])->name('login');
//    Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
//    Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
//    Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
//    Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');

    if (!Auth::check()) {
        return view('app.login');
    }
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
