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
        User::firstOrCreate(
            ['email' => 'masteradmin123@gmail.com'],
            [
                'name' => 'Master Admin',
                'password' => Hash::make('masteradmin123'),
                'role' => 'master_admin',
                'status' => 'active',
            ]
        );
        echo "Master Admin created/verified.\n";
        echo "Email: masteradmin123@gmail.com\n";
        echo "Password: masteradmin123\n";
    }
}
