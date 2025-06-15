<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $existingAdmin = User::where('username', 'admin')->first();

        if (!$existingAdmin) {
            $admin = User::create([
                'nama' => 'ADMINISTRATOR',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('admin'),
                'role' => 'admin',
            ]);
        }
    }
}
