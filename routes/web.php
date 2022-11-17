<?php

use Illuminate\Support\Facades\Route;

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

Route::prefix('/')->group(function () {
    Route::get('/', [
        'as'=>'welcome.index',
        'uses'=>'App\Http\Controllers\User\UserController@index',
    ]);

    Route::get('/sms', [
        'as'=>'welcome.index',
        'uses'=>'App\Http\Controllers\Notification\NotificationController@sms',
    ]);

    Route::prefix('/vnpay')->group(function () {
        Route::get('/', [
//            'as'=>'welcome.index',
            'uses'=>'App\Http\Controllers\VNPay\VNPayController@index',
        ]);

        Route::post('/vnpay_create_payment', [
//            'as'=>'welcome.index',
            'uses'=>'App\Http\Controllers\VNPay\VNPayController@createPayment',
        ]);


    });


});


//Route::get('/send-notification', [\App\Http\Controllers\NotificationController::class, 'sendNotification']);
