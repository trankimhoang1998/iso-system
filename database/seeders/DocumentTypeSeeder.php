<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DocumentType;

class DocumentTypeSeeder extends Seeder
{
    public function run(): void
    {
        $documentTypes = [
            'BAN CHỈ ĐẠO ISO',
            'TÀI LIỆU HỆ THỐNG ISO',
            'TÀI LIỆU NỘI BỘ',
            'VĂN BẢN QUẢN LÝ'
        ];

        foreach ($documentTypes as $type) {
            DocumentType::create([
                'name' => $type
            ]);
        }
    }
}