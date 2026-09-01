<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@bumil.id'],
            [
                'name' => 'Admin Bank Sampah',
                'email' => 'admin@bumil.id',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
