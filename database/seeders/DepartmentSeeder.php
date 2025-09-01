<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            'Phòng Kỹ thuật',
            'Phòng Kế hoạch', 
            'Phòng KCS',
            'Phòng Tài chính',
            'Phòng Cơ điện',
            'Phòng Hành chính-Hậu cần',
            'Phòng Vật tư',
            'Ban Chính trị',
            'Phân xưởng 1',
            'Phân xưởng 2',
            'Phân xưởng 3',
            'Phân xưởng 4',
            'Phân xưởng 5',
            'Phân xưởng 6',
            'Phân xưởng 7',
            'Phân xưởng 8',
            'Phân xưởng 9',
            'Trạm O'
        ];

        foreach ($departments as $departmentName) {
            Department::create([
                'name' => $departmentName,
            ]);
        }

        echo "Đã tạo thành công " . count($departments) . " phân xưởng!\n";
    }
}