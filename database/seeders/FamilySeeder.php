<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        // Create some sample families
        $families = [
            ['name' => 'Famille Le Grand'],
            ['name' => 'Famille Dupont'],
        ];

        foreach ($families as $familyData) {
            Family::create($familyData);
        }
    }
}
