<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IsoSystemCategory;

class IsoSystemCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create parent categories first
        $parentCategories = [
            ['name' => 'SỔ TAY CHẤT LƯỢNG', 'parent_id' => null],
            ['name' => 'QUY TRÌNH HỆ THỐNG', 'parent_id' => null],
            ['name' => 'QUY TRÌNH TÁC NGHIỆP', 'parent_id' => null],
        ];

        $createdParents = [];
        
        foreach ($parentCategories as $categoryData) {
            $existingCategory = IsoSystemCategory::where('name', $categoryData['name'])->first();
            
            if (!$existingCategory) {
                $category = IsoSystemCategory::create($categoryData);
                $createdParents[$categoryData['name']] = $category->id;
                $this->command->info("Created ISO System Parent Category: {$categoryData['name']}");
            } else {
                $createdParents[$categoryData['name']] = $existingCategory->id;
                $this->command->info("ISO System Parent Category already exists: {$categoryData['name']}");
            }
        }

        // Create child categories
        $childCategories = [
            // Children of "QUY TRÌNH HỆ THỐNG"
            ['name' => 'Quy trình HT1', 'parent_id' => $createdParents['QUY TRÌNH HỆ THỐNG']],
            ['name' => 'Quy trình HT2', 'parent_id' => $createdParents['QUY TRÌNH HỆ THỐNG']],
            ['name' => 'Quy trình HT3', 'parent_id' => $createdParents['QUY TRÌNH HỆ THỐNG']],
            
            // Children of "QUY TRÌNH TÁC NGHIỆP"
            ['name' => 'Quy trình TN1', 'parent_id' => $createdParents['QUY TRÌNH TÁC NGHIỆP']],
            ['name' => 'Quy trình TN2', 'parent_id' => $createdParents['QUY TRÌNH TÁC NGHIỆP']],
            ['name' => 'Quy trình TN3', 'parent_id' => $createdParents['QUY TRÌNH TÁC NGHIỆP']],
        ];

        foreach ($childCategories as $categoryData) {
            $existingCategory = IsoSystemCategory::where('name', $categoryData['name'])->first();
            
            if (!$existingCategory) {
                IsoSystemCategory::create($categoryData);
                $this->command->info("Created ISO System Child Category: {$categoryData['name']}");
            } else {
                $this->command->info("ISO System Child Category already exists: {$categoryData['name']}");
            }
        }

        $this->command->info('ISO System Categories seeding completed!');
    }
}