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

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    public function typeSales(){
        $typeSales = TypeSale::all();

        $priceSales = [];
        foreach ($typeSales as $item){
            $priceSales[] = [
                'name' => $item->name,
                'price' => (($item->price_per * $this->price) / 100) + $this->price,
            ];
        }

        return $priceSales;
    }

    public function retailPrice(){
        $typeSale = TypeSale::first();

        return ceil((($typeSale->price_per * $this->price) / 100) + $this->price);
    }

    public function brach(){
        return $this->hasOne(Brach::class, 'id','brach_id');
    }

    public function category(){
        return $this->hasOne(Category::class, 'id','category_id');
    }

    public function sold(){
        return Cart::select('carts.*')->where('product_id', $this->id)->join('invoices', 'invoices.id', '=', 'carts.invoice_id')->where('invoices.invoice_status_id' , 3)->sum('number');
    }
}
