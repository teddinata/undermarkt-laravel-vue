<?php

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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/categories', 'CategoryController@index')->name('categories');
Route::get('/categories/{id}', 'CategoryController@detail')->name('categories-detail');

Route::get('/details/{id}', 'DetailController@index')->name('details');
Route::post('/details/{id}', 'DetailController@add')->name('details-add');



Route::get('/checkout/callback', 'CartController@callback')->name('midtrans-callback');

Route::get('/success', 'CartController@success')->name('success');


Route::get('/register/success', 'Auth\RegisterController@success')->name('register-success');



Route::group(['middleware' => ['auth']], function(){
    Route::get('/cart', 'CartController@index')->name('cart');
    Route::delete('/cart/{id}', 'CartController@delete')->name('cart-delete');

    Route::post('/checkout', 'CheckoutController@process')->name('checkout');

    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('/dashboard/product', 'DashboardProductController@index')->name('dashboard-product');
    Route::get('/dashboard/product/create', 'DashboardProductController@create')->name('dashboard-product-create');
    Route::post('/dashboard/product', 'DashboardProductController@store')->name('dashboard-product-store');
    Route::get('/dashboard/product/detail{id}', 'DashboardProductController@detail')->name('dashboard-product-detail');
    Route::post('/dashboard/product/{id}', 'DashboardProductController@update')->name('dashboard-product-update');

    Route::post('/dashboard/product/gallery/upload', 'DashboardProductController@uploadGallery')
                ->name('dashboard-product-gallery-upload');

    Route::get('/dashboard/product/gallery/delete{id}', 'DashboardProductController@deleteGallery')
                ->name('dashboard-product-gallery-delete');

    Route::get('/dashboard/transaction', 'DashboardTransactionController@index')->name('dashboard-transaction');
    Route::get('/dashboard/transaction/detail{id}', 'DashboardTransactionController@detail')
                ->name('dashboard-transaction-detail');
    Route::post('/dashboard/transaction/{id}', 'DashboardTransactionController@update')
                ->name('dashboard-transaction-update');

    Route::get('/dashboard/setting', 'DashboardSettingController@store')
                ->name('dashboard-setting-store');
    Route::get('/dashboard/account', 'DashboardSettingController@account')
                ->name('dashboard-setting-account');
    Route::post('/dashboard/account/{redirect}', 'DashboardSettingController@update')
                ->name('dashboard-setting-redirect');
});

Route::prefix('admin')
    ->namespace('Admin')
    ->middleware(['auth', 'admin'])
    ->group(function() {
        Route::get('/', 'DashboardController@index')->name('admin.dashboard');
        Route::resource('category', 'CategoryController');
        Route::resource('user', 'UserController');
        Route::resource('product', 'ProductController');
        Route::resource('product-gallery', 'ProductGalleryController');
        Route::resource('transaction', 'TransactionController');
    });

Auth::routes(['verify' => true]);
