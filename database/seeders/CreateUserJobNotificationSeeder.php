<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CreateUserJobNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::firstOrCreate([
            "field" => "",
        ]);
    }
}
