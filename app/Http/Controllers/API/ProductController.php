<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\ParticipantChat;
use App\Models\Product;
use App\Models\RestfulAPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{

    public function list(Request $request)
    {
        $queries = ['product_visibility_id' => 2];
        $results = RestfulAPI::response(Product::class, $request, $queries, null, ['price_import', 'price_client', 'price_agent']);

        foreach ($results as $item){
            $item['price'] = $item->priceSale($request);
        }

        return response()->json($results);
    }
}
