<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\RiskAssessment;

class RiskAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        $countries = Country::all();

        foreach ($countries as $country) {

            // Jangan menimpa data risk assessment
            // yang sudah ada
            if ($country->riskAssessment) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | NILAI RISIKO AWAL
            |--------------------------------------------------------------------------
            |
            | Nilai dibuat berdasarkan variasi data.
            | Nilai 0 - 100.
            |
            */

            $weatherRisk = rand(20, 80);

            $economicRisk = rand(20, 80);

            $currencyRisk = rand(20, 80);

            $politicalRisk = rand(20, 80);

            $portRisk = rand(20, 80);


            /*
            |--------------------------------------------------------------------------
            | HITUNG RISK SCORE
            |--------------------------------------------------------------------------
            */

            $riskScore = (

                $weatherRisk +
                $economicRisk +
                $currencyRisk +
                $politicalRisk +
                $portRisk

            ) / 5;


            /*
            |--------------------------------------------------------------------------
            | TENTUKAN RISK LEVEL
            |--------------------------------------------------------------------------
            */

            if ($riskScore < 40) {

                $riskLevel = 'Low';

            } elseif ($riskScore < 70) {

                $riskLevel = 'Medium';

            } else {

                $riskLevel = 'High';

            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN DATA
            |--------------------------------------------------------------------------
            */

            RiskAssessment::create([

                'country_id' =>
                    $country->id,

                'weather_risk' =>
                    $weatherRisk,

                'economic_risk' =>
                    $economicRisk,

                'currency_risk' =>
                    $currencyRisk,

                'political_risk' =>
                    $politicalRisk,

                'port_risk' =>
                    $portRisk,

                'risk_score' =>
                    round(
                        $riskScore,
                        2
                    ),

                'risk_level' =>
                    $riskLevel,

            ]);

        }
    }
}