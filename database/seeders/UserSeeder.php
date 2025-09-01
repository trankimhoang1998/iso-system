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
        // 1. Create Admin users (Role 0)
        $admin1 = User::create([
            'name' => 'Administrator',
            'email' => 'admin@chuongmy.gov.vn',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        $admin2 = User::create([
            'name' => 'Nguyễn Văn Admin',
            'email' => 'admin2@chuongmy.gov.vn',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_ADMIN,
            'is_active' => true,
        ]);

        // 2. Create Level 1 users - Ban ISO (Role 1)
        $banISO1 = User::create([
            'name' => 'Trần Thị ISO',
            'email' => 'baniso@chuongmy.gov.vn',
            'password' => Hash::make('baniso123'),
            'role' => User::ROLE_LEVEL1,
            'is_active' => true,
        ]);

        $banISO2 = User::create([
            'name' => 'Lê Văn Quản lý',
            'email' => 'quanly.iso@chuongmy.gov.vn',
            'password' => Hash::make('baniso123'),
            'role' => User::ROLE_LEVEL1,
            'is_active' => true,
        ]);

        // 3. Create Level 2 users - Cơ quan - Phân xưởng (Role 2)
        $coquan1 = User::create([
            'name' => 'Phạm Văn Văn phòng',
            'email' => 'vanphong@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department_id' => 6, // Phòng Hành chính-Hậu cần
            'is_active' => true,
        ]);

        $coquan2 = User::create([
            'name' => 'Nguyễn Thị Kỹ thuật',
            'email' => 'kythuat@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department_id' => 1, // Phòng Kỹ thuật
            'is_active' => true,
        ]);

        $coquan3 = User::create([
            'name' => 'Lê Minh Tài chính',
            'email' => 'taichinh@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department_id' => 4, // Phòng Tài chính
            'is_active' => true,
        ]);

        $coquan4 = User::create([
            'name' => 'Hoàng Văn Hành chính',
            'email' => 'hanhchinh@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department_id' => 6, // Phòng Hành chính-Hậu cần
            'is_active' => true,
        ]);

        $coquan5 = User::create([
            'name' => 'Trần Văn Kế hoạch',
            'email' => 'kehoach@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department_id' => 2, // Phòng Kế hoạch
            'is_active' => true,
        ]);

        $coquan6 = User::create([
            'name' => 'Võ Thị Chất lượng',
            'email' => 'chatluong@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department_id' => 3, // Phòng KCS
            'is_active' => true,
        ]);

        // 4. Create Level 3 users - Người sử dụng (Role 3)
        $user1 = User::create([
            'name' => 'Nguyễn Văn Nam',
            'email' => 'nvnam@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 9, // Phân xưởng 1
            'is_active' => true,
        ]);

        $user2 = User::create([
            'name' => 'Trần Thị Hoa',
            'email' => 'tthoa@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 10, // Phân xưởng 2
            'is_active' => true,
        ]);

        $user3 = User::create([
            'name' => 'Lê Văn Minh',
            'email' => 'lvminh@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 11, // Phân xưởng 3
            'is_active' => true,
        ]);

        $user4 = User::create([
            'name' => 'Phạm Thị Lan',
            'email' => 'ptlan@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 12, // Phân xưởng 4
            'is_active' => true,
        ]);

        $user5 = User::create([
            'name' => 'Vũ Văn Đức',
            'email' => 'vvduc@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 13, // Phân xưởng 5
            'is_active' => true,
        ]);

        $user6 = User::create([
            'name' => 'Đỗ Thị Mai',
            'email' => 'dtmai@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 14, // Phân xưởng 6
            'is_active' => true,
        ]);

        $user7 = User::create([
            'name' => 'Bùi Văn Tùng',
            'email' => 'bvtung@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 15, // Phân xưởng 7
            'is_active' => true,
        ]);

        $user8 = User::create([
            'name' => 'Ngô Thị Hương',
            'email' => 'nthuong@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department_id' => 16, // Phân xưởng 8
            'is_active' => false, // One inactive user for testing
        ]);

        echo "Created " . User::count() . " users successfully!\n";
        echo "- Admin: " . User::where('role', User::ROLE_ADMIN)->count() . " users\n";
        echo "- Ban ISO: " . User::where('role', User::ROLE_LEVEL1)->count() . " users\n";
        echo "- Cơ quan - Phân xưởng: " . User::where('role', User::ROLE_LEVEL2)->count() . " users\n";
        echo "- Người sử dụng: " . User::where('role', User::ROLE_LEVEL3)->count() . " users\n";
        echo "\nLogin credentials:\n";
        echo "Admin: admin@chuongmy.gov.vn / admin123\n";
        echo "Ban ISO: baniso@chuongmy.gov.vn / baniso123\n";
        echo "Cơ quan: vanphong@chuongmy.gov.vn / coquan123\n";
        echo "Người sử dụng: nvnam@chuongmy.gov.vn / user123\n";
    }
}