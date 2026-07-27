@extends('layouts.app')

@section('title', 'Country Profile — ' . $country->name)

@section('content')

<style>
    .country-header-card {
        background: linear-gradient(135deg, #1e293b, #0f172a);
        border: 1px solid rgba(255, 255, 255, 0.08);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 28px;
        color: white;
        box-shadow: var(--shadow-md);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .country-header-title h1 {
        font-size: 28px;
        font-weight: 800;
        letter-spacing: -0.5px;
        margin-bottom: 6px;
    }

    .country-header-title p {
        color: #94a3b8;
        font-size: 14px;
    }

    .action-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
    }

    .risk-meter-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .risk-factor-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 22px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    .risk-factor-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .risk-factor-title {
        font-size: 13px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .risk-factor-val {
        font-size: 20px;
        font-weight: 800;
        color: var(--text-dark);
    }

    .progress-bar-bg {
        width: 100%;
        height: 8px;
        background: #e2e8f0;
        border-radius: 4px;
        overflow: hidden;
        margin-top: 10px;
    }

    .progress-bar-fill {
        height: 100%;
        border-radius: 4px;
        transition: width 0.5s ease;
    }

    .quick-tools {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin-top: 28px;
    }
</style>

<a href="{{ route('countries.index') }}" class="btn-ui btn-ui-secondary" style="margin-bottom: 20px; font-size: 13px;">
    ← Kembali ke Country Monitoring
</a>

<!-- HEADER CARD -->
<div class="country-header-card">
    <div class="country-header-title">
        <h1>🌍 {{ $country->name }}</h1>
        <p>Region: <strong>{{ $country->region ?? 'N/A' }}</strong> &bull; Kode ISO: <strong>{{ $country->code ?? 'N/A' }}</strong></p>
    </div>

    <div class="action-row">
        @auth
            @if($watchlistId)
                <form method="POST" action="{{ route('watchlist.destroy', $watchlistId) }}" style="margin:0;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-ui btn-ui-danger">
                        ⭐ Hapus dari Watchlist
                    </button>
                </form>
            @else
                <form method="POST" action="{{ route('watchlist.store', $country) }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-ui btn-ui-warning">
                        ⭐ Tambah ke Watchlist
                    </button>
                </form>
            @endif

            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.risk-assessments.create', $country) }}" class="btn-ui btn-ui-primary">
                    📊 Update Risk Assessment
                </a>
            @endif
        @endauth
    </div>
</div>

<!-- OVERVIEW METRICS -->
<div class="cards">
    <div class="card">
        <div class="card-title">📊 Total Risk Score</div>
        <div class="card-number">
            {{ $country->riskAssessment ? number_format($country->riskAssessment->risk_score, 2) : '-' }}
        </div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 6px;">Indeks risiko gabungan 0-100</p>
    </div>

    <div class="card">
        <div class="card-title">🚦 Status Risk Level</div>
        <div style="margin-top: 10px;">
            @php
                $riskLevel = $country->riskAssessment->risk_level ?? 'No Assessment';
            @endphp
            @if($riskLevel === 'High')
                <span class="badge-risk badge-risk-high" style="font-size: 16px; padding: 8px 16px;">🔴 High Risk</span>
            @elseif($riskLevel === 'Medium')
                <span class="badge-risk badge-risk-medium" style="font-size: 16px; padding: 8px 16px;">🟡 Medium Risk</span>
            @elseif($riskLevel === 'Low')
                <span class="badge-risk badge-risk-low" style="font-size: 16px; padding: 8px 16px;">🟢 Low Risk</span>
            @else
                <span class="badge-risk" style="background: #f1f5f9; color: #475569;">⚪ No Assessment</span>
            @endif
        </div>
    </div>
</div>

<!-- 5-FACTOR RISK BREAKDOWN -->
<div class="table-container">
    <h2>📊 5-Factor Supply Chain Risk Breakdown</h2>
    <p style="font-size: 13.5px; color: var(--text-muted); margin-bottom: 24px;">
        Rincian skor risiko berdasarkan 5 indikator utama rantai pasok untuk negara <strong>{{ $country->name }}</strong>.
    </p>

    @if($country->riskAssessment)
        @php
            $ra = $country->riskAssessment;
        @endphp
        <div class="risk-meter-container">
            <!-- WEATHER RISK -->
            <div class="risk-factor-card">
                <div class="risk-factor-header">
                    <span class="risk-factor-title">🌦️ Weather Risk</span>
                    <span class="risk-factor-val">{{ number_format($ra->weather_risk, 1) }}</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $ra->weather_risk }}%; background: #3b82f6;"></div>
                </div>
            </div>

            <!-- ECONOMIC RISK -->
            <div class="risk-factor-card">
                <div class="risk-factor-header">
                    <span class="risk-factor-title">💰 Economic Risk</span>
                    <span class="risk-factor-val">{{ number_format($ra->economic_risk, 1) }}</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $ra->economic_risk }}%; background: #22c55e;"></div>
                </div>
            </div>

            <!-- CURRENCY RISK -->
            <div class="risk-factor-card">
                <div class="risk-factor-header">
                    <span class="risk-factor-title">💱 Currency Risk</span>
                    <span class="risk-factor-val">{{ number_format($ra->currency_risk, 1) }}</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $ra->currency_risk }}%; background: #f59e0b;"></div>
                </div>
            </div>

            <!-- POLITICAL RISK -->
            <div class="risk-factor-card">
                <div class="risk-factor-header">
                    <span class="risk-factor-title">🏛️ Political Risk</span>
                    <span class="risk-factor-val">{{ number_format($ra->political_risk, 1) }}</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $ra->political_risk }}%; background: #ef4444;"></div>
                </div>
            </div>

            <!-- PORT RISK -->
            <div class="risk-factor-card">
                <div class="risk-factor-header">
                    <span class="risk-factor-title">⚓ Port Risk</span>
                    <span class="risk-factor-val">{{ number_format($ra->port_risk, 1) }}</span>
                </div>
                <div class="progress-bar-bg">
                    <div class="progress-bar-fill" style="width: {{ $ra->port_risk }}%; background: #8b5cf6;"></div>
                </div>
            </div>
        </div>
    @else
        <div style="padding: 30px; text-align: center; background: #f8fafc; border-radius: 14px; color: var(--text-muted);">
            Data Risk Assessment belum tersedia untuk negara ini.
        </div>
    @endif
