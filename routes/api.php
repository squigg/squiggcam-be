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
Route::get('/notification/status', 'NotificationController@status')->name('notification-status');
Route::get('/notification/list', 'NotificationController@list')->name('notification-list');
Route::post('/notification/enable', 'NotificationController@enable')->name('notification-enable');
Route::post('/notification/disable', 'NotificationController@disable')->name('notification-disable');
Route::post('/notification/pause/{duration}', 'NotificationController@pause')->name('notification-pause');

// Event Routes
Route::post('/event/motion', 'EventController@motion')->name('event-motion');
