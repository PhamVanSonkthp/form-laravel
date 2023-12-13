<?php

namespace Database\Seeders;

use App\Models\OpportunityCategory;
use Illuminate\Database\Seeder;

class CreateOpportunityCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OpportunityCategory::firstOrCreate([
            "name" => "Bất động sản",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Xây dựng",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Công nghệ",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Bệnh viện",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Kinh doanh",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Gym - Thể thao",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Spa",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Ẩm thực",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Nội thất",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Tài chính",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Phong thủy",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Vàng bạc",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Du lịch",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Máy tính",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Dọn dẹp",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Khai thác",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Sản xuất",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Bảo hiểm",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Truyền thông",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Khác",
        ]);

        OpportunityCategory::firstOrCreate([
            "name" => "Dịch vụ",
        ]);

    }
}
