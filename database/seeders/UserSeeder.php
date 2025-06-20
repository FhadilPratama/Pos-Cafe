<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Membuat user pertama (admin)
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password123'), // password terenkripsi
            'role' => 'admin' // Menetapkan role sebagai admin
        ]);

        // Membuat user kedua (kasir)
        User::create([
            'name' => 'Cashier User',
            'email' => 'cashier@example.com',
            'password' => Hash::make('password123'), // password terenkripsi
            'role' => 'kasir' // Menetapkan role sebagai kasir
        ]);

        // Membuat user ketiga (owner)
        User::create([
            'name' => 'Owner User',
            'email' => 'owner@example.com',
            'password' => Hash::make('password123'), // password terenkripsi
            'role' => 'owner' // Menetapkan role sebagai owner
        ]);
    }
}
