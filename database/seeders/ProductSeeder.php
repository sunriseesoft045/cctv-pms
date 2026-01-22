<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Unit;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'SIYA CCTV 2MP Dome',
                'sku' => 'SIYA-CAM-001',
                'category' => 'CCTV Cameras',
                'unit' => 'pcs',
                'stock' => 50,
                'price' => 1200,
            ],
            [
                'name' => 'SIYA CCTV 5MP Bullet',
                'sku' => 'SIYA-CAM-002',
                'category' => 'CCTV Cameras',
                'unit' => 'pcs',
                'stock' => 40,
                'price' => 1800,
            ],
            [
                'name' => 'SIYA 4CH DVR',
                'sku' => 'SIYA-DVR-001',
                'category' => 'DVR / NVR',
                'unit' => 'box',
                'stock' => 20,
                'price' => 3500,
            ],
            [
                'name' => 'SIYA Power Adapter',
                'sku' => 'SIYA-ACC-001',
                'category' => 'Accessories',
                'unit' => 'pcs',
                'stock' => 100,
                'price' => 250,
            ],
        ];

        foreach ($products as $product) {
            $category = Category::where('name', $product['category'])->first();
            $unit = Unit::where('name', $product['unit'])->first();

            Product::firstOrCreate(
                ['sku' => $product['sku']],
                [
                    'name' => $product['name'],
                    'sku' => $product['sku'],
                    'category_id' => $category->id,
                    'unit_id' => $unit->id,
                    'stock' => $product['stock'],
                    'price' => $product['price'],
                ]
            );
        }
    }
}
