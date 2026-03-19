<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        Project::insert([
            [
                'name' => 'Website Redesign',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Mobile App',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Internal Tools',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

