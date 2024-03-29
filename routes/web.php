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
    return view('chart');
});

Route::post( '/trips_ajax', array(
    'as' => 'trips_ajax',
    'uses' => 'TestController@get_trips'
) );

Route::post( '/sales_ajax', array(
    'as' => 'sales_ajax',
    'uses' => 'TestController@get_sales'
) );