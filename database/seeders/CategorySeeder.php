<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Danh mục cấp 1
        $management = Category::create([
            'name' => 'Hệ thống quản lý',
            'description' => 'Các tài liệu liên quan đến hệ thống quản lý chất lượng',
            'sort_order' => 1,
        ]);

        $procedures = Category::create([
            'name' => 'Quy trình',
            'description' => 'Các quy trình vận hành và thực hiện',
            'sort_order' => 2,
        ]);

        $policies = Category::create([
            'name' => 'Chính sách',
            'description' => 'Các chính sách và quy định của tổ chức',
            'sort_order' => 3,
        ]);

        $forms = Category::create([
            'name' => 'Biểu mẫu',
            'description' => 'Các biểu mẫu và form template',
            'sort_order' => 4,
        ]);

        $reports = Category::create([
            'name' => 'Báo cáo',
            'description' => 'Các báo cáo và thống kê',
            'sort_order' => 5,
        ]);

        // Danh mục cấp 2 cho Hệ thống quản lý
        Category::create([
            'name' => 'ISO 9001',
            'description' => 'Tài liệu ISO 9001 - Hệ thống quản lý chất lượng',
            'parent_id' => $management->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'ISO 14001',
            'description' => 'Tài liệu ISO 14001 - Hệ thống quản lý môi trường',
            'parent_id' => $management->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'ISO 45001',
            'description' => 'Tài liệu ISO 45001 - Hệ thống quản lý an toàn sức khỏe nghề nghiệp',
            'parent_id' => $management->id,
            'sort_order' => 3,
        ]);

        // Danh mục cấp 2 cho Quy trình
        Category::create([
            'name' => 'Quy trình sản xuất',
            'description' => 'Các quy trình liên quan đến sản xuất',
            'parent_id' => $procedures->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Quy trình kiểm tra',
            'description' => 'Các quy trình kiểm tra chất lượng',
            'parent_id' => $procedures->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'Quy trình nhân sự',
            'description' => 'Các quy trình quản lý nhân sự',
            'parent_id' => $procedures->id,
            'sort_order' => 3,
        ]);

        // Danh mục cấp 2 cho Chính sách
        Category::create([
            'name' => 'Chính sách chất lượng',
            'description' => 'Các chính sách về chất lượng sản phẩm',
            'parent_id' => $policies->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Chính sách môi trường',
            'description' => 'Các chính sách bảo vệ môi trường',
            'parent_id' => $policies->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'Chính sách an toàn',
            'description' => 'Các chính sách an toàn lao động',
            'parent_id' => $policies->id,
            'sort_order' => 3,
        ]);

        // Danh mục cấp 2 cho Biểu mẫu
        Category::create([
            'name' => 'Biểu mẫu kiểm tra',
            'description' => 'Các biểu mẫu kiểm tra và đánh giá',
            'parent_id' => $forms->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Biểu mẫu báo cáo',
            'description' => 'Các biểu mẫu báo cáo định kỳ',
            'parent_id' => $forms->id,
            'sort_order' => 2,
        ]);

        // Danh mục cấp 2 cho Báo cáo
        Category::create([
            'name' => 'Báo cáo tháng',
            'description' => 'Báo cáo định kỳ hàng tháng',
            'parent_id' => $reports->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Báo cáo quý',
            'description' => 'Báo cáo định kỳ hàng quý',
            'parent_id' => $reports->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'Báo cáo năm',
            'description' => 'Báo cáo định kỳ hàng năm',
            'parent_id' => $reports->id,
            'sort_order' => 3,
        ]);
    }
}