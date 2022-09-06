<?php

namespace Database\Seeders;

use App\Models\Logo;
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
        Logo::firstOrCreate([
            "image_path" => "/storage/logo/1/Unv0vG9gtrDfgTCuahHL.jpg",
            "image_name" => "kisspng-epic-arena-game-logo-clip-art-boxing-graphics-5aaf7a1eb8a263.8849431615214495027563.jpg",
        ]);
    }
}
