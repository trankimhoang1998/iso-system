<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Admin user (Role 0)
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@chuongmy.gov.vn',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        // 2. Create Level 1 user - Ban ISO (Role 1)
        $banISO = User::create([
            'name' => 'Trần Thị ISO',
            'email' => 'baniso@chuongmy.gov.vn',
            'password' => Hash::make('baniso123'),
            'role' => User::ROLE_LEVEL1,
            'is_active' => true,
        ]);

        // 3. Create Level 2 user - Cơ quan - Phân xưởng (Role 2)
        $coquan = User::create([
            'name' => 'Phạm Văn Văn phòng',
            'email' => 'vanphong@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department_id' => 6, // Phòng Hành chính-Hậu cần
            'is_active' => true,
        ]);

        // 4. Create Level 3 user - Người sử dụng (Role 3)
        $user = User::create([
            'name' => 'Nguyễn Văn Nam',
            'email' => 'nvnam@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 9, // Phân xưởng 1
            'is_active' => true,
        ]);

        echo "Created 4 users successfully!\n";
        echo "- Admin (Role 0): " . User::where('role', User::ROLE_ADMIN)->count() . " user\n";
        echo "- Ban ISO (Role 1): " . User::where('role', User::ROLE_LEVEL1)->count() . " user\n";
        echo "- Cơ quan - Phân xưởng (Role 2): " . User::where('role', User::ROLE_LEVEL2)->count() . " user\n";
        echo "- Người sử dụng (Role 3): " . User::where('role', User::ROLE_LEVEL3)->count() . " user\n";
        echo "\nLogin credentials:\n";
        echo "Admin: admin@chuongmy.gov.vn / admin123\n";
        echo "Ban ISO: baniso@chuongmy.gov.vn / baniso123\n";
        echo "Cơ quan: vanphong@chuongmy.gov.vn / coquan123\n";
        echo "Người sử dụng: nvnam@chuongmy.gov.vn / user123\n";
    }
}