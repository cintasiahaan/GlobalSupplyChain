<?php

namespace Database\Seeders;

use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CountrySeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/countries.json');

        if (!File::exists($path)) {
            $this->command->error(
                'File database/data/countries.json tidak ditemukan.'
            );

            return;
        }

        $countries = json_decode(
            File::get($path),
            true
        );

        if (!is_array($countries)) {
            $this->command->error(
                'Format countries.json tidak valid.'
            );

            return;
        }

        $saved = 0;

        foreach ($countries as $country) {

            if (
                empty($country['name']) ||
                empty($country['code'])
            ) {
                continue;
            }

            Country::updateOrCreate(
                [
                    'code' => $country['code'],
                ],
                [
                    'name' => $country['name'],
                    'capital' => $country['capital'] ?? null,
                    'region' => $country['region'] ?? null,
                    'currency' => $country['currency'] ?? null,
                    'latitude' => $country['latitude'] ?? null,
                    'longitude' => $country['longitude'] ?? null,
                ]
            );

            $saved++;
        }

        $this->command->info(
            $saved . ' data negara berhasil diproses.'
        );
    }
}