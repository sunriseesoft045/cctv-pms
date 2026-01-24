<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Part;

class PartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parts = [
            ['name' => 'Lens', 'sku' => 'LNS001', 'unit' => 'pcs', 'stock' => 50, 'min_stock' => 10],
            ['name' => 'Holder', 'sku' => 'HLD002', 'unit' => 'pcs', 'stock' => 100, 'min_stock' => 20],
            ['name' => 'PCB1', 'sku' => 'PCB003', 'unit' => 'pcs', 'stock' => 30, 'min_stock' => 5],
            ['name' => 'Housing', 'sku' => 'HSG004', 'unit' => 'pcs', 'stock' => 75, 'min_stock' => 15],
            ['name' => 'Wire IP', 'sku' => 'WIP005', 'unit' => 'meter', 'stock' => 200, 'min_stock' => 50],
            ['name' => 'Mic', 'sku' => 'MIC006', 'unit' => 'pcs', 'stock' => 40, 'min_stock' => 8],
        ];

        foreach ($parts as $partData) {
            Part::firstOrCreate(['sku' => $partData['sku']], $partData);
        }
    }
}
