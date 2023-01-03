<?php

namespace App\Models;

use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Helper extends Model
{
    use HasFactory;

    use DeleteModelTrait;
    use StorageImageTrait;

    public static function getNextIdTable($table)
    {

        try {
            $item = DB::table($table)->latest()->first();
            return $item->id + 1;
//            $statement = DB::select("SHOW TABLE STATUS LIKE '$table'");
//            return $statement[0]->Auto_increment;
        } catch (\Exception $exception) {
            return 1;
        }

    }

    public static function getTableName($object)
    {
        return $object->getTable();
    }

    public static function getDefaultIcon($object, $size = "100x100")
    {
        $image = $object->image;

        if (!empty($image)) {
            return Formatter::getThumbnailImage($image->image_path, $size);
        }

        return config('_my_config.default_avatar');
    }

    public static function image($object)
    {
        $item = $object->hasOne(SingpleImage::class, 'relate_id', 'id')->where('table', $object->getTable());
        if (empty($item->image)) {
            return $object->hasOne(Image::class, 'relate_id', 'id')->where('table', $object->getTable())->orderBy('index');
        }

        return $item;
    }

    public static function images($object)
    {
        return $object->hasMany(Image::class, 'relate_id', 'id')->where('table', $object->getTable())->orderBy('index');
    }

    public static function searchByQuery($object, $request, $queries = [])
    {
        $columns = Schema::getColumnListing($object->getTableName());
        $query = $object->query();

        $searchLikeColums = ['name', 'title'];

        foreach ($request->all() as $key => $item) {
            $item = trim($item);
            if ($key == "search_query") {
                if (!empty($item) || strlen($item) > 0) {

                    $query = $query->where(function ($query) use ($item, $columns, $searchLikeColums) {
                        foreach ($searchLikeColums as $searchColumn){
                            if (in_array($searchColumn , $columns)){
                                $query->orWhere($searchColumn, 'LIKE', "%{$item}%");
                            }
                        }
                    });
                }
            } else if ($key == "gender_id") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where('gender_id', $item);
                }
            } else if ($key == "start") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '>=', $item);
                }
            } else if ($key == "end") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '<=', $item);
                }
            }
        }

        foreach ($queries as $key => $item) {
            $item = trim($item);
            if ($key == "search_query") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where(function ($query) use ($item) {
                        $query->orWhere('name', 'LIKE', "%{$item}%");
                    });
                }
            } else if ($key == "gender_id") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where('gender_id', $item);
                }
            } else if ($key == "start") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '>=', $item);
                }
            } else if ($key == "end") {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->whereDate('created_at', '<=', $item);
                }
            } else {
                if (!empty($item) || strlen($item) > 0) {
                    $query = $query->where($key, $item);
                }
            }
        }

        return $query->latest()->paginate(Formatter::getLimitRequest($request->limit))->appends(request()->query());
    }

    public static function storeByQuery($object, $request, $dataCreate)
    {
        $item = $object->create($dataCreate);
        return $item;
    }

    public static function updateByQuery($object, $request, $id, $dataUpdate)
    {
        $object->find($id)->update($dataUpdate);
        $item = $object->find($id);
        return $item;
    }

    public static function deleteByQuery($object, $request, $id, $forceDelete = false)
    {
        return $object->deleteModelTrait($id, $object,$forceDelete);
    }

    public static function addSlug($object, $key, $value){
        $item = $object->where($key , Str::slug($value))->first();
        if (empty($item)){
            return Str::slug($value);
        }
        for ($i = 1; $i < 100000; $i++){
            $item = $object->where($key , Str::slug($value) . '-' . $i)->first();
            if (empty($item)){
                return Str::slug($value). '-' . $i;
            }
        }
        return Str::random(40);
    }
}