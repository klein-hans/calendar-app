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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::prefix('calendar')->group(function () 
{
    Route::get('', 'CalendarController@index');
    Route::post('/store', 'CalendarController@store');
    // Route::put('{id}', 'CalendarController@update');
    // Route::delete('{id}', 'CalendarController@destroy');
    // Route::->patch('{id}', 'CalendarController@restore');
});