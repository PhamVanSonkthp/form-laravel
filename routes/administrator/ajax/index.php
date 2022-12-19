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

// ajax
Route::prefix('ajax/administrator')->group(function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::prefix('upload-multiple-images')->group(function () {

            Route::post('/store', function (Request $request) {


                return response()->json($request);
            })->name('ajax,administrator.upload_multiple_images.store');

        });
    });
});

