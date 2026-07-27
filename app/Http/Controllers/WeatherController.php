<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * Halaman daftar negara untuk Weather Monitoring
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get();

        return view(
            'weather.index',
            compact('countries')
        );
    }

    /**
     * Menampilkan detail cuaca berdasarkan koordinat negara
     */
    public function show(Country $country)
    {
        $weather = null;
        $weatherError = null;

        // Pastikan negara memiliki koordinat
        if (
            $country->latitude === null ||
            $country->longitude === null
        ) {
            $weatherError = 'Koordinat negara belum tersedia di database.';
        } else {

            try {

                // Request ke Open-Meteo API
                $response = Http::timeout(15)
                    ->get(
                        'https://api.open-meteo.com/v1/forecast',
                        [
                            'latitude' => $country->latitude,

                            'longitude' => $country->longitude,

                            'current' => implode(',', [
                                'temperature_2m',
                                'relative_humidity_2m',
                                'apparent_temperature',
                                'precipitation',
                                'weather_code',
                                'wind_speed_10m',
                            ]),

                            'timezone' => 'auto',
                        ]
                    );

                // Jika API berhasil
                if ($response->successful()) {

                    $weather = $response->json();

                } else {

                    $weatherError =
                        'Open-Meteo API gagal memberikan data cuaca.';

                }

            } catch (\Throwable $e) {

                $weatherError =
                    'Tidak dapat terhubung ke Open-Meteo API. '
                    . 'Periksa koneksi internet server.';

            }
        }

        return view(
            'weather.show',
            compact(
                'country',
                'weather',
                'weatherError'
            )
        );
    }
}