<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            'pcs',
            'box',
            'set',
        ];

        foreach ($units as $unit) {
            Unit::firstOrCreate(
                ['name' => $unit],
                ['name' => $unit]
            );
        }
    }
}
