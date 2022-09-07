<?php

namespace App\Models;

use App\Traits\StorageImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;

class Slider extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use StorageImageTrait;

    protected $guarded = [];

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
            }else if ($key == "start") {
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
        $dataCreate = [
            'link' => $request->link,
        ];

        $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'slider');
        if (!empty($dataUploadFeatureImage)) {
            $dataCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
            $dataCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
        }
        $item = $this->create($dataCreate);

        return $this->findById($item->id);
    }

    public function updateByQuery($id, $request, $isApi = false)
    {
        $updateItem = [
            'link' => $request->link,
        ];

        $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');

        if (!empty($dataUploadFeatureImage)) {
            $updateItem['feature_image_name'] = $dataUploadFeatureImage['file_name'];
            $updateItem['feature_image_path'] = $dataUploadFeatureImage['file_path'];
        }

        $this->find($id)->update($updateItem);
    }

    public function findById($id, $isApi = false)
    {
        $item = $this->find($id);
        $item->gender;
        $item->role;
        return $item;
    }
}
