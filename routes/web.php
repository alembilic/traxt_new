<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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

//TODO: implement me
Route::post('sendmail', function () {
    return view('promo.contact');
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
