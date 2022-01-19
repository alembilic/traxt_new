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
