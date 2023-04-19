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

Route::get('register/check', 'Auth\RegisterController@check')->name('api-register-check');

Route::get('provinces', 'API\LocationController@provinces')->name('api-provinces');
Route::get('regencies/{provinces_id}', 'API\LocationController@regencies')->name('api-regencies');
Route::get('districts/{regencies_id}', 'API\LocationController@districts')->name('api-districts');
Route::get('villages/{districts_id}', 'API\LocationController@villages')->name('api-villages');

/**
 * Route Raja Ongkir
 */
Route::get('/rajaongkir/provinces', 'API\RajaOngkirController@getProvinces')->name('customer.rajaongkir.getProvinces');
Route::get('/rajaongkir/cities', 'API\RajaOngkirController@getCities')->name('customer.rajaongkir.getCities');
Route::post('/rajaongkir/checkOngkir', 'API\RajaOngkirController@checkOngkir')->name('customer.rajaongkir.checkOngkir');
