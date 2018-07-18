<?php

use Illuminate\Http\Request;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
// Route::get('/noticias/{id}', 'NoticiaController@show');
// Route::get('/noticias', 'NoticiaController@show');

Route::middleware('cors','auth:api')->group( function () {
	Route::resource('noticias', 'API\NoticiaController');
});
Route::middleware('cors')->group( function () {
	Route::post('map', 'API\FourSquareController@consulta');
	Route::post('register', 'API\PassportController@register');
	Route::post('login', 'API\PassportController@login');
});


