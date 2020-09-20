<?php

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

Route::get('/', 'LinksController@index');
Route::post('/shortening', 'Ajax\LinksController@add');

Route::get('/stats', 'VisitStatsController@allStat');
Route::get('/{path}', 'LinksController@redirect');
Route::get('/{path}/stat', 'VisitStatsController@oneStat');
