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
            [
                'name' => 'BAN HÀNH HỆ THỐNG TÀI LIỆU', 
                'description' => 'Quản lý các quyết định ban hành tài liệu thuộc Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015 của Nhà máy A31',
                'parent_id' => null
            ],
            [
                'name' => 'CÔNG BỐ HTQLCL PHÙ HỢP TIÊU CHUẨN ISO', 
                'description' => 'Quản lý các quyết định công bố Hệ thống quản lý chất lượng của Nhà máy A31 phù hợp tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
            [
                'name' => 'THÀNH LẬP BAN CHỈ ĐẠO ISO', 
                'description' => 'Quản lý các quyết định thành lập Ban Chỉ đạo Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015 (gọi tắt là Ban Chỉ đạo ISO)',
                'parent_id' => null
            ],
            [
                'name' => 'CHÍNH SÁCH CHẤT LƯỢNG VÀ MỤC TIÊU CHẤT LƯỢNG', 
                'description' => 'Quản lý các Chính sách chất lượng, Mục tiêu chất lượng của Nhà máy A31 theo Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
            [
                'name' => 'KIỂM SOÁT THÔNG TIN DẠNG VĂN BẢN', 
                'description' => 'Quản lý Hồ sơ thực hiện Quy trình kiểm soát thông tin dạng văn bản thuộc Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
            [
                'name' => 'ĐÁNH GIÁ NỘI BỘ', 
                'description' => 'Quản lý Hồ sơ thực hiện Quy trình Đánh giá nội bộ thuộc Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
            [
                'name' => 'XEM XÉT LÃNH ĐẠO', 
                'description' => 'Quản lý Hồ sơ thực hiện Quy trình Xem xét của lãnh đạo thuộc Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
            [
                'name' => 'KIỂM SOÁT SỰ KHÔNG PHÙ HỢP-HÀNH ĐỘNG KHẮC PHỤC', 
                'description' => 'Quản lý Hồ sơ thực hiện Quy trình Quản lý rủi ro và cơ hội thuộc Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
            [
                'name' => 'QUẢN LÝ RỦI RO VÀ CƠ HỘI', 
                'description' => 'Quản lý Hồ sơ thực hiện Quy trình Khiếu nại và đo lường sự thỏa mãn của khách hàng thuộc Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
            [
                'name' => 'KHIẾU NẠI VÀ ĐO LƯỜNG SỰ THỎA MÃN CỦA KHÁCH HÀNG', 
                'description' => 'Quản lý Hồ sơ thực hiện Quy trình Khiếu nại và đo lường sự thỏa mãn của khách hàng thuộc Hệ thống quản lý chất lượng theo tiêu chuẩn quốc gia TCVN ISO 9001:2015',
                'parent_id' => null
            ],
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