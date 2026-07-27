<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\CurrencyImpact;
use Illuminate\Support\Facades\Http;

class CurrencyImpactController extends Controller
{
    /**
     * Daftar kode mata uang berdasarkan nama negara.
     */
    private function currencyMap(): array
    {
        return [
            'Afghanistan' => 'AFN',
            'Albania' => 'ALL',
            'Algeria' => 'DZD',
            'Argentina' => 'ARS',
            'Australia' => 'AUD',
            'Austria' => 'EUR',
            'Belgium' => 'EUR',
            'Brazil' => 'BRL',
            'Canada' => 'CAD',
            'Chile' => 'CLP',
            'China' => 'CNY',
            'Colombia' => 'COP',
            'Croatia' => 'EUR',
            'Czech Republic' => 'CZK',
            'Denmark' => 'DKK',
            'Egypt' => 'EGP',
            'Finland' => 'EUR',
            'France' => 'EUR',
            'Germany' => 'EUR',
            'Greece' => 'EUR',
            'Hong Kong' => 'HKD',
            'Hungary' => 'HUF',
            'Iceland' => 'ISK',
            'India' => 'INR',
            'Indonesia' => 'IDR',
            'Ireland' => 'EUR',
            'Israel' => 'ILS',
            'Italy' => 'EUR',
            'Japan' => 'JPY',
            'Malaysia' => 'MYR',
            'Mexico' => 'MXN',
            'Netherlands' => 'EUR',
            'New Zealand' => 'NZD',
            'Nigeria' => 'NGN',
            'Norway' => 'NOK',
            'Pakistan' => 'PKR',
            'Peru' => 'PEN',
            'Philippines' => 'PHP',
            'Poland' => 'PLN',
            'Portugal' => 'EUR',
            'Romania' => 'RON',
            'Russia' => 'RUB',
            'Saudi Arabia' => 'SAR',
            'Singapore' => 'SGD',
            'South Africa' => 'ZAR',
            'South Korea' => 'KRW',
            'Spain' => 'EUR',
            'Sweden' => 'SEK',
            'Switzerland' => 'CHF',
            'Taiwan' => 'TWD',
            'Thailand' => 'THB',
            'Turkey' => 'TRY',
            'Ukraine' => 'UAH',
            'United Arab Emirates' => 'AED',
            'United Kingdom' => 'GBP',
            'United States' => 'USD',
            'Vietnam' => 'VND',
        ];
    }


