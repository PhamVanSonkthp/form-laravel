<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\Formatter;
use App\Models\Helper;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\ParticipantChat;
use App\Models\Product;
use App\Models\RestfulAPI;
use App\Models\User;
use App\Models\UserCart;
use App\Models\UserProductRecent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{

    private $model;

    public function __construct(Order $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        $queries = ['user_id' => auth()->id()];
        $results = RestfulAPI::response($this->model, $request, $queries);
        return response()->json($results);
    }

    public function store(Request $request)
    {
        $request->validate([
            'cart_ids' => 'required|array|min:1',
            "cart_ids.*" => "required|numeric|min:1",
        ]);

        DB::beginTransaction();

        $item = $this->model->create([
            'user_id' => auth()->id(),
        ]);

        foreach ($request->cart_ids as $cart_id) {
            $cartItem = UserCart::find($cart_id);

            if (empty($cartItem) || $cartItem->user_id != auth()->id()) {
                DB::rollback();
                return response()->json(Helper::errorAPI(99, [
                    'cart_id' => $cart_id
                ], "Mã giỏ hàng không hợp lệ"), 400);
            }

            $orderProduct = OrderProduct::create([
                'order_id' => $item->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->priceByUser(),
                'name' => $cartItem->product->name,
            ]);

            $orderProduct->fill(['order_size' => $cartItem->product->size, 'order_color' => $cartItem->product->color])->save();

            $cartItem->delete();
        }

        DB::commit();

        $item->refresh();

        return response()->json($item);
    }

}
