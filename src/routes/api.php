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
Route::group([

    'middleware' => 'api',
    // 'prefix' => 'auth'

], function ($router) {
    Route::post('register', 'Auth\RegisterController@register');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

    Route::group(['middleware' => ['jwt.auth']], function () {
    // 認証が必要なメソッド
        Route::get("tickets", "TicketController@apiIndex");
        Route::get("tickets/{id}", "TicketController@apiGet");
        Route::post("tickets", "TicketController@apiCreate");
        Route::put("tickets/{id}", "TicketController@apiUpdate");
        Route::delete("tickets/{id}", "TicketController@apiDelete");

        Route::post("ticketDisplaySequence", "TicketDisplaySequenceController@apiCreate");
        Route::put("ticketDisplaySequence", "TicketDisplaySequenceController@apiUpdate");
    });

});

// Route::group(["middleware" => "api"], function () {
// // 認証が必要ないメソッド
//     Route::post('/register', 'Auth\RegisterController@register'); // 追加
//     Route::post('/login', 'Auth\LoginController@login');

//     Route::get("sample", function() {
//         $data = ["name" => "test"];
//         return $data;
//     });

//     Route::middleware('auth:api')->get('/user', function (Request $request) {
//         return $request->user();
//     });

// //    Route::group(['middleware' => ['jwt.auth']], function () {
//     // 認証が必要なメソッド
//         Route::get("tickets", "TicketController@apiIndex");
//         Route::post("tickets", "TicketController@apiCreate");
//         Route::put("tickets/{id}", "TicketController@apiUpdate");
//         Route::delete("tickets/{id}", "TicketController@apiDelete");
//     // });
// });
