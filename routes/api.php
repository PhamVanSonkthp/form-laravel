<?php

use App\Events\ChatPusherEvent;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CategoryNewsController;
use App\Http\Controllers\API\CategoryProductsController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\NotificationController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\SliderController;
use App\Http\Controllers\API\SystemBranchController;
use App\Http\Controllers\API\VoucherController;
use App\Http\Requests\Chat\ParticipantAddRequest;
use App\Http\Requests\PusherChatRequest;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\ChatImage;
use App\Models\Helper;
use App\Models\Image;
use App\Models\Notification;
use App\Models\ParticipantChat;
use App\Models\RestfulAPI;
use App\Traits\StorageImageTrait;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('cron')->group(function () {
    Route::get('/', [
        'uses'=>'App\Http\Controllers\Cronner\CronnerController@callback',
    ]);
});

Route::prefix('public')->group(function () {

    Route::prefix('products')->group(function () {
        Route::get('/', [ProductController::class, 'list']);
        Route::get('/{id}', [ProductController::class, 'get']);

        Route::prefix('comments')->group(function () {
            Route::get('/{id}', [ProductController::class, 'getProductComment']);
            Route::post('/{id}', [ProductController::class, 'createProductComment']);
        });
    });

    Route::prefix('cart')->group(function () {
        Route::post('/', [CartController::class, 'listNotAuth']);
    });

    Route::prefix('order')->group(function () {
        Route::post('/', [OrderController::class, 'storeNotAuth']);
    });

    Route::prefix('news')->group(function () {
        Route::get('/', [NewsController::class, 'list']);
        Route::get('/{id}', [NewsController::class, 'get']);
    });

    Route::prefix('categories-news')->group(function () {
        Route::get('/', [CategoryNewsController::class, 'list']);
        Route::get('/{id}', [CategoryNewsController::class, 'get']);
    });

    Route::prefix('categories-products')->group(function () {
        Route::get('/', [CategoryProductsController::class, 'list']);
        Route::get('/{id}', [CategoryProductsController::class, 'get']);
    });

    Route::prefix('system-branches')->group(function () {
        Route::get('/', [SystemBranchController::class, 'list']);
        Route::get('/{id}', [SystemBranchController::class, 'get']);
    });

    Route::prefix('sliders')->group(function () {
        Route::get('/', [SliderController::class, 'list']);
        Route::get('/{id}', [SliderController::class, 'get']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/sign-in', [AuthController::class, 'signIn']);
        Route::post('/check-exist', [AuthController::class, 'checkExist']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
    });
});

Route::prefix('user')->group(function () {

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::prefix('auth')->group(function () {
            Route::post('/logout', [AuthController::class, 'logout']);
        });

        Route::prefix('profile')->group(function () {
            Route::get('/', [AuthController::class, 'get']);
            Route::post('/', [AuthController::class, 'update']);
            Route::delete('/', [AuthController::class, 'delete']);
        });

        Route::prefix('notification')->group(function () {
            Route::get('/', [NotificationController::class, 'list']);
            Route::get('/count-not-read', [NotificationController::class, 'countNotRead']);
            Route::post('/read/{id}', [NotificationController::class, 'read']);
        });

        Route::prefix('product-seen-recent')->group(function () {
            Route::get('/', [ProductController::class, 'productSeenRecent']);
        });

        Route::prefix('cart')->group(function () {
            Route::get('/', [CartController::class, 'list']);
            Route::post('/', [CartController::class, 'store']);
            Route::put('/{id}', [CartController::class, 'update']);
            Route::delete('/{id}', [CartController::class, 'delete']);
        });

        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'list']);
            Route::post('/', [OrderController::class, 'store']);
        });

        Route::prefix('voucher')->group(function () {
            Route::get('/', [VoucherController::class, 'list']);
            Route::post('/', [VoucherController::class, 'store']);
            Route::post('/check-with-carts', [VoucherController::class, 'checkWithCarts']);
            Route::post('/check-with-products', [VoucherController::class, 'checkWithProducts']);
        });
    });


    Route::prefix('chat')->group(function () {
        Route::group(['middleware' => ['auth:sanctum', 'banned']], function () {
            Route::post('/', function (PusherChatRequest $request) {

                $request->validate([
                    'contents' => 'required',
                    'chat_group_id' => 'required',
                    'images' => 'nullable',
                    'images.*' => 'nullable|mimes:jpg,jpeg,png',
                ]);

                $chatModel = new Chat();

                $chat = $chatModel->create([
                    'content' => $request->contents,
                    'user_id' => auth()->id(),
                    'chat_group_id' => (int)$request->chat_group_id,
                ]);

                if (is_array($request->images)){
                    foreach ($request->images as $image) {

                        $item = Image::create([
                            'uuid' => Helper::getUUID(),
                            'table' => $chatModel->getTableName(),
                            'image_path' => "waiting",
                            'image_name' => "waiting",
                            'relate_id' => $chat->id,
                        ]);


                        $dataUploadFeatureImage = StorageImageTrait::storageTraitUpload($request, $image,  'product_comments', $item->id);

                        $dataUpdate = [
                            'image_path' => $dataUploadFeatureImage['file_path'],
                            'image_name' => $dataUploadFeatureImage['file_name'],
                        ];

                        $item->update($dataUpdate);

                    }
                }

//                foreach (ParticipantChat::where('chat_group_id', $request->chat_group_id)->get() as $item) {
//                    $item->touch();
//                    if (auth()->id() != $item->user_id) {
//                        event(new ChatPusherEvent($request, $item, auth()->id(), auth()->user()->feature_image_path, $chat->images));
//                    }
//                    Notification::sendNotificationFirebase($item->user_id, $request->contents, null, 'Chat', auth()->id(), $request->chat_group_id);
//
//                    if ($item->user_id == auth()->id()) {
//                        $item->update([
//                            'is_read' => 1
//                        ]);
//                    } else {
//                        $item->update([
//                            'is_read' => 0
//                        ]);
//                    }
//                }

                $chat->refresh();

                return response()->json($chat);
            });

            Route::prefix('participant')->group(function () {

                Route::get('/', function (Request $request) {

                    $participantModel = new ParticipantChat();
                    $queries = ['user_id' => auth()->id()];
                    $results = RestfulAPI::response($participantModel, $request, $queries);
                    return response()->json($results);
                });

                Route::get('/{id}', function (Request $request, $chatGroupId) {
                    if (empty(ParticipantChat::where('user_id', auth()->id())->where('chat_group_id', $chatGroupId)->first())) {
                        return response()->json([
                            "code" => 404,
                            "message" => "Không tìm thấy nhóm chat"
                        ], 404);
                    }

                    $item = ParticipantChat::where('chat_group_id', $chatGroupId)->where("user_id", auth()->id())->first();

                    $item->chatGroup;

                    $item->users = $item->users();


                    $queries = ["chat_group_id" => $item->chatGroup->id];
                    $requestMessage = $request;
                    $requestMessage->limit = 2;
                    $resultsMessage = RestfulAPI::response(new Chat(), $requestMessage, $queries);

                    foreach ($resultsMessage as $message) {
                        $message->images;
                    }
                    $item->messages = $resultsMessage;

                    return $item;
                });

                Route::post('/create', function (ParticipantAddRequest $request) {

                    $chatGoupsOfGetter = ParticipantChat::where('user_id', $request->getter_id)->get();
                    $chatGoupsOfSender = ParticipantChat::where('user_id', auth()->id())->get();

                    foreach ($chatGoupsOfGetter as $itemGetter) {
                        foreach ($chatGoupsOfSender as $itemSender) {
                            if ($itemSender->chat_group_id == $itemGetter->chat_group_id) {
                                $chatGoup = ChatGroup::find($itemSender->chat_group_id);
                                ParticipantChat::firstOrCreate(
                                    [
                                        'user_id' => auth()->id(),
                                        'chat_group_id' => $chatGoup->id,
                                    ]
                                );

                                ParticipantChat::firstOrCreate(
                                    [
                                        'user_id' => $request->getter_id,
                                        'chat_group_id' => $chatGoup->id,
                                    ]
                                );

                                return response()->json($chatGoup);
                            }
                        }
                    }

                    $chatGoup = ChatGroup::create([
                        'title' => $request->title
                    ]);

                    ParticipantChat::create(
                        [
                            'user_id' => auth()->id(),
                            'chat_group_id' => $chatGoup->id,
                        ]
                    );

                    ParticipantChat::create(
                        [
                            'user_id' => $request->getter_id,
                            'chat_group_id' => $chatGoup->id,
                        ]
                    );

                    return response()->json($chatGoup);
                });


            });
        });
    });

});
