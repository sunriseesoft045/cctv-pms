<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds - Creates default Admin
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'viveksingh12@gmail.com'],
            [
                'name' => 'vivek singh',
                'password' => Hash::make('vivek123'),
                'role' => 'admin',
                'status' => 'active',
            ]
        );
        echo "Admin User created/verified.\n";
        echo "Email: viveksingh12@gmail.com\n";
        echo "Password: vivek123\n";
    }
}