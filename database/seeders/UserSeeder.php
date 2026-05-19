<?php

namespace Database\Seeders;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'fio' => 'Admin',
            'email' => 'admin@example.com',
            'login' => "Admin",
            'phone' => '+71234567890',
            'password' => bcrypt('KorokNET'),
            'role' => UserRole::Admin,
        ]);

        User::create([
            'fio' => 'User',
            'email' => 'user@example.com',
            'phone' => '+70987654321',
            'password' => bcrypt('password'),
            'role' => UserRole::User,
        ]);
    }
}
