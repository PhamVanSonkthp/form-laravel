<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\Formatter;
use App\Models\ParticipantChat;
use App\Models\Product;
use App\Models\RestfulAPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{

    private $model;

    public function __construct(Product $model)
    {
        $this->model = $model;
    }

    public function list(Request $request)
    {
        $request->validate([
            'min_price' => 'numeric',
            'max_price' => 'numeric',
        ]);

        $queries = ['product_visibility_id' => 2];
        //, 'price_client', 'price_agent'
        $results = RestfulAPI::response($this->model, $request, $queries, null, ['price_import'], true);

        if (isset($request->min_price)){
            $results = $results->where(function ($query) use ($request) {
                $query->where('price_client', '=>', $request->min_price)
                    ->orWhere('price_agent', '=>', $request->min_price);
            });
        }

        if (isset($request->max_price)){
            $results = $results->where(function ($query) use ($request) {
                $query->where('price_client', '<=', $request->max_price)
                    ->orWhere('price_agent', '<=', $request->max_price);
            });
        }

        $results = $results->latest()->paginate(Formatter::getLimitRequest($request->limit))->appends(request()->query());

        return response()->json($results);
    }
}
