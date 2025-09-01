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
            'slug' => 'he-thong-quan-ly',
            'description' => 'Các tài liệu liên quan đến hệ thống quản lý chất lượng',
            'sort_order' => 1,
        ]);

        $procedures = Category::create([
            'name' => 'Quy trình',
            'slug' => 'quy-trinh',
            'description' => 'Các quy trình vận hành và thực hiện',
            'sort_order' => 2,
        ]);

        $policies = Category::create([
            'name' => 'Chính sách',
            'slug' => 'chinh-sach',
            'description' => 'Các chính sách và quy định của tổ chức',
            'sort_order' => 3,
        ]);

        $forms = Category::create([
            'name' => 'Biểu mẫu',
            'slug' => 'bieu-mau',
            'description' => 'Các biểu mẫu và form template',
            'sort_order' => 4,
        ]);

        $reports = Category::create([
            'name' => 'Báo cáo',
            'slug' => 'bao-cao',
            'description' => 'Các báo cáo và thống kê',
            'sort_order' => 5,
        ]);

        // Danh mục cấp 2 cho Hệ thống quản lý
        Category::create([
            'name' => 'ISO 9001',
            'slug' => 'iso-9001',
            'description' => 'Tài liệu ISO 9001 - Hệ thống quản lý chất lượng',
            'parent_id' => $management->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'ISO 14001',
            'slug' => 'iso-14001',
            'description' => 'Tài liệu ISO 14001 - Hệ thống quản lý môi trường',
            'parent_id' => $management->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'ISO 45001',
            'slug' => 'iso-45001',
            'description' => 'Tài liệu ISO 45001 - Hệ thống quản lý an toàn sức khỏe nghề nghiệp',
            'parent_id' => $management->id,
            'sort_order' => 3,
        ]);

        // Danh mục cấp 2 cho Quy trình
        Category::create([
            'name' => 'Quy trình sản xuất',
            'slug' => 'quy-trinh-san-xuat',
            'description' => 'Các quy trình liên quan đến sản xuất',
            'parent_id' => $procedures->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Quy trình kiểm tra',
            'slug' => 'quy-trinh-kiem-tra',
            'description' => 'Các quy trình kiểm tra chất lượng',
            'parent_id' => $procedures->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'Quy trình nhân sự',
            'slug' => 'quy-trinh-nhan-su',
            'description' => 'Các quy trình quản lý nhân sự',
            'parent_id' => $procedures->id,
            'sort_order' => 3,
        ]);

        // Danh mục cấp 2 cho Chính sách
        Category::create([
            'name' => 'Chính sách chất lượng',
            'slug' => 'chinh-sach-chat-luong',
            'description' => 'Các chính sách về chất lượng sản phẩm',
            'parent_id' => $policies->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Chính sách môi trường',
            'slug' => 'chinh-sach-moi-truong',
            'description' => 'Các chính sách bảo vệ môi trường',
            'parent_id' => $policies->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'Chính sách an toàn',
            'slug' => 'chinh-sach-an-toan',
            'description' => 'Các chính sách an toàn lao động',
            'parent_id' => $policies->id,
            'sort_order' => 3,
        ]);

        // Danh mục cấp 2 cho Biểu mẫu
        Category::create([
            'name' => 'Biểu mẫu kiểm tra',
            'slug' => 'bieu-mau-kiem-tra',
            'description' => 'Các biểu mẫu kiểm tra và đánh giá',
            'parent_id' => $forms->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Biểu mẫu báo cáo',
            'slug' => 'bieu-mau-bao-cao',
            'description' => 'Các biểu mẫu báo cáo định kỳ',
            'parent_id' => $forms->id,
            'sort_order' => 2,
        ]);

        // Danh mục cấp 2 cho Báo cáo
        Category::create([
            'name' => 'Báo cáo tháng',
            'slug' => 'bao-cao-thang',
            'description' => 'Báo cáo định kỳ hàng tháng',
            'parent_id' => $reports->id,
            'sort_order' => 1,
        ]);

        Category::create([
            'name' => 'Báo cáo quý',
            'slug' => 'bao-cao-quy',
            'description' => 'Báo cáo định kỳ hàng quý',
            'parent_id' => $reports->id,
            'sort_order' => 2,
        ]);

        Category::create([
            'name' => 'Báo cáo năm',
            'slug' => 'bao-cao-nam',
            'description' => 'Báo cáo định kỳ hàng năm',
            'parent_id' => $reports->id,
            'sort_order' => 3,
        ]);
    }
}