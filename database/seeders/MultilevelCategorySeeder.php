<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class MultilevelCategorySeeder extends Seeder
{
    public function run()
    {
        // Clear existing categories safely (handle foreign key constraints)
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Level 1 - Main categories
        $management = Category::create([
            'name' => 'Quản lý chất lượng',
            'slug' => 'quan-ly-chat-luong',
            'description' => 'Các tài liệu về hệ thống quản lý chất lượng ISO',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $environment = Category::create([
            'name' => 'Môi trường',
            'slug' => 'moi-truong',
            'description' => 'Các tài liệu về hệ thống quản lý môi trường',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $safety = Category::create([
            'name' => 'An toàn lao động',
            'slug' => 'an-toan-lao-dong',
            'description' => 'Các tài liệu về an toàn và sức khỏe nghề nghiệp',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        // Level 2 - Subcategories
        $iso9001 = Category::create([
            'name' => 'ISO 9001',
            'slug' => 'iso-9001',
            'description' => 'Tiêu chuẩn ISO 9001:2015',
            'parent_id' => $management->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $iso14001 = Category::create([
            'name' => 'ISO 14001',
            'slug' => 'iso-14001', 
            'description' => 'Tiêu chuẩn ISO 14001:2015',
            'parent_id' => $environment->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $iso45001 = Category::create([
            'name' => 'ISO 45001',
            'slug' => 'iso-45001',
            'description' => 'Tiêu chuẩn ISO 45001:2018',
            'parent_id' => $safety->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Level 3 - Sub-subcategories
        $procedures = Category::create([
            'name' => 'Quy trình',
            'slug' => 'quy-trinh-iso-9001',
            'description' => 'Các quy trình theo ISO 9001',
            'parent_id' => $iso9001->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $policies = Category::create([
            'name' => 'Chính sách',
            'slug' => 'chinh-sach-iso-9001',
            'description' => 'Các chính sách theo ISO 9001',
            'parent_id' => $iso9001->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $envProcedures = Category::create([
            'name' => 'Quy trình môi trường',
            'slug' => 'quy-trinh-moi-truong',
            'description' => 'Quy trình quản lý môi trường theo ISO 14001',
            'parent_id' => $iso14001->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $safetyProcedures = Category::create([
            'name' => 'Quy trình an toàn',
            'slug' => 'quy-trinh-an-toan',
            'description' => 'Quy trình an toàn lao động theo ISO 45001',
            'parent_id' => $iso45001->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        // Level 4 - Detailed subcategories
        $docControl = Category::create([
            'name' => 'Kiểm soát tài liệu',
            'slug' => 'kiem-soat-tai-lieu',
            'description' => 'Quy trình kiểm soát tài liệu và hồ sơ',
            'parent_id' => $procedures->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $internalAudit = Category::create([
            'name' => 'Kiểm toán nội bộ',
            'slug' => 'kiem-toan-noi-bo',
            'description' => 'Quy trình kiểm toán nội bộ',
            'parent_id' => $procedures->id,
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $qualityPolicy = Category::create([
            'name' => 'Chính sách chất lượng',
            'slug' => 'chinh-sach-chat-luong',
            'description' => 'Chính sách chất lượng của tổ chức',
            'parent_id' => $policies->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $wasteManagement = Category::create([
            'name' => 'Quản lý chất thải',
            'slug' => 'quan-ly-chat-thai',
            'description' => 'Quy trình quản lý chất thải',
            'parent_id' => $envProcedures->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $emergencyPrep = Category::create([
            'name' => 'Ứng phó khẩn cấp',
            'slug' => 'ung-pho-khan-cap',
            'description' => 'Quy trình ứng phó tình huống khẩn cấp',
            'parent_id' => $safetyProcedures->id,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        echo "Đã tạo thành công cây danh mục 4 cấp!\n";
        echo "- Cấp 1: 3 danh mục chính\n";
        echo "- Cấp 2: 3 danh mục con\n";
        echo "- Cấp 3: 4 danh mục con cấp 3\n";
        echo "- Cấp 4: 5 danh mục con cấp 4\n";
    }
}