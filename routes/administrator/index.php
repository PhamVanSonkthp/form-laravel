<?php

use App\Events\ChatPusherEvent;
use App\Http\Requests\PusherChatRequest;
use App\Models\Chat;
use App\Models\ChatImage;
use App\Models\Notification;
use App\Models\ParticipantChat;
use App\Models\RestfulAPI;
use App\Models\User;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/admin', 'App\Http\Controllers\Admin\AdminController@loginAdmin')->name('login');
Route::post('/admin', 'App\Http\Controllers\Admin\AdminController@postLoginAdmin');

Route::get('/admin/logout', [
    'as' => 'administrator.logout',
    'uses' => '\App\Http\Controllers\Admin\AdminController@logout'
]);

Route::prefix('administrator')->group(function () {

    Route::prefix('dashboard')->group(function () {
        Route::get('/', [
            'as' => 'administrator.dashboard.index',
            'uses' => 'App\Http\Controllers\Admin\AdminDashboardController@index',
            'middleware' => 'can:dashboard-list',
        ]);

    });

    Route::prefix('history-data')->group(function () {
        Route::get('/', [
            'as' => 'administrator.history_data.index',
            'uses' => 'App\Http\Controllers\Admin\AdminHistoryDataController@index',
            'middleware' => 'can:history-data-list',
        ]);

    });

    Route::prefix('logo')->group(function () {
        Route::get('/', [
            'as' => 'administrator.logo.add',
            'uses' => 'App\Http\Controllers\Admin\AdminLogoController@create',
            'middleware' => 'can:logo-list',
        ]);

        Route::post('/store', [
            'as' => 'administrator.logo.store',
            'uses' => 'App\Http\Controllers\Admin\AdminLogoController@store',
            'middleware' => 'can:logo-add',
        ]);

    });

    Route::prefix('users')->group(function () {

        Route::get('/', [
            'as' => 'administrator.users.index',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@index',
            'middleware' => 'can:user-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.users.create',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@create',
            'middleware' => 'can:user-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.users.store',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@store',
            'middleware' => 'can:user-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.users.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@edit',
            'middleware' => 'can:user-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.users.update',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@update',
            'middleware' => 'can:user-edit',
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'administrator.users.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@delete',
            'middleware' => 'can:user-delete',
        ]);

        Route::get('/export', [
            'as' => 'administrator.users.export',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@export',
            'middleware' => 'can:user-list',
        ]);

        Route::get('/{id}', [
            'as' => 'administrator.users.get',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@get',
            'middleware' => 'can:user-list',
        ]);

    });

    Route::prefix('chats')->group(function () {
        Route::get('/', [
            'as' => 'administrator.chats.index',
            'uses' => 'App\Http\Controllers\Admin\AdminChatController@index',
            'middleware' => 'can:chat-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.chats.create',
            'uses' => 'App\Http\Controllers\Admin\AdminChatController@create',
            'middleware' => 'can:chat-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.chats.store',
            'uses' => 'App\Http\Controllers\Admin\AdminChatController@store',
            'middleware' => 'can:chat-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.chats.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminChatController@edit',
            'middleware' => 'can:chat-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.chats.update',
            'uses' => 'App\Http\Controllers\Admin\AdminChatController@update',
            'middleware' => 'can:chat-edit',
        ]);


        Route::get('/delete/{id}', [
            'as' => 'administrator.chats.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminChatController@delete',
            'middleware' => 'can:chat-delete',
        ]);

    });

    Route::prefix('employees')->group(function () {
        Route::get('/', [
            'as' => 'administrator.employees.index',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@index',
            'middleware' => 'can:employee-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.employees.create',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@create',
            'middleware' => 'can:employee-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.employees.store',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@store',
            'middleware' => 'can:employee-add',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.employees.update',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@update',
            'middleware' => 'can:employee-edit',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.employees.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@edit',
            'middleware' => 'can:employee-edit',
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'administrator.employees.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@delete',
            'middleware' => 'can:employee-delete',
        ]);

        Route::get('/export', [
            'as' => 'administrator.users.export',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@export',
            'middleware' => 'can:employee-list',
        ]);

        Route::get('/{id}', [
            'as' => 'administrator.users.get',
            'uses' => 'App\Http\Controllers\Admin\AdminEmployeeController@get',
            'middleware' => 'can:employee-list',
        ]);

    });

    Route::prefix('roles')->group(function () {
        Route::get('/', [
            'as' => 'administrator.roles.index',
            'uses' => 'App\Http\Controllers\Admin\AdminRoleController@index',
            'middleware' => 'can:role-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.roles.create',
            'uses' => 'App\Http\Controllers\Admin\AdminRoleController@create',
            'middleware' => 'can:role-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.roles.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminRoleController@edit',
            'middleware' => 'can:role-edit',
        ]);

        Route::post('/store', [
            'as' => 'administrator.roles.store',
            'uses' => 'App\Http\Controllers\Admin\AdminRoleController@store',
            'middleware' => 'can:role-add',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.roles.update',
            'uses' => 'App\Http\Controllers\Admin\AdminRoleController@update',
            'middleware' => 'can:role-edit',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'administrator.roles.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminRoleController@delete',
            'middleware' => 'can:role-delete',
        ]);

    });

    Route::prefix('permissions')->group(function () {
        Route::get('/create', [
            'as' => 'administrator.permissions.create',
            'uses' => 'App\Http\Controllers\Admin\AdminPermissionController@create',
            'middleware' => 'can:permission-list',
        ]);

        Route::post('/store', [
            'as' => 'administrator.permissions.store',
            'uses' => 'App\Http\Controllers\Admin\AdminPermissionController@store',
            'middleware' => 'can:permission-add',
        ]);

    });

    Route::prefix('notification')->group(function () {
        Route::get('/', [
            'as' => 'administrator.notification.index',
            'uses' => 'App\Http\Controllers\Admin\AdminNotificationController@index',
            'middleware' => 'can:notification-list',
        ]);

        Route::get('/edit', [
            'as' => 'administrator.notification.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminNotificationController@edit',
            'middleware' => 'can:notification-edit',
        ]);

        Route::put('/update', [
            'as' => 'administrator.notification.update',
            'uses' => 'App\Http\Controllers\Admin\AdminNotificationController@update',
            'middleware' => 'can:notification-edit',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'administrator.notification.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminNotificationController@delete',
            'middleware' => 'can:notification-delete',
        ]);

    });

    Route::prefix('slider')->group(function () {
        Route::get('/', [
            'as' => 'administrator.slider.index',
            'uses' => 'App\Http\Controllers\Admin\AdminSliderController@index',
            'middleware' => 'can:slider-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.slider.create',
            'uses' => 'App\Http\Controllers\Admin\AdminSliderController@create',
            'middleware' => 'can:slider-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.slider.store',
            'uses' => 'App\Http\Controllers\Admin\AdminSliderController@store',
            'middleware' => 'can:slider-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.slider.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminSliderController@edit',
            'middleware' => 'can:slider-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.slider.update',
            'uses' => 'App\Http\Controllers\Admin\AdminSliderController@update',
            'middleware' => 'can:slider-edit',
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'administrator.slider.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminSliderController@delete',
            'middleware' => 'can:slider-delete',
        ]);

    });

    Route::prefix('news')->group(function () {
        Route::get('/', [
            'as' => 'administrator.news.index',
            'uses' => 'App\Http\Controllers\Admin\AdminNewsController@index',
            'middleware' => 'can:news-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.news.create',
            'uses' => 'App\Http\Controllers\Admin\AdminNewsController@create',
            'middleware' => 'can:news-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.news.store',
            'uses' => 'App\Http\Controllers\Admin\AdminNewsController@store',
            'middleware' => 'can:news-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.news.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminNewsController@edit',
            'middleware' => 'can:news-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.news.update',
            'uses' => 'App\Http\Controllers\Admin\AdminNewsController@update',
            'middleware' => 'can:news-edit',
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'administrator.news.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminNewsController@delete',
            'middleware' => 'can:news-delete',
        ]);

    });

    Route::prefix('job-email')->group(function () {
        Route::get('/', [
            'as' => 'administrator.job_emails.index',
            'uses' => 'App\Http\Controllers\Admin\AdminJobEmailController@index',
            'middleware' => 'can:job_email-list',
        ]);

        Route::post('/store', [
            'as' => 'administrator.job_emails.store',
            'uses' => 'App\Http\Controllers\Admin\AdminJobEmailController@store',
            'middleware' => 'can:job_email-add',
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'administrator.job_emails.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminJobEmailController@delete',
            'middleware' => 'can:job_email-delete',
        ]);

    });

    Route::prefix('job-notification')->group(function () {
        Route::get('/', [
            'as' => 'administrator.job_notifications.index',
            'uses' => 'App\Http\Controllers\Admin\JobNotificationController@index',
            'middleware' => 'can:jobnotification-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.job_notifications.create',
            'uses' => 'App\Http\Controllers\Admin\JobNotificationController@create',
            'middleware' => 'can:jobnotification-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.job_notifications.store',
            'uses' => 'App\Http\Controllers\Admin\JobNotificationController@store',
            'middleware' => 'can:jobnotification-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.job_notifications.edit',
            'uses' => 'App\Http\Controllers\Admin\JobNotificationController@edit',
            'middleware' => 'can:jobnotification-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.job_notifications.update',
            'uses' => 'App\Http\Controllers\Admin\JobNotificationController@update',
            'middleware' => 'can:jobnotification-edit',
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'administrator.job_notifications.delete',
            'uses' => 'App\Http\Controllers\Admin\JobNotificationController@delete',
            'middleware' => 'can:jobnotification-delete',
        ]);

        Route::get('/{id}', [
            'as' => 'administrator.job_notifications.get',
            'uses' => 'App\Http\Controllers\Admin\JobNotificationController@get',
            'middleware' => 'can:jobnotification-list',
        ]);

    });

    Route::prefix('category')->group(function () {
        Route::get('/', [
            'as' => 'administrator.category.index',
            'uses' => 'App\Http\Controllers\Admin\AdminCategoryController@index',
            'middleware' => 'can:category-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.category.create',
            'uses' => 'App\Http\Controllers\Admin\AdminCategoryController@create',
            'middleware' => 'can:category-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.category.store',
            'uses' => 'App\Http\Controllers\Admin\AdminCategoryController@store',
            'middleware' => 'can:category-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.category.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminCategoryController@edit',
            'middleware' => 'can:category-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.category.update',
            'uses' => 'App\Http\Controllers\Admin\AdminCategoryController@update',
            'middleware' => 'can:category-edit',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'administrator.category.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminCategoryController@delete',
            'middleware' => 'can:category-delete',
        ]);

    });

    Route::prefix('product')->group(function () {
        Route::get('/', [
            'as' => 'administrator.product.index',
            'uses' => 'App\Http\Controllers\Admin\AdminProductController@index',
            'middleware' => 'can:product-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.product.create',
            'uses' => 'App\Http\Controllers\Admin\AdminProductController@create',
            'middleware' => 'can:product-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.product.store',
            'uses' => 'App\Http\Controllers\Admin\AdminProductController@store',
            'middleware' => 'can:product-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.product.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminProductController@edit',
            'middleware' => 'can:product-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.product.update',
            'uses' => 'App\Http\Controllers\Admin\AdminProductController@update',
            'middleware' => 'can:product-edit',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'administrator.product.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminProductController@delete',
            'middleware' => 'can:product-delete',
        ]);

        Route::get('/export', [
            'as'=>'administrator.product.export',
            'uses'=>'App\Http\Controllers\Admin\AdminProductController@export',
            'middleware'=>'can:product-list',
        ]);

    });

    Route::prefix('setting')->group(function () {
        Route::get('/', [
            'as' => 'administrator.setting.index',
            'uses' => 'App\Http\Controllers\Admin\AdminSettingController@index',
            'middleware' => 'can:setting-list',
        ]);

        Route::get('/create', [
            'as' => 'administrator.setting.create',
            'uses' => 'App\Http\Controllers\Admin\AdminSettingController@create',
            'middleware' => 'can:setting-add',
        ]);

        Route::post('/store', [
            'as' => 'administrator.setting.store',
            'uses' => 'App\Http\Controllers\Admin\AdminSettingController@store',
            'middleware' => 'can:setting-add',
        ]);

        Route::get('/edit/{id}', [
            'as' => 'administrator.setting.edit',
            'uses' => 'App\Http\Controllers\Admin\AdminSettingController@edit',
            'middleware' => 'can:setting-edit',
        ]);

        Route::put('/update/{id}', [
            'as' => 'administrator.setting.update',
            'uses' => 'App\Http\Controllers\Admin\AdminSettingController@update',
            'middleware' => 'can:setting-edit',
        ]);

        Route::delete('/delete/{id}', [
            'as' => 'administrator.setting.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminSettingController@delete',
            'middleware' => 'can:setting-delete',
        ]);

    });

    Route::prefix('password')->group(function () {
        Route::get('/', [
            'as' => 'administrator.password.index',
            'uses' => 'App\Http\Controllers\Admin\AdminController@password',
        ]);
        Route::put('/', [
            'as' => 'administrator.password.update',
            'uses' => 'App\Http\Controllers\Admin\AdminController@updatePassword',
        ]);

    });

});

