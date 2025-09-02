<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IsoDirectiveCategory;

class IsoDirectiveCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'BAN HÀNH HỆ THỐNG TÀI LIỆU', 'parent_id' => null],
            ['name' => 'CÔNG BỐ HTQLCL PHÙ HỢP TIÊU CHUẨN ISO', 'parent_id' => null],
            ['name' => 'THÀNH LẬP BAN CHỈ ĐẠO ISO', 'parent_id' => null],
            ['name' => 'CHÍNH SÁCH CHẤT LƯỢNG VÀ MỤC TIÊU CHẤT LƯỢNG', 'parent_id' => null],
            ['name' => 'KIỂM SOÁT THÔNG TIN DẠNG VĂN BẢN', 'parent_id' => null],
            ['name' => 'ĐÁNH GIÁ NỘI BỘ', 'parent_id' => null],
            ['name' => 'XEM XÉT LÃNH ĐẠO', 'parent_id' => null],
            ['name' => 'KIỂM SOÁT SỰ KHÔNG PHÙ HỢP-HÀNH ĐỘNG KHẮC PHỤC', 'parent_id' => null],
            ['name' => 'QUẢN LÝ RỦI RO VÀ CƠ HỘI', 'parent_id' => null],
            ['name' => 'KHIẾU NẠI VÀ ĐO LƯỜNG SỰ THỎA MÃN CỦA KHÁCH HÀNG', 'parent_id' => null],
        ];

        foreach ($categories as $categoryData) {
            // Check if category already exists
            $existingCategory = IsoDirectiveCategory::where('name', $categoryData['name'])->first();
            
            if (!$existingCategory) {
                IsoDirectiveCategory::create($categoryData);
                $this->command->info("Created ISO Directive Category: {$categoryData['name']}");
            } else {
                $this->command->info("ISO Directive Category already exists: {$categoryData['name']}");
            }
        }

        $this->command->info('ISO Directive Categories seeding completed!');
    }
}