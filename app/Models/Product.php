<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $guarded = [];

    public function category(){
        return $this->hasOne(Category::class, 'id','category_id');
    }

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
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'slug' => Helper::addSlug($this,'slug', $request->title),
            'price_client' => Formatter::formatMoneyToDatabase($request->price_client),
            'price_agent' => Formatter::formatMoneyToDatabase($request->price_agen),
            'category_id' => Formatter::formatNumberToDatabase($request->category_id),
            'inventory' => Formatter::formatNumberToDatabase($request->inventory),
            'note' => $request->note,
        ];

        $item = Helper::storeByQuery($this, $request, $dataInsert);

        return $this->findById($item->id);
    }

    public function updateByQuery($request, $id)
    {
        $dataUpdate = [
            'name' => $request->name,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'slug' => Helper::addSlug($this,'slug', $request->title),
            'price_client' => Formatter::formatMoneyToDatabase($request->price_client),
            'price_agent' => Formatter::formatMoneyToDatabase($request->price_agen),
            'category_id' => Formatter::formatNumberToDatabase($request->category_id),
            'inventory' => Formatter::formatNumberToDatabase($request->inventory),
            'note' => $request->note,
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
