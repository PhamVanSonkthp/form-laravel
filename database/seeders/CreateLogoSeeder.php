<?php

namespace Database\Seeders;

use App\Models\Logo;
use App\Models\SingpleImage;
use Illuminate\Database\Seeder;

class CreateLogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SingpleImage::create([
            'relate_id' => 1,
            'table' => 'logos',
            'image_path' => '/assets/images/original/logo.png',
            'image_name' => 'Logo',
        ]);
    }
}
