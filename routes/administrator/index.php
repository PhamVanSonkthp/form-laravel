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

// ajax
Route::prefix('administrator')->group(function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::prefix('chat')->group(function () {
            Route::prefix('participant')->group(function () {

                Route::get('/{id}', function (Request $request, $chatGroupId) {
                    if (empty(ParticipantChat::where('user_id', auth()->id())->where('chat_group_id', $chatGroupId)->first())) {
                        return response()->json([
                            "code" => 404,
                            "message" => "Không tìm thấy nhóm chat"
                        ], 404);
                    }

                    $queries = ["chat_group_id" => $chatGroupId];
                    $results = RestfulAPI::response(Chat::class, $request, $queries);

                    foreach ($results as $item) {
                        $item->user;
                        $item->images;
                    }
                    return $results;
                })->name('administrator.chat.participant');

            });

            Route::post('/create', function (PusherChatRequest $request) {

                $chat = Chat::create([
                    'content' => $request->contents,
                    'user_id' => auth()->id(),
                    'chat_group_id' => $request->chat_group_id,
                ]);

                for ($x = 0; $x < $request->total_files; $x++) {
                    if ($request->hasFile('feature_image' . $x)) {
                        $dataChatImageDetail = StorageImageTrait::storageTraitUploadMultiple( $request->file('feature_image'.$x),  'chat');

                        ChatImage::create([
                            'image_name' => $dataChatImageDetail['file_name'],
                            'image_path' => $dataChatImageDetail['file_path'],
                            'chat_id' => $chat->id,
                        ]);
                    }
                }

                foreach (ParticipantChat::where('chat_group_id', $request->chat_group_id)->get() as $item) {
                    if (auth()->id() != $item->user_id) {
                        $image_link = User::find($item->user_id)->feature_image_path;
                        event(new ChatPusherEvent($request, $item, auth()->id(), $image_link,$chat->images));
                    }

                    Notification::sendNotificationFirebase($item->user_id, $request->contents,null,'Chat',auth()->id(), $request->chat_group_id);

                    if ($item->user_id == auth()->id()){
                        $item->update([
                            'is_read' => 1
                        ]);
                    }else{
                        $item->update([
                            'is_read' => 0
                        ]);
                    }

                }

                return response()->json($chat);
            })->name('administrator.chat.create');

        });
    });
});

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

        Route::post('/store', [
            'as' => 'administrator.users.store',
            'uses' => 'App\Http\Controllers\Admin\AdminUserController@store',
            'middleware' => 'can:user-add',
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

        Route::get('/delete/{id}', [
            'as' => 'administrator.news.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminNewsController@delete',
            'middleware' => 'can:news-delete',
        ]);

    });

    Route::prefix('email')->group(function () {
        Route::get('/', [
            'as' => 'administrator.email.index',
            'uses' => 'App\Http\Controllers\Admin\AdminEmailController@index',
            'middleware' => 'can:email-list',
        ]);

        Route::post('/store', [
            'as' => 'administrator.email.store',
            'uses' => 'App\Http\Controllers\Admin\AdminEmailController@store',
            'middleware' => 'can:email-add',
        ]);

        Route::get('/delete/{id}', [
            'as' => 'administrator.email.delete',
            'uses' => 'App\Http\Controllers\Admin\AdminEmailController@delete',
            'middleware' => 'can:email-delete',
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

});

