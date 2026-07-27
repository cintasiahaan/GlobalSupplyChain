@extends('layouts.app')

@section('title', 'Weather Profile — ' . $country->name)

@section('content')

<a href="{{ route('weather.index') }}" class="btn-ui btn-ui-secondary" style="margin-bottom: 20px; font-size: 13px;">
    ← Kembali ke Weather Monitoring
</a>

<div class="page-header">
    <h1>🌦️ Weather Intelligence — {{ $country->name }}</h1>
    <p>Data kondisi atmosfer & indikator risiko cuaca live via Open-Meteo API.</p>
</div>

@if($weatherError)
    <div class="alert-box alert-error">
        ⚠️ {{ $weatherError }}
    </div>
@elseif($weather)
    @php
        $current = $weather['current'] ?? [];
        $temperature = $current['temperature_2m'] ?? null;
        $humidity = $current['relative_humidity_2m'] ?? null;
        $apparentTemperature = $current['apparent_temperature'] ?? null;
        $precipitation = $current['precipitation'] ?? null;
        $windSpeed = $current['wind_speed_10m'] ?? null;
        $weatherCode = $current['weather_code'] ?? null;

        $condition = match(true) {
            $weatherCode === 0 => 'Cerah (Clear Sky)',
            in_array($weatherCode, [1, 2, 3]) => 'Berawan (Partly Cloudy)',
            in_array($weatherCode, [45, 48]) => 'Kabut (Foggy)',
            in_array($weatherCode, [51, 53, 55, 56, 57]) => 'Gerimis (Drizzle)',
            in_array($weatherCode, [61, 63, 65, 66, 67]) => 'Hujan (Rainy)',
            in_array($weatherCode, [71, 73, 75, 77]) => 'Salju (Snow)',
            in_array($weatherCode, [80, 81, 82]) => 'Hujan Deras (Heavy Showers)',
            in_array($weatherCode, [95, 96, 99]) => 'Badai Petir (Thunderstorm)',
            default => 'Tidak Diketahui',
        };

        if (in_array($weatherCode, [65, 67, 75, 82, 95, 96, 99]) || ($windSpeed !== null && $windSpeed >= 50)) {
            $weatherRisk = 'HIGH';
        } elseif (in_array($weatherCode, [51, 53, 55, 61, 63, 71, 73, 80, 81]) || ($windSpeed !== null && $windSpeed >= 30)) {
            $weatherRisk = 'MEDIUM';
        } else {
            $weatherRisk = 'LOW';
        }
    @endphp

    <!-- MAIN WEATHER HERO CARD -->
    <div style="background: linear-gradient(135deg, #0284c7, #0f172a); border-radius: 20px; padding: 30px; color: white; margin-bottom: 28px; box-shadow: var(--shadow-md); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
        <div>
            <div style="font-size: 13px; text-transform: uppercase; letter-spacing: 1px; color: #7dd3fc; font-weight: 700;">Temperatur Terkini</div>
            <div style="font-size: 52px; font-weight: 800; letter-spacing: -1.5px; margin: 6px 0;">
                {{ $temperature ?? '-' }}°C
            </div>
            <div style="font-size: 18px; font-weight: 700; display: flex; align-items: center; gap: 8px;">
                <span>{{ $weatherCode === 0 ? '☀️' : ($weatherCode >= 95 ? '⛈️' : ($weatherCode >= 61 ? '🌧️' : '☁️')) }}</span>
                {{ $condition }}
            </div>
        </div>

        <div>
            <div style="text-align: right;">
                <div style="font-size: 12px; color: #94a3b8;">Risk Level Indicator</div>
                @if($weatherRisk === 'HIGH')
                    <span class="badge-risk badge-risk-high" style="font-size: 16px; padding: 8px 16px; margin-top: 6px;">🔴 High Weather Risk</span>
                @elseif($weatherRisk === 'MEDIUM')
                    <span class="badge-risk badge-risk-medium" style="font-size: 16px; padding: 8px 16px; margin-top: 6px;">🟡 Medium Weather Risk</span>
                @else
                    <span class="badge-risk badge-risk-low" style="font-size: 16px; padding: 8px 16px; margin-top: 6px;">🟢 Low Weather Risk</span>
                @endif
            </div>
        </div>
    </div>

    <!-- ATMOSPHERIC METRICS GRID -->
    <div class="cards">
        <div class="card">
            <div class="card-title">💧 Kelembapan (Humidity)</div>
            <div class="card-number">{{ $humidity ?? '-' }}%</div>
        </div>

        <div class="card">
            <div class="card-title">🌡️ Presepsi Suhu (Feels Like)</div>
            <div class="card-number">{{ $apparentTemperature ?? '-' }}°C</div>
        </div>

        <div class="card">
            <div class="card-title">💨 Kecepatan Angin</div>
            <div class="card-number">{{ $windSpeed ?? '-' }} km/h</div>
        </div>

        <div class="card">
            <div class="card-title">🌧️ Curah Hujan (Precipitation)</div>
            <div class="card-number">{{ $precipitation ?? '-' }} mm</div>
        </div>
    </div>

    <!-- SUPPLY CHAIN ADVISORY BOX -->
    <div class="table-container">
        <h2>🚢 Weather Impact & Operational Advisory</h2>
        @if($weatherRisk === 'HIGH')
            <div style="padding: 20px; background: #fee2e2; border-radius: 12px; color: #991b1b; border: 1px solid #fca5a5;">
                <h3 style="font-size: 16px; margin-bottom: 8px;">⚠️ Peringatan Badai / Cuaca Ekstrem</h3>
                <p style="font-size: 14px; line-height: 1.6;">
                    Kondisi cuaca berpotensi tinggi mengganggu aktivitas bongkar muat di pelabuhan dan rute kapal kargo di <strong>{{ $country->name }}</strong>. Disarankan untuk menunda penerbitan jadwal pelayaran kritis atau menggunakan buffer waktu logistik ekstra.
                </p>
            </div>
        @elseif($weatherRisk === 'MEDIUM')
            <div style="padding: 20px; background: #fef3c7; border-radius: 12px; color: #92400e; border: 1px solid #fde68a;">
                <h3 style="font-size: 16px; margin-bottom: 8px;">ℹ️ Peringatan Cuaca Sedang</h3>
                <p style="font-size: 14px; line-height: 1.6;">
                    Cuaca dapat memicu keterlambatan skala kecil pada transportasi darat maupun laut. Tetap koordinasikan dengan agen pengapalan lokal.
                </p>
            </div>
        @else
            <div style="padding: 20px; background: #dcfce7; border-radius: 12px; color: #166534; border: 1px solid #86efac;">
                <h3 style="font-size: 16px; margin-bottom: 8px;">✅ Kondisi Atmosfer Cenderung Aman</h3>
                <p style="font-size: 14px; line-height: 1.6;">
                    Tidak ada indikasi badai atau ancaman cuaca signifikan. Aktivitas logistik dan maritim dapat berjalan normal di {{ $country->name }}.
                </p>
            </div>
        @endif
    </div>
@endif

@endsection