    /**
     * Halaman utama Currency Impact.
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view(
            'currency-impact.index',
            compact('countries')
        );
    }


    /**
     * Detail Currency Impact sebuah negara.
     */
    public function show(Country $country)
    {
        $currencyMap = $this->currencyMap();

        $currencyCode =
            $currencyMap[$country->name] ?? null;

        $exchangeRate = null;
        $previousRate = null;
        $changePercent = null;

        $currencyRisk = 'UNKNOWN';
        $riskClass = 'risk-unknown';

        $impact = null;
        $recommendation = null;

        $currencyError = null;

        /*
        |--------------------------------------------------------------------------
        | AMBIL HISTORI SEBELUMNYA
        |--------------------------------------------------------------------------
        */

        $previousRecord = CurrencyImpact::where(
            'country_id',
            $country->id
        )
        ->orderByDesc('recorded_at')
        ->orderByDesc('id')
        ->first();

        if ($previousRecord) {
            $previousRate =
                (float) $previousRecord->exchange_rate;
        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA API
        |--------------------------------------------------------------------------
        */

        if (!$currencyCode) {

            $currencyError =
                'Kode mata uang untuk negara '
                . $country->name
                . ' belum tersedia.';

        } else {

            try {

                /*
                |--------------------------------------------------------------------------
                | API EXCHANGE RATE
                |--------------------------------------------------------------------------
                */

                $response = Http::timeout(15)
                    ->acceptJson()
                    ->get(
                        'https://open.er-api.com/v6/latest/'
                        . $currencyCode
                    );


                if (
                    $response->successful()
                    &&
                    $response->json('result') === 'success'
                ) {

                    $exchangeRate =
                        $response->json(
                            'rates.IDR'
                        );


                    if ($exchangeRate === null) {

                        $currencyError =
                            'Nilai tukar '
                            . $currencyCode
                            . ' terhadap IDR '
                            . 'tidak tersedia dari API.';

                    } else {

                        $exchangeRate =
                            (float) $exchangeRate;


                        /*
                        |--------------------------------------------------------------------------
                        | HITUNG PERUBAHAN
                        |--------------------------------------------------------------------------
                        */

                        if (
                            $previousRate !== null
                            &&
                            $previousRate > 0
                        ) {

                            $changePercent =
                                (
                                    (
                                        $exchangeRate
                                        -
                                        $previousRate
                                    )
                                    /
                                    $previousRate
                                )
                                * 100;

                        } else {

                            $changePercent = 0;

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | TENTUKAN RISIKO
                        |--------------------------------------------------------------------------
                        */

                        $absoluteChange =
                            abs($changePercent);


                        if ($absoluteChange >= 5) {

                            $currencyRisk = 'HIGH';
                            $riskClass = 'risk-high';

                        } elseif ($absoluteChange >= 2) {

                            $currencyRisk = 'MEDIUM';
                            $riskClass = 'risk-medium';

                        } else {

                            $currencyRisk = 'LOW';
                            $riskClass = 'risk-low';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | DAMPAK SUPPLY CHAIN
                        |--------------------------------------------------------------------------
                        */

                        if ($currencyRisk === 'HIGH') {

                            $impact =
                                'Perubahan nilai tukar yang tinggi '
                                . 'dapat meningkatkan biaya impor, '
                                . 'harga bahan baku, biaya logistik, '
                                . 'dan biaya operasional rantai pasok '
                                . 'internasional.';

                            $recommendation =
                                'Lakukan monitoring nilai tukar secara '
                                . 'intensif dan evaluasi kontrak dengan '
                                . 'pemasok internasional. Pertimbangkan '
                                . 'strategi mitigasi risiko valuta asing.';

                        } elseif ($currencyRisk === 'MEDIUM') {

                            $impact =
                                'Perubahan nilai tukar sedang dapat '
                                . 'memberikan tekanan terhadap biaya '
                                . 'impor dan transaksi internasional.';

                            $recommendation =
                                'Lakukan monitoring nilai tukar secara '
                                . 'berkala dan evaluasi biaya transaksi '
                                . 'internasional.';

                        } else {

                            $impact =
                                'Perubahan nilai tukar relatif rendah '
                                . 'sehingga dampaknya terhadap supply '
                                . 'chain diperkirakan masih terbatas.';

                            $recommendation =
                                'Aktivitas supply chain dapat berjalan '
                                . 'normal dengan monitoring nilai tukar '
                                . 'secara rutin.';

                        }


                        /*
                        |--------------------------------------------------------------------------
                        | SIMPAN HISTORI
                        |--------------------------------------------------------------------------
                        |
                        | Satu data per negara per hari.
                        |
                        */

                        CurrencyImpact::updateOrCreate(

                            [
                                'country_id' =>
                                    $country->id,

                                'currency_code' =>
                                    $currencyCode,

                                'recorded_at' =>
                                    now()->startOfDay(),
                            ],

                            [
                                'exchange_rate' =>
                                    $exchangeRate,

                                'previous_rate' =>
                                    $previousRate,

                                'change_percent' =>
                                    $changePercent,

                                'risk_level' =>
                                    $currencyRisk,

                                'impact' =>
                                    $impact,

                                'recommendation' =>
                                    $recommendation,
                            ]

                        );

                    }

                } else {

                    $currencyError =
                        'Currency API tidak dapat diakses saat ini.';

                }

            } catch (\Throwable $e) {

                $currencyError =
                    'Terjadi kesalahan saat mengambil '
                    . 'data nilai tukar dari API.';

            }

        }


        /*
        |--------------------------------------------------------------------------
        | AMBIL HISTORI TERBARU
        |--------------------------------------------------------------------------
        */

        $currencyHistory = CurrencyImpact::where(
            'country_id',
            $country->id
        )
        ->orderByDesc('recorded_at')
        ->orderByDesc('id')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'currency-impact.show',
            compact(
                'country',
                'currencyCode',
                'exchangeRate',
                'previousRate',
                'changePercent',
                'currencyRisk',
                'riskClass',
                'impact',
                'recommendation',
                'currencyError',
                'currencyHistory'
            )
        );
    }
}