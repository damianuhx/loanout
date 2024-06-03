<?php

use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Authentication
Route::controllers([
    'auth'=>'Auth\AuthController',
    'password'=>'Auth\PasswordController',
]);


//Browser
Route::get('', 'ObjectController@divisions');
Route::get('home', 'ObjectController@divisions');
Route::get('divisions', 'ObjectController@divisions');
Route::get('categories', 'ObjectController@divisions');
Route::get('categories/{id}', 'ObjectController@categories');
Route::get('types/{id}', 'ObjectController@types');
Route::get('objects/{id}', 'ObjectController@objects');
Route::get('details/{id}', 'ObjectController@details');

Route::get('reserve/{id}', 'LendingController@add_object');
Route::get('reservex/{id}', 'LendingController@remove_object');
Route::get('basket', 'LendingController@basket');
Route::get('basketx', 'LendingController@reset_basket');


//Procedure
Route::get('lent/search', 'LendingController@search_list');
Route::get('lent/all', 'LendingController@display_list');
Route::get('confirmation/{id}', 'LendingController@confirmation');

Route::get('unlock/{id}', 'LendingController@send_unlock');
Route::get('lock/{id}', 'LendingController@send_lock');
Route::get('lock', 'LendingController@lock_list');
Route::post('request/{id}', 'LendingController@send_request');
Route::get('grant/all', 'LendingController@grant_list');
Route::get('grant/{id}', 'LendingController@grant');
Route::post('reject/{id}', 'LendingController@send_reject');
Route::post('grant/{id}', 'LendingController@send_grant');
Route::get('handout/all', 'LendingController@handout_list');
Route::get('handout/{id}', 'LendingController@handout');
Route::post('handout/{id}', 'LendingController@send_handout');
Route::get('restock/all', 'LendingController@restock_list');
Route::get('restock/{id}', 'LendingController@restock');
Route::post('restock/{id}', 'LendingController@send_restock');
Route::get('print/{id}', 'LendingController@pdf');

Route::get('refresh', 'PeriodController@refresh');
Route::get('mail/{id}', 'PeriodController@send_mail');

//Object Handling
Route::post('{model1}/{id1}/{model2}', 'UniversalController@attach');
Route::delete('{model1}/{id1}/{model2}/{id2}', 'UniversalController@detach');
Route::get('admin', 'UniversalController@admin');
Route::get('cat/all', 'UniversalController@cat');
Route::get('{model}/all', 'UniversalController@all');
Route::get('{model}/{id}', 'UniversalController@form');
Route::post('{model}/{id}', 'UniversalController@save');
Route::delete('{model}/{id}', 'UniversalController@delete');

Route::get('manual', 'ManualController@manual');
Route::get('manual/{user}', 'ManualController@manual');
