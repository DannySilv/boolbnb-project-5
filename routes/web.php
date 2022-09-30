<?php

use App\Http\Controllers\Admin\SponsorController;
use Illuminate\Support\Facades\Auth;
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


Auth::routes();

Route::middleware('auth')
    ->namespace('Admin')
    ->name('admin.')
    ->prefix('admin')
    ->group(function () {
        Route::get('/', 'HomeController@index')->name('home');
        Route::resource('accomodations', 'AccomodationController');
        Route::get('messages', 'MessageController@index')->name('messages.index');
        Route::get('accomodations/sponsors/{accomodation}', 'SponsorController@index')->name('sponsors');
        Route::get('accomodations/sponsors/{accomodation}/{sponsor}/payment', 'SponsorController@payment')->name('sponsors.payment');
        Route::post('accomodations/sponsors/{accomodation}/{sponsor}/checkout', 'SponsorController@checkout')->name('sponsors.checkout');
        Route::get('accomodations/sponsored', 'SponsorController@sponsored')->name('sponsors.sponsored');
    });

Route::get('{any?}', function () {
    return view('guest.home');
})->where('any', '.*');

// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
