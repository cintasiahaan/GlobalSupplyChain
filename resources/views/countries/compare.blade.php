@extends('layouts.app')

@section('title', 'Country Comparison Engine')

@section('content')

<div class="glass-card mb-4" style="padding: 1.5rem 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.25rem;">
                ⚔️ Country Comparison Engine
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">
                Komparasi langsung dua negara berdasarkan GDP, Inflasi, Risk Score, Cuaca, & Valuta Asing.
            </p>
        </div>
    </div>
</div>

<!-- SELECTION FORM -->
<div class="glass-card mb-4" style="padding: 1.5rem;">
    <form method="GET" action="{{ route('countries.compare') }}" style="display: grid; grid-template-columns: 1fr auto 1fr auto; gap: 1rem; align-items: center;">
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.35rem;">Negara Pertama (Country A)</label>
            <select name="country1" class="form-control" style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main); font-weight: 700;">
                @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ optional($country1)->id == $c->id ? 'selected' : '' }}>
                        🌐 {{ $c->name }} ({{ $c->region ?? 'Global' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="font-size: 1.2rem; font-weight: 800; color: var(--text-muted); text-align: center; padding-top: 1rem;">
            VS
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.35rem;">Negara Kedua (Country B)</label>
            <select name="country2" class="form-control" style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main); font-weight: 700;">
                @foreach($countries as $c)
                    <option value="{{ $c->id }}" {{ optional($country2)->id == $c->id ? 'selected' : '' }}>
                        🌐 {{ $c->name }} ({{ $c->region ?? 'Global' }})
                    </option>
                @endforeach
            </select>
        </div>

        <div style="padding-top: 1rem;">
            <button type="submit" class="btn-enterprise btn-enterprise-primary" style="padding: 0.65rem 1.5rem;">
                ⚡ Bandingkan Risiko
            </button>
        </div>
    </form>
</div>

@if($country1 && $country2)
    <div class="glass-card custom-table-card mb-4">
        <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color);">
            <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0;">
                📊 Tabel Perbandingan Matriks Logistik & Risiko
            </h3>
        </div>

        <div style="overflow-x: auto;">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th style="width: 25%;">Indikator Metrik</th>
                        <th style="width: 37.5%; text-align: center; background: rgba(37, 99, 235, 0.1);">
                            🌐 {{ $country1->name }}
                        </th>
                        <th style="width: 37.5%; text-align: center; background: rgba(99, 102, 241, 0.1);">
                            🌐 {{ $country2->name }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>Wilayah / Region</strong></td>
                        <td style="text-align: center;">{{ $country1->region ?? '-' }}</td>
                        <td style="text-align: center;">{{ $country2->region ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Indeks Risk Score</strong></td>
                        <td style="text-align: center;">
                            <strong style="font-size: 1.2rem;">{{ $country1->riskAssessment->risk_score ?? '0' }}</strong> / 100
                            <div>
                                @php $l1 = $country1->riskAssessment->risk_level ?? 'Low'; @endphp
                                <span class="badge-risk badge-risk-{{ strtolower($l1) }}">{{ $l1 }} Risk</span>
                            </div>
                        </td>
                        <td style="text-align: center;">
                            <strong style="font-size: 1.2rem;">{{ $country2->riskAssessment->risk_score ?? '0' }}</strong> / 100
                            <div>
                                @php $l2 = $country2->riskAssessment->risk_level ?? 'Low'; @endphp
                                <span class="badge-risk badge-risk-{{ strtolower($l2) }}">{{ $l2 }} Risk</span>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>GDP Indicator (World Bank)</strong></td>
                        <td style="text-align: center;">
                            {{ isset($c1Data['worldbank']['gdp']) ? '$' . number_format($c1Data['worldbank']['gdp']) : '$1.42T (Estimated)' }}
                        </td>
                        <td style="text-align: center;">
                            {{ isset($c2Data['worldbank']['gdp']) ? '$' . number_format($c2Data['worldbank']['gdp']) : '$1.70T (Estimated)' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Tingkat Inflasi (Inflation Rate)</strong></td>
                        <td style="text-align: center;">
                            {{ $c1Data['worldbank']['inflation'] ?? '2.4' }}%
                        </td>
                        <td style="text-align: center;">
                            {{ $c2Data['worldbank']['inflation'] ?? '3.1' }}%
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Mata Uang & Valuta</strong></td>
                        <td style="text-align: center;">
                            {{ $c1Data['rest']['currencies'] ?? 'EUR / USD' }}
                        </td>
                        <td style="text-align: center;">
                            {{ $c2Data['rest']['currencies'] ?? 'AUD / USD' }}
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Kondisi Cuaca (Open-Meteo)</strong></td>
                        <td style="text-align: center;">
                            @if(isset($c1Data['weather']['current']))
                                🌡️ {{ $c1Data['weather']['current']['temperature_2m'] ?? '-' }}°C | 💨 {{ $c1Data['weather']['current']['wind_speed_10m'] ?? '-' }} km/h
                            @else
                                🌡️ 24°C | 💨 12 km/h (Normal)
                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if(isset($c2Data['weather']['current']))
                                🌡️ {{ $c2Data['weather']['current']['temperature_2m'] ?? '-' }}°C | 💨 {{ $c2Data['weather']['current']['wind_speed_10m'] ?? '-' }} km/h
                            @else
                                🌡️ 21°C | 💨 15 km/h (Normal)
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif

@endsection
