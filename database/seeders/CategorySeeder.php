<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\DocumentType;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Get document types
        $documentTypes = DocumentType::all()->keyBy('name');

        // Sample categories for each document type
        $categories = [
            'BAN CHỈ ĐẠO ISO' => [
                'Quyết định Ban hành Hệ thống Tài liệu',
                'Hồ sơ Công bố HTQLCL phù hợp Tiêu chuẩn ISO',
                'Quyết định Thành lập BCD ISO'
            ],
            'TÀI LIỆU HỆ THỐNG ISO' => [
                'Sổ tay Chất lượng',
                'Quy trình Hoạt động',
                'Hướng dẫn Kỹ thuật'
            ],
            'TÀI LIỆU NỘI BỘ' => [
                'Biểu mẫu Nội bộ',
                'Báo cáo Nội bộ',
                'Hướng dẫn Nội bộ'
            ],
            'VĂN BẢN QUẢN LÝ' => [
                'Thông tư Hướng dẫn',
                'Quy định Quản lý',
                'Báo cáo Định kỳ'
            ]
        ];

        foreach ($categories as $typeName => $categoryNames) {
            $documentType = $documentTypes[$typeName];
            
            foreach ($categoryNames as $index => $categoryName) {
                Category::create([
                    'name' => $categoryName,
                    'document_type_id' => $documentType->id,
                ]);
            }
        }
    }
}