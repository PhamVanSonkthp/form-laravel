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

    public function getTableName()
    {
        return Helper::getTableName($this);
    }

    public function createdBy(){
        return $this->hasOne(User::class,'id','created_by_id');
    }

    public function searchByQuery($request, $queries = [])
    {
        return Helper::searchByQuery($this, $request, $queries);
    }

    public function storeByQuery($request)
    {
        $dataInsert = [
            'user_id' => $request->id,
            'title' => $request->subject,
            'content' => $request->contents,
            'time_send' => $request->time_send,
        ];

        $item = Helper::storeByQuery($this, $request, $dataInsert);

        return $this->findById($item->id);

//        $dataCreate = [
//            'link' => $request->link,
//        ];
//
//        $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'slider');
//        if (!empty($dataUploadFeatureImage)) {
//            $dataCreate['feature_image_name'] = $dataUploadFeatureImage['file_name'];
//            $dataCreate['feature_image_path'] = $dataUploadFeatureImage['file_path'];
//        }
//        $item = $this->create($dataCreate);
//
//        return $this->findById($item->id);
    }

    public function updateByQuery($request, $id)
    {
        $dataUpdate = [
            'link' => $request->link,
        ];

        $item = Helper::updateByQuery($this, $request, $id, $dataUpdate);
        return $this->findById($item->id);

//        $dataUploadFeatureImage = $this->storageTraitUpload($request, 'feature_image_path', 'product');
//
//        if (!empty($dataUploadFeatureImage)) {
//            $updateItem['feature_image_name'] = $dataUploadFeatureImage['file_name'];
//            $updateItem['feature_image_path'] = $dataUploadFeatureImage['file_path'];
//        }
//
//        $this->find($id)->update($updateItem);
    }

    public function findById($id)
    {
        $item = $this->find($id);
        return $item;
    }
}
