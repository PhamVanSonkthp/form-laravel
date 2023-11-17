<?php

namespace Database\Seeders;

use App\Models\Formatter;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::firstOrCreate([
            'point' => 1,
            'amount' => 1,
            'bank_name' => "Vietcombank",
            'bank_number' => "0031000332320",
            'phone_contact' => "0378115213",
            'about_contact' => "Phùng Kế Thế",
            'address_contact' => "Hà Nội",
            'email_contact' => "ifnt@gmail.com",
        ]);
    }
}