</div>

<!-- RISK RECOMMENDATION -->
<div class="table-container">
    <h2>💡 Risk Management Recommendation</h2>
    @if($country->riskAssessment)
        @php
            $lvl = $country->riskAssessment->risk_level;
        @endphp
        @if($lvl === 'High')
            <div style="padding: 20px; background: #fee2e2; border-radius: 12px; color: #991b1b; border: 1px solid #fca5a5;">
                <h3 style="font-size: 16px; margin-bottom: 8px;">🔴 High Risk — Perhatian & Mitigasi Segera</h3>
                <p style="font-size: 14px; line-height: 1.6;">
                    Aktivitas supply chain yang melibatkan <strong>{{ $country->name }}</strong> memerlukan strategi mitigasi risiko tinggi. Disarankan untuk menyiapkan alternatif pemasok cadangan, rute transportasi diversifikasi, serta buffer stok barang secukupnya.
                </p>
            </div>
        @elseif($lvl === 'Medium')
            <div style="padding: 20px; background: #fef3c7; border-radius: 12px; color: #92400e; border: 1px solid #fde68a;">
                <h3 style="font-size: 16px; margin-bottom: 8px;">🟡 Medium Risk — Pemantauan Berkala</h3>
                <p style="font-size: 14px; line-height: 1.6;">
                    Tingkat risiko di <strong>{{ $country->name }}</strong> dalam batas sedang. Lakukan evaluasi rutin terhadap indikator cuaca, nilai tukar mata uang, dan stabilitas operasional pelabuhan.
                </p>
            </div>
        @else
            <div style="padding: 20px; background: #dcfce7; border-radius: 12px; color: #166534; border: 1px solid #86efac;">
                <h3 style="font-size: 16px; margin-bottom: 8px;">🟢 Low Risk — Kondisi Normal</h3>
                <p style="font-size: 14px; line-height: 1.6;">
                    Risiko rantai pasok di <strong>{{ $country->name }}</strong> relatif stabil dan aman. Aktivitas logistik dan perdagangan dapat berjalan normal dengan pemantauan rutin.
                </p>
            </div>
        @endif
    @else
        <div style="padding: 20px; background: #f8fafc; border-radius: 12px; color: var(--text-muted);">
            Belum ada rekomendasi karena data assessment belum terisi.
        </div>
    @endif
</div>

<!-- QUICK MODULE TOOLS FOR THIS COUNTRY -->
<div class="quick-tools">
    <a href="{{ route('weather.show', $country) }}" class="card" style="text-decoration: none; color: var(--text-dark);">
        <div style="font-size: 28px; margin-bottom: 8px;">🌦️</div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">Weather Intelligence</h3>
        <p style="font-size: 13px; color: var(--text-muted);">Cek kondisi cuaca terkini & prakiraan cuaca {{ $country->name }}.</p>
    </a>

    <a href="{{ route('currency-impact.show', $country) }}" class="card" style="text-decoration: none; color: var(--text-dark);">
        <div style="font-size: 28px; margin-bottom: 8px;">💱</div>
        <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">Currency Impact Analysis</h3>
        <p style="font-size: 13px; color: var(--text-muted);">Lihat volatilitas mata uang dan dampak terhadap biaya impor.</p>
    </a>
</div>

<!-- LOCATION MAP -->
@if($country->latitude !== null && $country->longitude !== null)
    <div class="table-container" style="margin-top: 28px;">
        <h2>📍 Geolocation Map — {{ $country->name }}</h2>
        <div id="countryMap" style="width: 100%; height: 380px; border-radius: 14px; margin-top: 14px;"></div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const lat = {{ $country->latitude }};
        const lng = {{ $country->longitude }};

        const map = L.map('countryMap').setView([lat, lng], 5);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap'
        }).addTo(map);

        L.marker([lat, lng]).addTo(map).bindPopup('<strong>🌍 {{ $country->name }}</strong>').openPopup();
    });
    </script>
@endif

@endsection