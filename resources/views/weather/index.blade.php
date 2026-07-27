@extends('layouts.app')

@section('title', 'Weather Monitoring')

@section('content')

<div class="page-header">
    <h1>🌦️ Weather Monitoring</h1>
    <p>Pantau kondisi cuaca real-time yang dapat berdampak pada kelancaran rantai pasok global.</p>
</div>

<div class="table-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <h2>🌍 Monitoring Cuaca Berdasarkan Negara</h2>
        <span style="font-size: 13px; color: var(--text-muted);">Integrasi data live Open-Meteo API</span>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Negara</th>
                    <th>Region</th>
                    <th>Koordinat (Lat, Lng)</th>
                    <th>Risk Level Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td><strong>{{ $loop->iteration }}</strong></td>
                        <td>
                            <a href="{{ route('weather.show', $country) }}" style="color: var(--text-dark); font-weight: 700; text-decoration: none;">
                                🌍 {{ $country->name }}
                            </a>
                        </td>
                        <td>{{ $country->region ?? '-' }}</td>
                        <td>
                            @if($country->latitude !== null && $country->longitude !== null)
                                <code style="font-size: 12px; background: #f1f5f9; padding: 4px 8px; border-radius: 6px;">
                                    {{ $country->latitude }}, {{ $country->longitude }}
                                </code>
                            @else
                                <span style="color: var(--text-muted); font-size: 13px;">Belum ada koordinat</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $level = $country->riskAssessment->risk_level ?? 'Low';
                            @endphp
                            @if($level === 'High')
                                <span class="badge-risk badge-risk-high">🔴 High Risk</span>
                            @elseif($level === 'Medium')
                                <span class="badge-risk badge-risk-medium">🟡 Medium Risk</span>
                            @else
                                <span class="badge-risk badge-risk-low">🟢 Low Risk</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('weather.show', $country) }}" class="btn-ui btn-ui-primary" style="padding: 6px 12px; font-size: 12px;">
                                🌦️ Live Weather
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 30px; color: var(--text-muted);">
                            Belum ada data negara yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection