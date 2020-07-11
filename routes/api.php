<?php

use Illuminate\Http\Request;
// test
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
Route::get("sample", function() {
    $data = ["name" => "test"];
    return $data;
});
Route::get("tickets", "TicketController@apiIndex");


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
