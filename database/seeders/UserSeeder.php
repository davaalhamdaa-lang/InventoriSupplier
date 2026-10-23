<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // 1. Akun Admin (Butuh PIN dan Password)
        User::create([
            'name' => 'Super Admin',
            'pin' => '1234',
            'password' => Hash::make('admin123'), // Admin wajib punya password
            'role' => 'ADMIN',
            'is_active' => true,
        ]);

        // 2. Akun Operator (Hanya butuh PIN)
        User::create([
            'name' => 'Operator Gudang 1',
            'pin' => '5678',
            'password' => null, // Operator tidak butuh password
            'role' => 'OPERATOR',
            'is_active' => true,
        ]);
    }
}