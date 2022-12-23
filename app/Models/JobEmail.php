<?php

namespace App\Models;

use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class JobEmail extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use DeleteModelTrait;
    use StorageImageTrait;

    protected $guarded = [];

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function searchByQuery($request, $queries = [], $isApi = false)
    {
        $query = $this->query();

        foreach ($request->all() as $key => $item) {
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
            }
        }

        foreach ($queries as $key => $item) {
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

    public function storeByQuery($request, $isApi = false)
    {
        $dataInsert = [
            'title' => $request->title,
            'content' => $request->contents,
            'slug' => Str::slug($request->title),
        ];

        $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'news');
        if (!empty($dataUploadFeatureImage)) {
            $dataInsert['feature_image_name'] = $dataUploadFeatureImage['file_name'];
            $dataInsert['feature_image_path'] = $dataUploadFeatureImage['file_path'];
        }

        $item = $this->create($dataInsert);

        return $this->findById($item->id);
    }

    public function updateByQuery($id, $request, $isApi = false)
    {
        try {
            DB::beginTransaction();
            $dataUpdate = [
                'title' => $request->title,
                'content' => $request->contents,
                'slug' => Str::slug($request->title),
            ];

            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');

            if (!empty($dataUploadFeatureImage)) {
                $dataUpdate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
                $dataUpdate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
            }

            $this->find($id)->update($dataUpdate);
            $item = $this->find($id);

            DB::commit();

            return $this->findById($item->id);
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . 'Line' . $exception->getLine());
            return null;
        }
    }

    public function findById($id, $isApi = false)
    {
        $item = $this->find($id);
        return $item;
    }

}
