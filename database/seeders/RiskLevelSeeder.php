<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class RiskLevelSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::orderBy('id')->get();

        foreach ($countries as $index => $country) {

            if ($index < 12) {

                $risk = 'Low';

            } elseif ($index < 35) {

                $risk = 'Medium';

            } else {

                $risk = 'High';

            }

            $country->update([
                'risk_level' => $risk
            ]);

        }

        $this->command->info(
            $countries->count() .
            ' negara berhasil diberikan tingkat risiko.'
        );
    }
}