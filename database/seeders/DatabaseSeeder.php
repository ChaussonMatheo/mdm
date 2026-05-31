<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->withPhone('06 62 24 19 64')->create([
            'name' => 'Yuna Le Grand',
            'password' => bcrypt('mdm'),
        ]);

        User::factory()->withPhone('06 77 16 35 19')->create([
            'name' => 'Matheo Chausson',
            'password' => bcrypt('mdm'),
        ]);
    }
}
