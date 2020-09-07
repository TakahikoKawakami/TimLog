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
// Auth::routes();

Route::any('{all}', function () {
    return view('index-bootstrap');
})->where(['all' => '.*']);

Route::get('/vue', function() {
    return view('welcome');
});
Route::get('/', 'TicketController@index')->name('main');

Route::get('/phpinfo', function () {
    return phpinfo();
});



Route::get('/home', 'HomeController@index')->name('home');
// Route::get('/login', function() {
//     route('login');
// });

// Route::get('/register', function() {
//     route('register');
// });
