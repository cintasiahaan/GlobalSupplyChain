<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserLoginLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Buat akun User Biasa (Reguler)
        $user1 = User::firstOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'Budi Santoso (Logistics Ops)',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        $user2 = User::firstOrCreate(
            ['email' => 'sarah@gmail.com'],
            [
                'name' => 'Sarah (Supply Chain Analyst)',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 3. Seed Sampel Log Aktivitas Login (Admin & User)
        $sampleLogs = [
            [
                'user_id' => $user1->id,
                'user_name' => $user1->name,
                'email' => $user1->email,
                'role' => 'user',
                'ip_address' => '182.9.161.173',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/126.0.0.0 Safari/537.36',
                'logged_in_at' => now()->subHours(1),
            ],
            [
                'user_id' => $user2->id,
                'user_name' => $user2->name,
                'email' => $user2->email,
                'role' => 'user',
                'ip_address' => '114.122.34.89',
                'user_agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 Safari/605.1.15',
                'logged_in_at' => now()->subHours(3),
            ],
            [
                'user_id' => $admin->id,
                'user_name' => $admin->name,
                'email' => $admin->email,
                'role' => 'admin',
                'ip_address' => '182.9.161.173',
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/126.0.0.0 Safari/537.36',
                'logged_in_at' => now()->subMinutes(15),
            ],
        ];

        foreach ($sampleLogs as $logData) {
            UserLoginLog::create($logData);
        }
    }
}
