<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        DB::table('products')->insert([
//            [
//                'name' => 'Đây là sản phẩm demo',
//                'content' => 'Đây là sản phẩm demo',
//                'feature_image_name' => 'sach',
//                'feature_image_path' => '/storage/product/1/a7IXzrthRCjgZ67Y56Si.jpg',
//                'slug' => 'day-la-san-pham-demo',
//                'price' => 100000,
//            ],
//        ]);

        app('rinvex.attributes.attribute')->create([
            'slug' => 'size',
            'type' => 'varchar',
            'name' => 'Product Size',
            'entities' => ['App\Models\Product'],
        ]);

        app('rinvex.attributes.attribute')->create([
            'slug' => 'color',
            'type' => 'varchar',
            'name' => 'Product Color',
            'entities' => ['App\Models\Product'],
        ]);

        app('rinvex.attributes.attribute')->create([
            'slug' => 'order_size',
            'type' => 'varchar',
            'name' => 'Product Size',
            'entities' => ['App\Models\OrderProduct'],
        ]);

        app('rinvex.attributes.attribute')->create([
            'slug' => 'order_color',
            'type' => 'varchar',
            'name' => 'Product Color',
            'entities' => ['App\Models\OrderProduct'],
        ]);
    }
}
