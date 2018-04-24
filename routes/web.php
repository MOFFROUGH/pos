<?php
use Illuminate\Http\Request;
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
    return view('auth.login');
});
Route::group(['namespace'=>'Admin','middleware' => 'auth'],function(){

    Route::get('/admin', 'AdminController@index')->name('admin.home');

    Route::post('/print', 'AdminController@print')->name('admin.print');

    Route::get('/time', 'AdminController@dateFormat')->name('getDate');

    Route::get('/cart', 'AdminController@cart')->name('cart');

    Route::post('/addc', 'AdminController@addCash')->name('addCash');

    Route::get('/clear-cart', 'AdminController@clearcart')->name('clearcart');

    Route::post('/checkout/{id}', 'AdminController@addToCart')->name('admin.checkout');

    Route::get('/addQuantity/{id}', 'AdminController@addQuantity')->name('addQuantity');

    Route::get('/removeQuantity/{id}', 'AdminController@removeQuantity')->name('removeQuantity');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
