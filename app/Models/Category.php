<?php

namespace App\Models;

use App\Components\Recusive;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Category extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;
    use HasFactory;
    protected $guarded = [];

    public function getCategory($parent_id = null){
        $data = Category::all();
        $recusive = new Recusive($data);
        $htmlOption = $recusive->categoryRecusive($parent_id);

        return $htmlOption;
    }

    public function rootParent($itemCurrent = null)
    {
        if(!empty($itemCurrent)){
            $item = Category::find($itemCurrent->parent_id);
        }else{
            $item = $this;
        }


        if (empty($item)) {
            return $itemCurrent;
        }
        return $this->rootParent($item);
    }

}
