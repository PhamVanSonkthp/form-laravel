<?php

namespace Database\Seeders;

use App\Models\OpportunityStatus;
use Illuminate\Database\Seeder;

class CreateOpportunityStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpportunityStatus::firstOrCreate([
            "name" => "Chưa thành hợp đồng",
        ]);

        OpportunityStatus::firstOrCreate([
            "name" => "Đã thành hợp đồng",
        ]);
    }
}
