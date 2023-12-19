<?php

namespace App\Models;

use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Maatwebsite\Excel\Facades\Excel;
use OwenIt\Auditing\Contracts\Auditable;

class Opportunity extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use DeleteModelTrait;
    use StorageImageTrait;

    protected $guarded = [];

    // begin

    public function opportunityUsers(){
        return $this->hasMany(OpportunityUser::class,'opportunity_id','id');
    }

    public function user(){
        return $this->hasOne(User::class,'id','user_id');
    }

    public function status(){
        return $this->hasOne(OpportunityStatus::class,'id','opportunity_status_id');
    }

    public function category(){
        return $this->hasOne(OpportunityCategory::class,'id','opportunity_category_id');
    }

    public function takenUser(){
        return $this->hasOne(User::class,'id','taken_user_id');
    }

    // end

    public function getTableName()
    {
        return Helper::getTableName($this);
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['status'] = $this->status;
        $array['category'] = $this->category;
        $array['user'] = $this->user;
        $array['taken_user'] = $this->takenUser;
        $array['opportunity_users'] = $this->opportunityUsers;
        $array['image_path_avatar'] = $this->avatar();
        $array['path_images'] = $this->images;
        return $array;
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

    public function searchByQuery($request, $queries = [], $randomRecord = null, $makeHiddens = null, $isCustom = false)
    {
        return Helper::searchByQuery($this, $request, $queries, $randomRecord, $makeHiddens, $isCustom);
    }

    public function storeByQuery($request)
    {
        $dataInsert = [
            'name' => $request->name,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'content' => $request->content,
            'opportunity_status_id' => $request->opportunity_status_id,
            'opportunity_category_id' => $request->opportunity_category_id,
            'user_id' => $request->user_id,
            'discount' => $request->discount ?? 0,
            'taken_user_id' => $request->taken_user_id ?? 0,
            'cost' => Formatter::formatNumberToDatabase($request->cost),
        ];

        $item = Helper::storeByQuery($this, $request, $dataInsert);

        return $this->findById($item->id);
    }

    public function updateByQuery($request, $id)
    {
        $dataUpdate = [
            'name' => $request->name,
            'client_name' => $request->client_name,
            'client_phone' => $request->client_phone,
            'content' => $request->content,
            'opportunity_status_id' => $request->opportunity_status_id,
            'opportunity_category_id' => $request->opportunity_category_id,
            'user_id' => $request->user_id,
            'discount' => $request->discount ?? 0,
            'taken_user_id' => $request->taken_user_id ?? 0,
            'cost' => Formatter::formatNumberToDatabase($request->cost),
        ];
        $item = Helper::updateByQuery($this, $request, $id, $dataUpdate);
        return $this->findById($item->id);
    }

    public function deleteByQuery($request, $id, $forceDelete = false)
    {
        return Helper::deleteByQuery($this, $request, $id, $forceDelete);
    }

    public function deleteManyByIds($request, $forceDelete = false)
    {
        return Helper::deleteManyByIds($this, $request, $forceDelete);
    }

    public function findById($id){
        $item = $this->find($id);
        return $item;
    }

}
