<?php

namespace App\Models;

use App\Traits\DeleteModelTrait;
use App\Traits\StorageImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Rinvex\Attributes\Traits\Attributable;

class Product extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    use DeleteModelTrait;
    use StorageImageTrait;
    use Attributable;

    protected $guarded = [];

//    protected $with = ['eav'];

    // begin

    public function star(){
        return 4.5;
    }

    public function toArray()
    {
        $array = parent::toArray();
        $array['star'] = $this->star();
        $array['category'] = $this->category;
        $array['price'] = $this->priceSale();
        return $array;
    }

    public function productsAttributes(){
        return $this->hasMany(Product::class,'group_product_id','group_product_id');
    }

    public function isEmptyInventory(){
        return $this->inventory <= 0;
    }

    public function priceSale(){

        $productsAttributes = $this->productsAttributes;

        $priceMinAgent = PHP_INT_MAX;
        $priceMinClient = PHP_INT_MAX;
        $priceMaxAgent = PHP_INT_MIN;
        $priceMaxClient = PHP_INT_MIN;

        $resultAgent = "Liên hệ";
        $resultClient = "Liên hệ";

        foreach ($productsAttributes as $item){
            if (!$item->isEmptyInventory()){
                if ($item->price_client <= $priceMinClient) $priceMinClient = $item->price_client;
                if ($item->price_client >= $priceMaxClient) $priceMaxClient = $item->price_client;
                if ($item->price_agent <= $priceMinAgent) $priceMinAgent = $item->price_agent;
                if ($item->price_agent >= $priceMaxAgent) $priceMaxAgent = $item->price_agent;
            }
        }

        if (!empty($priceMinAgent)){
            if ($priceMinAgent != $priceMaxAgent){
                $resultAgent = $priceMinAgent . " ~ " . $priceMaxAgent;
            }else{
                $resultAgent = $priceMinAgent;
            }
        }

        if (!empty($priceMinClient)){
            if ($priceMinClient != $priceMaxClient){
                $resultClient = $priceMinClient . " ~ " . $priceMaxClient;
            }else{
                $resultClient = $priceMinClient;
            }
        }

        if (auth('sanctum')->check() && auth('sanctum')->user()->user_type_id == 2){
            return $resultAgent . "";
        } else {
            return $resultClient . "";
        }
    }

    public function attributes()
    {
        $products = $this->where('group_product_id', $this->group_product_id)->get();

        $results = [];

        foreach ($products as $item){
            $temp = [];
            $temp['id'] = $item->id;
            $temp['size'] = $item->sizes;
            $temp['color'] = $item->colors;
            $temp['inventory'] = $item->inventory;

            $results[] = $temp;
        }

        return $results;
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    function firstOrCreateCategory($category_id){
        if (!empty($category_id) && !is_numeric($category_id)){
            $category = Category::firstOrCreate([
                'name' => $category_id,
            ],[
                'name' => $category_id,
                'slug' => Helper::addSlug($this,'slug', $category_id),
            ]);

            return $category->id;
        }

        return $category_id ?? 0;
    }

    // end

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
            'price_import' => Formatter::formatMoneyToDatabase($request->price_import),
            'price_client' => Formatter::formatMoneyToDatabase($request->price_client),
            'price_agent' => Formatter::formatMoneyToDatabase($request->price_agent),
            'category_id' => $this->firstOrCreateCategory($request->category_id),
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
            'price_import' => Formatter::formatMoneyToDatabase($request->price_import),
            'price_client' => Formatter::formatMoneyToDatabase($request->price_client),
            'price_agent' => Formatter::formatMoneyToDatabase($request->price_agent),
            'category_id' => $this->firstOrCreateCategory($request->category_id),
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
