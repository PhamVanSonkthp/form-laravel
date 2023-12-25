<?php

use App\Events\ChatPusherEvent;
use App\Http\Controllers\API\VoucherController;
use App\Http\Requests\PusherChatRequest;
use App\Models\Chat;
use App\Models\ChatImage;
use App\Models\Helper;
use App\Models\Image;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ParticipantChat;
use App\Models\Product;
use App\Models\RestfulAPI;
use App\Models\SingleImage;
use App\Models\User;
use App\Models\UserCart;
use App\Models\UserPoint;
use App\Models\UserStatus;
use App\Models\UserTransaction;
use App\Models\UserType;
use App\Models\Voucher;
use App\Models\VoucherUsed;
use App\Traits\StorageImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

// ajax
Route::prefix('ajax/administrator')->group(function () {
    Route::group(['middleware' => ['auth']], function () {

        Route::prefix('user')->group(function () {

            Route::get('/', function (Request $request) {

                $item = User::find($request->id);

                $userTypes = UserType::all();
                $userStatuses = UserStatus::all();

                $htmlRow = View::make('administrator.users.modal_edit', compact('item', 'userTypes', 'userStatuses'))->render();

                $item['html'] = $htmlRow;

                return response()->json($item);

            })->name('ajax.administrator.user.get');

            Route::post('/', function (Request $request) {

                $request->validate([
                    'name' => 'required|string',
                    'phone' => 'required|string|unique:users',
                    'password' => 'required|string',
                    'date_of_birth' => 'date_format:Y-m-d',
                    'user_type_id' => 'required|numeric|min:1|max:3',
                ]);

                $data = [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'address' => $request->address,
                    'password' => Formatter::hash($request->password),
                    'date_of_birth' => $request->date_of_birth,
                    'firebase_uid' => $request->firebase_uid,
                    'provider_name' => $request->provider_name,
                    'user_type_id' => $request->user_type_id,
                    'user_status_id' => $request->user_status_id,
                    'gender_id' => $request->gender_id,
                ];

                $item = User::create($data);
                $item->refresh();

                $htmlRowAdd = View::make('administrator.users.row_add', compact('item'))->render();
                $item['html_row_add'] = $htmlRowAdd;

                return response()->json($item);

            })->name('ajax.administrator.user.store');

            Route::put('/', function (Request $request) {

                $item = User::find($request->id);

                $dataUpdate = [];

                if (isset($request->user_status_id)) {
                    $dataUpdate['user_status_id'] = $request->user_status_id;
                }
                if (isset($request->name)) {
                    $dataUpdate['name'] = $request->name;
                }
                if (isset($request->phone)) {
                    $dataUpdate['phone'] = $request->phone;
                }
                if (isset($request->email)) {
                    $dataUpdate['email'] = $request->email;
                }
                if (isset($request->date_of_birth)) {
                    $dataUpdate['date_of_birth'] = $request->date_of_birth;
                }
                if (isset($request->address)) {
                    $dataUpdate['address'] = $request->address;
                }
                if (isset($request->user_status_id)) {
                    $dataUpdate['user_status_id'] = $request->user_status_id;
                }
                if (isset($request->user_type_id)) {
                    $dataUpdate['user_type_id'] = $request->user_type_id;
                }
                if (isset($request->password) && !empty($request->password)) {
                    $dataUpdate['password'] = $request->password;
                }
                if (isset($request->gender_id) && !empty($request->gender_id)) {
                    $dataUpdate['gender_id'] = $request->gender_id;
                }

                $item->update($dataUpdate);
                $item->refresh();

                $htmlRow = View::make('administrator.users.row', ['item' => $item, 'prefixView' => 'users'])->render();
                $item['html_row'] = $htmlRow;

                return response()->json($item);

            })->name('ajax.administrator.user.update');

        });

        Route::prefix('orders')->group(function () {

            Route::post('/', function (Request $request) {

                $request->validate([
                    'quantities' => 'required|array|min:1',
                    "quantities.*" => "required|numeric|min:1",
                    'product_ids' => 'required|array|min:1',
                    "product_ids.*" => "required|numeric|min:1",
                ]);

                if (count($request->quantities) != count($request->product_ids)) {
                    return response()->json(Helper::errorAPI(99, [], "2 mảng phải bằng nhau"), 400);
                }

                DB::beginTransaction();


                $model = new Order();

                $user = User::find($request->user_id);

                $item = $model->create([
                    'user_id' => $request->user_id ?? 0,
                    'user_name' => optional($user)->name ?? "Khách lẻ",
                    'user_phone' => optional($user)->phone,
                    'user_address' => optional($user)->address,
                    'user_email' => optional($user)->email,
                    'shipping_fee' => $request->shipping_fee,
                ]);

                $amount = $request->shipping_fee ?? 0;

                foreach ($request->product_ids as $index => $product_id) {

                    $product = Product::find($product_id);

                    if (empty($product)) continue;

                    $amount += $product->priceByUser() * $request->quantities[$index];

                    $orderProduct = OrderProduct::create([
                        'order_id' => $item->id,
                        'product_id' => $product->id,
                        'quantity' => $request->quantities[$index],
                        'price' => $product->priceByUser(),
                        'name' => $product->parent->name,
                        'product_image' => $product->parent->avatar(),
                    ]);

                    $orderProduct->fill(['order_size' => $product->size, 'order_color' => $product->color])->save();
                }

                if (isset($request->voucher_id) && !empty($request->voucher_id)) {
                    $voucher = Voucher::find($request->voucher_id);

                    if (empty($voucher)) {
                        $voucher = Voucher::where('code', $request->voucher_id)->first();
                    }

                    if (empty($voucher)) return response()->json(Helper::errorAPI(99, [], "voucher_id invalid"), 400);

                    if ($voucher->isLimited()) return response()->json(Helper::errorAPI(99, [], "voucher is limited"), 400);

                    if ($voucher->isLimitedByUser()) return response()->json(Helper::errorAPI(99, [], "voucher is limited by user"), 400);

                    if ($voucher->isExpired()) return response()->json(Helper::errorAPI(99, [], "voucher is is expired"), 400);

                    if ($voucher->isUnavailable()) return response()->json(Helper::errorAPI(99, [], "voucher is is unavailable"), 400);

                    $amount = UserCart::calculateAmountByIds($request->product_ids, false);

                    if ($voucher->isAcceptAmount($amount)) return response()->json(Helper::errorAPI(99, [], "voucher is is required min amount " . $voucher->min_amount), 400);

                    $discount = $voucher->amountDiscount($amount);

                    $amount = $amount - $discount;

                    if ($amount < 0) $amount = 0;

                    VoucherUsed::create([
                        'user_id' => $request->user_id ?? 0,
                        'voucher_id' => $voucher->id,
                    ]);

                    $voucher->increment('used');
                }

                $item->update([
                    'amount' => $amount
                ]);

                DB::commit();

                return response()->json($item);

            })->name('ajax.administrator.orders.store');

            Route::put('/', function (Request $request) {

                $request->validate([
                    'id' => 'required|min:1',
                    'quantities' => 'required|array|min:1',
                    "quantities.*" => "required|numeric|min:1",
                    'product_ids' => 'required|array|min:1',
                    "product_ids.*" => "required|numeric|min:1",
                ]);

                if (count($request->quantities) != count($request->product_ids)) {
                    return response()->json(Helper::errorAPI(99, [], "2 mảng phải bằng nhau"), 400);
                }

                DB::beginTransaction();



                $model = new Order();

                $user = User::find($request->user_id);

                $item = $model->findOrFail($request->id);

                $item->products()->delete();

                $item->update([
                    'user_id' => $request->user_id ?? 0,
                    'user_name' => optional($user)->name ?? "Khách lẻ",
                    'user_phone' => optional($user)->phone,
                    'user_address' => optional($user)->address,
                    'user_email' => optional($user)->email,
                    'shipping_fee' => $request->shipping_fee ?? 0,
                ]);

                $amount = $request->shipping_fee ?? 0;

                foreach ($request->product_ids as $index => $product_id) {

                    $product = Product::find($product_id);

                    if (empty($product)) continue;

                    $amount += $product->priceByUser() * $request->quantities[$index];

                    $orderProduct = OrderProduct::create([
                        'order_id' => $item->id,
                        'product_id' => $product->id,
                        'quantity' => $request->quantities[$index],
                        'price' => $product->priceByUser(),
                        'name' => $product->parent->name,
                        'product_image' => $product->parent->avatar(),
                    ]);

                    $orderProduct->fill(['order_size' => $product->size, 'order_color' => $product->color])->save();
                }

                $item->update([
                    'amount' => $amount - $item->amount_voucher,
                ]);

                DB::commit();

                return response()->json($item);

            })->name('ajax.administrator.orders.update');

            Route::put('/update-to-shipping', function (Request $request){

                $request->validate([
                    'id' => 'required|min:1',
                ]);

                $item = Order::findOrFail($request->id);

                $item->update([
                    'order_status_id' => 2
                ]);

                $item->refresh();

                $item['html'] = View::make('administrator.orders.row', ['item' => $item , 'prefixView' => 'orders'])->render();
                return response()->json($item);

            })->name('ajax.administrator.orders.update_to_shipping');

        });


        Route::prefix('voucher')->group(function () {
            Route::post('/check-with-products', [VoucherController::class, 'checkWithProducts'])->name('ajax.administrator.voucher.check_with_products');
        });

        Route::prefix('user-points')->group(function () {

            Route::post('/', function (Request $request) {

                $request->validate([
                    'user_id' => 'required',
                    'amount' => 'required',
                ]);

                $user = User::findOrFail($request->user_id);

                $user->addPoint($request->amount, $request->description ?? 'Admin GD');

                $item = UserPoint::where('user_id', $request->user_id)->latest()->first();

                $item['html_row'] = View::make('administrator.user_points.row', compact('item'))->render();

                return response()->json($item);

            })->name('ajax.administrator.user_points.store');

        });

        Route::prefix('user-transaction')->group(function () {

            Route::post('/', function (Request $request) {

                $request->validate([
                    'user_id' => 'required',
                    'amount' => 'required|numeric',
                ]);

                $user = User::findOrFail($request->user_id);

                $user->addAmount($request->amount, $request->description ?? 'Admin GD');

                $item = UserTransaction::where('user_id', $request->user_id)->latest()->first();

                $item['html_row'] = View::make('administrator.user_transactions.row', compact('item'))->render();

                return response()->json($item);

            })->name('ajax.administrator.user_transaction.store');

        });


        Route::prefix('/products')->group(function () {

            Route::get('/', [
                'as' => 'ajax.administrator.products.search',
                'uses' => 'App\Http\Controllers\Ajax\ProductController@search',
                'middleware' => 'can:products-list',
            ]);

            Route::put('/update', [
                'as' => 'ajax.administrator.products.update',
                'uses' => 'App\Http\Controllers\Ajax\ProductController@update',
                'middleware' => 'can:products-edit',
            ]);

        });

        Route::prefix('/product-comments')->group(function () {

            Route::get('/', [
                'as' => 'ajax.administrator.product_comments.get',
                'uses' => 'App\Http\Controllers\Ajax\ProductCommentController@get',
                'middleware' => 'can:products-list',
            ]);

            Route::put('/update', [
                'as' => 'ajax.administrator.product_comments.update',
                'uses' => 'App\Http\Controllers\Ajax\ProductCommentController@update',
                'middleware' => 'can:products-edit',
            ]);

        });

        Route::prefix('upload-image')->group(function () {
            Route::post('/store', function (Request $request) {

                $item = SingleImage::firstOrCreate([
                    'relate_id' => $request->id,
                    'table' => $request->table,
                ],[
                    'relate_id' => $request->id,
                    'table' => $request->table,
                    'image_path' => 'waiting_update',
                    'image_name' => 'waiting_update',
                ]);

                $dataUploadFeatureImage = StorageImageTrait::storageTraitUpload($request, 'image', 'single', $item->id);

                $item->update([
                    'image_path' => $dataUploadFeatureImage['file_path'],
                    'image_name' => $dataUploadFeatureImage['file_name'],
                ]);
                $item->refresh();

                return response()->json($item);

            })->name('ajax,administrator.upload_image.store');
        });

        Route::prefix('upload-multiple-images')->group(function () {

            Route::post('/store', function (Request $request) {

                $item = Image::create([
                    'uuid' => $request->id,
                    'table' => $request->table,
                    'image_path' => "waiting",
                    'image_name' => "waiting",
                    'relate_id' => $request->relate_id ?? 0,
                ]);

                $dataUploadFeatureImage = StorageImageTrait::storageTraitUpload($request, 'image','multiple', $item->id);

                $dataUpdate = [
                    'image_path' => $dataUploadFeatureImage['file_path'],
                    'image_name' => $dataUploadFeatureImage['file_name'],
                ];

                $item->update($dataUpdate);
                $item->refresh();

                return response()->json($item);

            })->name('ajax,administrator.upload_multiple_images.store');

            Route::delete('/delete', function (Request $request) {
                $image = Image::find($request->id);
                if (empty($image)){
                    $image = Image::where('uuid', $request->id)->first();
                }
                if (!empty($image)){
                    $image->delete();
                }
                return response()->json($image);
            })->name('ajax,administrator.upload_multiple_images.delete');

            Route::put('/sort', function (Request $request) {

                foreach ($request->ids as $index => $id){
                    $image = Image::find($id);
                    if (empty($image)){
                        $image = Image::where('uuid', $id)->first();
                    }

                    if (!empty($image)){
                        $image->update([
                            'index' => $index
                        ]);
                    }
                }

                return response()->json($request->ids);
            })->name('ajax,administrator.upload_multiple_images.sort');

        });
    });


    Route::prefix('/')->group(function () {
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
                        $results = RestfulAPI::response(new Chat(), $request, $queries);

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
                            $dataChatImageDetail = StorageImageTrait::storageTraitUpload( $request, 'feature_image'.$x,  'chat', $chat->id);

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

                        Notification::sendNotificationFirebase($item->user_id,$request->chat_group_id, $request->contents);

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

//                    return view('administrator.chat.components')->with(['itemChat' => $chat])->render();

                    return response()->json($chat);
                })->name('administrator.chat.create');

            });
        });
    });

});

