<?php

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
Route::get('/notification/list/{unread?}', 'NotificationController@list')->name('notification-list');
Route::get('/notification/unread', 'NotificationController@unreadCount')->name('notification-unread');
Route::post('/notification/{id}/read', 'NotificationController@markAsRead')->name('notification-markAsRead');
Route::post('/notification/read', 'NotificationController@markAllRead')->name('notification-markAllRead');

Route::get('/notification/status', 'NotificationController@status')->name('notification-status');
Route::post('/notification/enable', 'NotificationController@enable')->name('notification-enable');
Route::post('/notification/disable', 'NotificationController@disable')->name('notification-disable');
Route::post('/notification/pause/{duration}', 'NotificationController@pause')->name('notification-pause');

// Camera Routes
Route::get('/camera/status', 'CameraController@status')->name('camera-status');
Route::post('/camera/motion/enable', 'CameraController@enableMotion')->name('camera-motion-enable');
Route::post('/camera/motion/disable', 'CameraController@disableMotion')->name('camera-motion-disable');

// Event Routes
Route::post('/event/motion', 'EventController@motion')->name('event-motion');
