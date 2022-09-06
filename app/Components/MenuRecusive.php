<?php

namespace App\Components;

use App\Models\Menu;

class MenuRecusive
{
    private $html;

    public function __construct()
    {
        $this->html = '';
    }

    public function menuRecusiveAdd($parent_id_menu_edit = null, $parent_id = 0, $sub_mark = '')
    {
        $data = Menu::where('parent_id' , $parent_id)->get();
        foreach ($data as $data_item){
            if($parent_id_menu_edit == $data_item->id){
                $this->html .= '<option selected value="'.$data_item->id.'">'. $sub_mark .$data_item->name.'</option>';
            }else{
                $this->html .= '<option value="'.$data_item->id.'">'. $sub_mark .$data_item->name.'</option>';
            }

            $this->menuRecusiveAdd($parent_id_menu_edit ,$data_item->id , $sub_mark . '--');
        }

        return $this->html;
    }
}

