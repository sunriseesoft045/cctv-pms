<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class MasterAdminSeeder extends Seeder
{
    /**
     * Run the database seeds - Creates Master Admin
     */
    public function run(): void
    {
        // Check if master admin already exists
        if (User::where('email', 'masteradmin123@gmail.com')->exists()) {
            echo "Master Admin already exists.\n";
            return;
        }

        // Create Master Admin
        User::create([
            'name' => 'Master Admin',
            'email' => 'masteradmin123@gmail.com',
            'password' => Hash::make('masteradmin123'),
            'role' => 'master_admin',
            'status' => 'active',
        ]);

        echo "Master Admin created successfully!\n";
        echo "Email: masteradmin123@gmail.com\n";
        echo "Password: masteradmin123\n";
    }
}
