<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@praktikum.com'],
            [
                'name'     => 'Admin Praktikum',
                'email'    => 'admin@praktikum.com',
                'password' => Hash::make('praktikumBASDAT2026'),
            ]
        );
    }
}