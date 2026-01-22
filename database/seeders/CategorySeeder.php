<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'CCTV Cameras',
            'DVR / NVR',
            'Cables',
            'Power Supply',
            'Accessories',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                ['name' => $category]
            );
        }
    }
}
