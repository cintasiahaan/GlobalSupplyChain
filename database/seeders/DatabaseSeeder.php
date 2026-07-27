<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Weather;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@gmail.com'],
            [
                'name' => 'User',
                'password' => Hash::make('user123'),
                'role' => 'user',
            ]
        );

        $this->call([
            CountrySeeder::class,
            RiskLevelSeeder::class,
            RiskAssessmentSeeder::class,
            NewsSeeder::class,
            PortSeeder::class,
        ]);

        if (Weather::count() === 0) {

            $sampleWeather = [
                [
                    'country' => 'Indonesia',
                    'city' => 'Jakarta',
                    'temperature' => 30.5,
                    'humidity' => 78,
                    'wind_speed' => 12.4,
                    'precipitation' => 2.5,
                    'condition' => 'Partly Cloudy',
                ],
                [
                    'country' => 'Singapore',
                    'city' => 'Singapore',
                    'temperature' => 31.2,
                    'humidity' => 82,
                    'wind_speed' => 10.8,
                    'precipitation' => 4.2,
                    'condition' => 'Rainy',
                ],
                [
                    'country' => 'Japan',
                    'city' => 'Tokyo',
                    'temperature' => 26.8,
                    'humidity' => 65,
                    'wind_speed' => 8.5,
                    'precipitation' => 0.0,
                    'condition' => 'Sunny',
                ],
                [
                    'country' => 'United States',
                    'city' => 'New York',
                    'temperature' => 24.6,
                    'humidity' => 60,
                    'wind_speed' => 14.2,
                    'precipitation' => 1.2,
                    'condition' => 'Cloudy',
                ],
                [
                    'country' => 'Germany',
                    'city' => 'Berlin',
                    'temperature' => 20.4,
                    'humidity' => 58,
                    'wind_speed' => 11.3,
                    'precipitation' => 0.5,
                    'condition' => 'Clear',
                ],
            ];

            foreach ($sampleWeather as $weather) {
                Weather::create($weather + ['recorded_at' => now()]);
            }

        }
    }
}
