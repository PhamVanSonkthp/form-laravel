<?php

namespace App\Models;

use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use OwenIt\Auditing\Contracts\Auditable;

class Setting extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use DeleteModelTrait;
    use StorageImageTrait;

    protected $guarded = [];

    public function getTableName()
    {
        return Helper::getTableName($this);
    }

    public function avatar($size = "100x100")
    {
        return Helper::getDefaultIcon($this, $size);
    }

    public function image()
    {
        return Helper::image($this);
    }

    public function images()
    {
        return Helper::images($this);
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
            'point' => Formatter::formatNumberToDatabase($request->point),
            'amount' => Formatter::formatNumberToDatabase($request->amount),
            'bank_name' => $request->bank_name,
            'bank_number' => $request->bank_number,
            'bank_image' => $request->bank_image,
            'phone_contact' => $request->phone_contact,
            'about_contact' => $request->about_contact,
            'address_contact' => $request->address_contact,
            'email_contact' => $request->email_contact,
            'pusher_app_id' => $request->pusher_app_id,
            'pusher_app_key' => $request->pusher_app_key,
            'pusher_app_secret' => $request->pusher_app_secret,
            'pusher_app_cluster' => $request->pusher_app_cluster,
            'is_login_only_one_device' => $request->is_login_only_one_device ?? 0,
        ];

        $item = Helper::storeByQuery($this, $request, $dataInsert);

        return $this->findById($item->id);
    }

    public function updateByQuery($request, $id)
    {
        $dataUpdate = [
            'point' => Formatter::formatNumberToDatabase($request->point),
            'amount' => Formatter::formatNumberToDatabase($request->amount),
            'bank_name' => $request->bank_name,
            'bank_number' => $request->bank_number,
            'bank_image' => $request->bank_image,
            'phone_contact' => $request->phone_contact,
            'about_contact' => $request->about_contact,
            'address_contact' => $request->address_contact,
            'email_contact' => $request->email_contact,
            'pusher_app_id' => $request->pusher_app_id,
            'pusher_app_key' => $request->pusher_app_key,
            'pusher_app_secret' => $request->pusher_app_secret,
            'pusher_app_cluster' => $request->pusher_app_cluster,
            'is_login_only_one_device' => $request->is_login_only_one_device ?? 0,
        ];
        $item = Helper::updateByQuery($this, $request, $id, $dataUpdate);
        return $this->findById($item->id);
    }

    public function deleteByQuery($request, $id, $forceDelete = false)
    {
        return Helper::deleteByQuery($this, $request, $id, $forceDelete);
    }

    public function findById($id){
        $item = $this->find($id);
        return $item;
    }

}
