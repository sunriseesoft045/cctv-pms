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
        // Check if admin already exists
        if (User::where('email', 'admin@cctv.com')->exists()) {
            echo "Default Admin already exists.\n";
            return;
        }

        // Create Default Admin
        User::create([
            'name' => 'Default Admin',
            'email' => 'admin@cctv.com',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        echo "Default Admin created successfully!\n";
        echo "Email: admin@cctv.com\n";
        echo "Password: Admin@123\n";
    }
}