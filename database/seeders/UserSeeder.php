<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // New
use Illuminate\Support\Facades\Hash; // New

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'vishusingh12@gmail.com'],
            [
                'name' => 'vishu singh',
                'password' => Hash::make('vishu123'),
                'role' => 'user',
                'status' => 'active',
            ]
        );
        echo "Demo User created/verified.\n";
        echo "Email: vishusingh12@gmail.com\n";
        echo "Password: vishu123\n";
    }
}
