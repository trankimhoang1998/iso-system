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
        // Clear existing users (optional - remove if you want to keep existing data)
        User::truncate();

        // 1. Create Admin users (Role 0)
        $admin1 = User::create([
            'name' => 'Administrator',
            'email' => 'admin@chuongmy.gov.vn',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_ADMIN,
            'department' => 'Phòng Tin học',
            'parent_id' => null,
            'is_active' => true,
        ]);

        $admin2 = User::create([
            'name' => 'Nguyễn Văn Admin',
            'email' => 'admin2@chuongmy.gov.vn',
            'password' => Hash::make('admin123'),
            'role' => User::ROLE_ADMIN,
            'department' => 'Ban Chỉ đạo ISO',
            'parent_id' => null,
            'is_active' => true,
        ]);

        // 2. Create Level 1 users - Ban ISO (Role 1)
        $banISO1 = User::create([
            'name' => 'Trần Thị ISO',
            'email' => 'baniso@chuongmy.gov.vn',
            'password' => Hash::make('baniso123'),
            'role' => User::ROLE_LEVEL1,
            'department' => 'Ban Chỉ đạo ISO',
            'parent_id' => null,
            'is_active' => true,
        ]);

        $banISO2 = User::create([
            'name' => 'Lê Văn Quản lý',
            'email' => 'quanly.iso@chuongmy.gov.vn',
            'password' => Hash::make('baniso123'),
            'role' => User::ROLE_LEVEL1,
            'department' => 'Ban Chỉ đạo ISO',
            'parent_id' => null,
            'is_active' => true,
        ]);

        // 3. Create Level 2 users - Cơ quan/Phân xưởng (Role 2)
        $coquan1 = User::create([
            'name' => 'Phạm Văn Văn phòng',
            'email' => 'vanphong@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department' => 'Văn phòng UBND',
            'parent_id' => $banISO1->id,
            'is_active' => true,
        ]);

        $coquan2 = User::create([
            'name' => 'Hoàng Thị Kế toán',
            'email' => 'ketoan@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department' => 'Phòng Kế toán',
            'parent_id' => $banISO1->id,
            'is_active' => true,
        ]);

        $coquan3 = User::create([
            'name' => 'Vũ Văn Nhân sự',
            'email' => 'nhansu@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department' => 'Phòng Nhân sự',
            'parent_id' => $banISO2->id,
            'is_active' => true,
        ]);

        $coquan4 = User::create([
            'name' => 'Đỗ Thị Kỹ thuật',
            'email' => 'kythuat@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department' => 'Phòng Kỹ thuật',
            'parent_id' => $banISO2->id,
            'is_active' => true,
        ]);

        $coquan5 = User::create([
            'name' => 'Bùi Văn Sản xuất',
            'email' => 'sanxuat@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department' => 'Phân xưởng Sản xuất',
            'parent_id' => $banISO1->id,
            'is_active' => true,
        ]);

        $coquan6 = User::create([
            'name' => 'Ngô Thị Chất lượng',
            'email' => 'chatluong@chuongmy.gov.vn',
            'password' => Hash::make('coquan123'),
            'role' => User::ROLE_LEVEL2,
            'department' => 'Phòng Chất lượng',
            'parent_id' => $banISO2->id,
            'is_active' => true,
        ]);

        // 4. Create Level 3 users - Người sử dụng (Role 3)
        $nguoisudung1 = User::create([
            'name' => 'Nguyễn Văn Nam',
            'email' => 'nvnam@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Văn phòng UBND',
            'parent_id' => $coquan1->id,
            'is_active' => true,
        ]);

        $nguoisudung2 = User::create([
            'name' => 'Trần Thị Lan',
            'email' => 'ttlan@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Phòng Kế toán',
            'parent_id' => $coquan2->id,
            'is_active' => true,
        ]);

        $nguoisudung3 = User::create([
            'name' => 'Lê Văn Hùng',
            'email' => 'lvhung@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Phòng Nhân sự',
            'parent_id' => $coquan3->id,
            'is_active' => true,
        ]);

        $nguoisudung4 = User::create([
            'name' => 'Phạm Thị Mai',
            'email' => 'ptmai@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Phòng Kỹ thuật',
            'parent_id' => $coquan4->id,
            'is_active' => true,
        ]);

        $nguoisudung5 = User::create([
            'name' => 'Hoàng Văn Đức',
            'email' => 'hvduc@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Phân xưởng Sản xuất',
            'parent_id' => $coquan5->id,
            'is_active' => true,
        ]);

        $nguoisudung6 = User::create([
            'name' => 'Vũ Thị Hoa',
            'email' => 'vthoa@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Phòng Chất lượng',
            'parent_id' => $coquan6->id,
            'is_active' => true,
        ]);

        // Additional Level 3 users for testing
        $nguoisudung7 = User::create([
            'name' => 'Đặng Văn Tú',
            'email' => 'dvtu@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Văn phòng UBND',
            'parent_id' => $coquan1->id,
            'is_active' => true,
        ]);

        $nguoisudung8 = User::create([
            'name' => 'Bùi Thị Linh',
            'email' => 'btlinh@chuongmy.gov.vn',
            'password' => Hash::make('user123'),
            'role' => User::ROLE_LEVEL3,
            'department' => 'Phòng Kế toán',
            'parent_id' => $coquan2->id,
            'is_active' => false, // One inactive user for testing
        ]);

        echo "Created " . User::count() . " users successfully!\n";
        echo "- Admin: " . User::where('role', User::ROLE_ADMIN)->count() . " users\n";
        echo "- Ban ISO: " . User::where('role', User::ROLE_LEVEL1)->count() . " users\n";
        echo "- Cơ quan/Phân xưởng: " . User::where('role', User::ROLE_LEVEL2)->count() . " users\n";
        echo "- Người sử dụng: " . User::where('role', User::ROLE_LEVEL3)->count() . " users\n";
        echo "\nLogin credentials:\n";
        echo "Admin: admin@chuongmy.gov.vn / admin123\n";
        echo "Ban ISO: baniso@chuongmy.gov.vn / baniso123\n";
        echo "Cơ quan: vanphong@chuongmy.gov.vn / coquan123\n";
        echo "Người sử dụng: nvnam@chuongmy.gov.vn / user123\n";
    }
}