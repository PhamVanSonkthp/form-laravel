<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class RestfulAPI extends Model
{
    use HasFactory;

    public function response($model, $request, $queries = null, $randomRecord = null){
        $query = $model::query();

        if (!empty($queries) && is_array($queries)){
            foreach ($queries as $key => $item){
                $query = $query->where($key, $item);
            }
        }
        if (isset($request->search_query) && !empty($request->search_query)){
            $query = $query->where('name', 'like',  '%'. $request->search_query.'%' );
        }
        if (isset($request->category) && !empty($request->category)){
            $query = $query->where('category_id', 'like',  '%'. $request->category);
        }
        if (!empty($randomRecord)){
            $query = $query->inRandomOrder();
        }
        return $query->latest()->paginate( (int) filter_var($request->limit ?? '10', FILTER_SANITIZE_NUMBER_INT))->appends(request()->query());
    }


    public function responseCustomResult($model, $request, $queries = null, $randomRecord = null){
        $query = $model::query();

        if (!empty($queries) && is_array($queries)){
            foreach ($queries as $key => $item){
                $query = $query->where($key, $item);
            }
        }
        if (isset($request->search_query) && !empty($request->search_query)){
            $query = $query->where('name', 'like',  '%'. $request->search_query.'%' );
        }
        if (!empty($randomRecord)){
            $query = $query->inRandomOrder();
        }
        return $query;
    }
}
