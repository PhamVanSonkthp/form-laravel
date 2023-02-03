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
            "cart_ids.*"  => "required|numeric|min:1",
        ]);

        DB::beginTransaction();

        $item = $this->model->create([
            'user_id' => auth()->id(),
        ]);

        foreach ($request->cart_ids as $cart_id){
            $cartItem = UserCart::find($cart_id);

            if (empty($cartItem) || $cartItem->user_id != auth()->id()){
                DB::rollback();
                return response()->json(Helper::errorAPI(99, [
                    'cart_id' => $cart_id
                ],"Mã giỏ hàng không hợp lệ"), 400);
            }

            OrderProduct::create([
                'order_id' => $item->id,
                'product_id' => $cartItem->product_id,
                'quantity' => $cartItem->quantity,
                'price' => $cartItem->product->priceByUser(),
                'name' => $cartItem->product->name,
            ]);

            $cartItem->delete();
        }

        DB::commit();

        $item->refresh();

        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1',
        ]);

        $item = $this->model->findOrFail($id);

        if ($item->user_id != auth()->id()){
            return response()->json(Helper::errorAPI(99, [],"Không tìm thấy giỏ hàng"), 400);
        }

        DB::beginTransaction();

        $item->update([
            'quantity' => $request->quantity
        ]);

        $item->refresh();

        $product = Product::find($item->product_id);

        if ($item->quantity > $product->inventory){
            DB::rollback();
            return response()->json(Helper::errorAPI(99, [
                'max_inventory' => $product->inventory
            ],"Số lượng sản phẩm không hợp lệ"), 400);
        }else{
            DB::commit();
        }

        return response()->json($item);
    }

    public function delete(Request $request, $id)
    {

        $item = $this->model->findOrFail($id);

        if ($item->user_id != auth()->id()){
            return response()->json(Helper::errorAPI(99, [],"Không tìm thấy giỏ hàng"), 400);
        }

        $item = $this->model->deleteByQuery($request, $id);

        return $item;
    }

}
