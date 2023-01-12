<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chat;
use App\Models\ChatGroup;
use App\Models\News;
use App\Models\ParticipantChat;
use App\Models\Product;
use App\Models\RestfulAPI;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NewsController extends Controller
{

    public function list(Request $request)
    {
        $queries = $request->all();
        $results = RestfulAPI::response(News::class, $request, $queries);

        foreach ($results as $item){
            $item['price'] = $item->priceSale($request);
        }

        return response()->json($results);
    }
}
