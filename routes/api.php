<?php

use App\Events\ChatPusherEvent;
use App\Http\Controllers\AuthController;
use App\Http\Requests\Chat\ParticipantAddRequest;
use App\Http\Requests\PusherChatRequest;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\ChatImage;
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

Route::get('/categories', [CategoryController::class, 'categories']);
Route::get('/news', [ProductController::class, 'news']);
Route::get('/sliders', [ProductController::class, 'sliders']);
Route::get('/type_sale', [ProductController::class, 'typeSale']);
Route::get('/shipping_type', [OrderController::class, 'shippingType']);
Route::get('/payment_type', [OrderController::class, 'paymentType']);
Route::get('/order_status', [OrderController::class, 'orderStatus']);
Route::post('/cart/addByAdmin', [CartController::class, 'addByAdmin']);
Route::get('/voucher', [OrderController::class, 'voucher']);
Route::prefix('product')->group(function () {
    Route::post('/inc/{id}', [ProductController::class, 'incView']);
    Route::get('/flash_sale', [ProductController::class, 'flashSale']);
    Route::get('/', [ProductController::class, 'list']);
    Route::get('/{id}', [ProductController::class, 'detail']);
});

Route::prefix('cart')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/', [CartController::class, 'getCart']);
        Route::post('/add', [CartController::class, 'addCart']);
        Route::put('/update', [CartController::class, 'updateCart']);
        Route::delete('/delete/{id}', [CartController::class, 'deleteCart']);
    });
});

Route::prefix('order')->group(function () {
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::get('/', [OrderController::class, 'getOrder']);
        Route::post('/add', [OrderController::class, 'addOrder']);
        Route::delete('/delete/{id}', [OrderController::class, 'deleteOrder']);
        Route::get('/orderCount', [OrderController::class, 'orderCount']);
        Route::get('/changeStatus/{id}', [OrderController::class, 'changeStatus']);
        Route::get('/applyVoucher', [OrderController::class, 'applyVoucher']);
    });
});

Route::prefix('user')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/signin', [AuthController::class, 'signin']);
        Route::post('/check_exist', [AuthController::class, 'checkExist']);
        Route::post('/check_phone', [AuthController::class, 'checkPhone']);
        Route::post('/reset_password', [AuthController::class, 'rsPassword']);

        Route::group(['middleware' => ['auth:sanctum']], function () {
            Route::post('/logout', [AuthController::class, 'logout']);
            Route::post('/edit', [AuthController::class, 'edit']);
            Route::post('/avatar', [AuthController::class, 'updateImage']);
            Route::post('/avatar', [AuthController::class, 'updateImage']);
            Route::get('/referral/get', [AuthController::class, 'getReferral']);
            Route::post('/referral', [AuthController::class, 'referral']);
            Route::get('/list', [AuthController::class, 'list']);
            Route::post('/add_address', [AuthController::class, 'addAddress']);
            Route::delete('/address/{id}', [AuthController::class, 'delAddress']);
            Route::get('/address', [AuthController::class, 'address']);
            Route::post('/change_password', [AuthController::class, 'changePassword']);
            Route::delete('/delete_account', [AuthController::class, 'deleteAccount']);
        });

    });

    Route::prefix('chat')->group(function () {
        Route::group(['middleware' => ['auth:sanctum', 'banned']], function () {
            Route::post('/', function (PusherChatRequest $request) {
                $chat = Chat::create([
                    'content' => $request->contents,
                    'user_id' => auth()->id(),
                    'chat_group_id' => (int)$request->chat_group_id,
                ]);

                foreach (ParticipantChat::where('chat_group_id', $request->chat_group_id)->get() as $item) {
                    $item->touch();
                    if (auth()->id() != $item->user_id) {
                        event(new ChatPusherEvent($request, $item, auth()->id(), auth()->user()->feature_image_path, $chat->images));
                    }
                    Notification::sendNotificationFirebase($item->user_id, $request->contents, null, 'Chat', auth()->id(), $request->chat_group_id);

                    if ($item->user_id == auth()->id()) {
                        $item->update([
                            'is_read' => 1
                        ]);
                    } else {
                        $item->update([
                            'is_read' => 0
                        ]);
                    }
                }

                return response()->json($chat);
            });

            Route::post('/image', function (PusherChatRequest $request) {

                $chat = Chat::create([
                    'user_id' => auth()->id(),
                    'content' => $request->contents,
                    'chat_group_id' => (int)$request->chat_group_id,
                ]);

                if ($request->hasFile('feature_images')) {
                    foreach ($request->file('feature_images') as $fileItem) {
                        $dataChatImageDetail = StorageImageTrait::storageTraitUploadMultiple($fileItem, 'chat');
                        ChatImage::create([
                            'image_name' => $dataChatImageDetail['file_name'],
                            'image_path' => $dataChatImageDetail['file_path'],
                            'chat_id' => $chat->id,
                        ]);
                    }
                }

                foreach (ParticipantChat::where('chat_group_id', $request->chat_group_id)->get() as $item) {
                    $item->touch();
                    if (auth()->id() != $item->user_id) {
                        event(new ChatPusherEvent($request, $item, auth()->id(), auth()->user()->feature_image_path, $chat->images));
                    }
                    Notification::sendNotificationFirebase($item->user_id, $request->contents, null, 'Chat', auth()->id(), $request->chat_group_id);
                }

                return response()->json($chat);
            });

            Route::prefix('participant')->group(function () {

                Route::get('/', function (Request $request) {
                    $participantChat = ParticipantChat::where('user_id', auth()->id())->first();

                    if (empty($participantChat)) {
                        return response()->json([
                            "code" => 404,
                            "message" => "Không tìm thấy nhóm chat"
                        ], 404);
                    }

                    $participantChat->update([
                        'is_read' => 1
                    ]);
                    $limit = $request['limit'] ?? 10;
                    $page = $request['page'] ?? 1;
                    $results = Chat::where('chat_group_id', $participantChat->id)->latest('updated_at')->limit($limit)->offset($limit * ($page - 1))->get();

                    //$results = $results->latest('updated_at')->paginate((int)filter_var($request->limit ?? '10', FILTER_SANITIZE_NUMBER_INT))->appends(request()->query());

                    foreach ($results as $item) {
                        $item->images;
                    }
                    return response([
                            'data' => $results
                        ]
                    );
                });

                Route::get('/refresh/{id}', function (Request $request, $chatGroupId) {
                    if (empty(ParticipantChat::where('user_id', auth()->id())->where('chat_group_id', $chatGroupId)->first())) {
                        return response()->json([
                            "code" => 404,
                            "message" => "Không tìm thấy nhóm chat"
                        ], 404);
                    }

                    $item = ParticipantChat::where('chat_group_id', $chatGroupId)->where("user_id", auth()->id())->first();

                    $item->chatGroup;

                    $item->users = $item->users();

                    foreach ($item->users as $user) {
                        $user['profile'] = $user->profilePairing($request, $user->id);
                    }

                    $queries = ["chat_group_id" => $item->chatGroup->id];
                    $requestMessage = $request;
                    $requestMessage->limit = 2;
                    $resultsMessage = RestfulAPI::response(Chat::class, $requestMessage, $queries);

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

                Route::delete('/{id}', function (Request $request, $chatGroupId) {
                    $participantChat = ParticipantChat::where('user_id', auth()->id())->where('chat_group_id', $chatGroupId)->first();
                    if (!empty($participantChat)) {
                        $participantChat->delete();
                    }

                    return response()->json([
                        'message' => 'deleted!',
                        'code' => 200
                    ]);
                });
            });
        });
    });

});
