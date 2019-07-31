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
/*
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
*/

/*URL指定できたとき（localhost:8000）<- 実際は（localhost:8000/）だが空文字のため'/'が省略されている。*/
Route::get('/', 'LoginController@index');

Route::post('/putLogin' , 'LoginController@putLogin');

Route::get('/menu' , 'MenuController@index');

Route::get('/nyuka' , 'NyukaController@index');

Route::post('/nkensaku' , 'NyukaController@putKensaku');
Route::get('/nkensaku' , 'NyukaController@putKensaku');

Route::post('/nshinki' , 'NtorokuController@dispShinki');

Route::post('/redisplist' , 'NtorokuController@redispList');

Route::post('/torisansho' , 'NtorokuController@dispToriSansho');

Route::post('/torikensaku' , 'SanshoController@toriKensaku');
Route::get('/torikensaku' , 'SanshoController@toriKensaku');

Route::post('/torisentaku' , 'NtorokuController@toriSentaku');

Route::post('/yakusansho' , 'NtorokuController@dispYakuSansho');

Route::post('/yakukensaku' , 'SanshoController@yakuKensaku');
Route::get('/yakukensaku' , 'SanshoController@yakuKensaku');

Route::post('/yakusentaku' , 'NtorokuController@yakuSentaku');

Route::post('/closesansho' , 'NtorokuController@closesansho');

Route::post('/registShinki' , 'NtorokuController@registShinki');

