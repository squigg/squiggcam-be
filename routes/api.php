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

// Notification Routes
Route::get('/notifications/settings', function (Request $request) {
    return [
        'enabled'        => 'true',
        'paused'         => 'true',
        'pause_duration' => '60',
        'unpause_at'     => '2017-06-06 17:58:13',
    ];
});

// Event Routes
Route::post('/event/motion', 'EventController@motion')->name('event-motion');
