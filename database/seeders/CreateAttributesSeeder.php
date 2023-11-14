<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CreateAttributesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app('rinvex.attributes.attribute')->create([
            'slug' => 'size',
            'type' => 'varchar',
            'name' => 'Product Size',
            'entities' => ['App\Models\Product'],
        ]);

        app('rinvex.attributes.attribute')->create([
            'slug' => 'color',
            'type' => 'varchar',
            'name' => 'Product Size',
            'entities' => ['App\Models\Product'],
        ]);

    }
}
