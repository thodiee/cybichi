<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@cybichi.com'],
            [
                'name' => 'Founder CYBICHI',
                'password' => Hash::make('admin123'),
                'role' => 'superadmin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'editor@cybichi.com'],
            [
                'name' => 'Sales & Operations Lead',
                'password' => Hash::make('admin123'),
                'role' => 'editor',
                'is_active' => true,
                'email_verified_at' => now(),
            ]
        );
    }
}
