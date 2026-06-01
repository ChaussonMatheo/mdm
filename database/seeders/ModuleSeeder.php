<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Models\ModuleCategory;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'PRAGMATIQUE' => ['color' => '#FF0000',
                'modules' => [
                    'Test 1',
                    'Test 2',
                    'Test 3',
                ],
            ],
        ];

        foreach ($categories as $categoryName => $data) {
            $category = ModuleCategory::create([
                'name' => $categoryName,
                'color' => $data['color'],
            ]);

            foreach ($data['modules'] as $moduleName) {
                Module::create([
                    'name' => $moduleName,
                    'color' => null,
                    'module_category_id' => $category->id,
                ]);
            }
        }
    }
}
