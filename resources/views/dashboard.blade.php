@extends('layouts.app')

@section('title', 'Supply Chain Risk Intelligence Dashboard')

@section('content')

<!-- Leaflet CSS & JS CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- WELCOME BANNER (Glassmorphism Elevated Header) -->
<div class="glass-card mb-4" style="padding: 1.75rem 2rem; background: linear-gradient(135deg, rgba(15, 23, 42, 0.95), rgba(30, 41, 59, 0.9)); color: white; border-radius: var(--border-radius-md);">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
        <div>
            @auth
                <h2 style="font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.25rem;">
                    Selamat Datang Kembali, {{ auth()->user()->name }} 👋
                </h2>
                <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">
                    Global Supply Chain Risk Platform monitoring <strong>{{ $totalCountries }} negara</strong> secara real-time.
                </p>
            @else
                <h2 style="font-size: 1.6rem; font-weight: 800; letter-spacing: -0.02em; margin-bottom: 0.25rem;">
                    Global Supply Chain Risk Intelligence 🌍
                </h2>
                <p style="color: #94a3b8; font-size: 0.9rem; margin: 0;">
                    Platform Pemantauan Risiko Geopolitik, Cuaca Maritim & Operasional Impor/Ekspor.
                </p>
            @endauth
        </div>

        <div style="display: flex; gap: 0.75rem; align-items: center;">
            @auth
                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="btn-enterprise btn-enterprise-primary">
                        🛠️ Admin Control Panel
                    </a>
                @else
                    <a href="{{ route('watchlist.index') }}" class="btn-enterprise btn-enterprise-outline" style="color: white; border-color: rgba(255,255,255,0.2);">
                        ⭐ My Watchlist
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-enterprise btn-enterprise-primary">🔐 Login</a>
                <a href="{{ route('register') }}" class="btn-enterprise btn-enterprise-outline" style="color: white; border-color: rgba(255,255,255,0.2);">✏️ Register</a>
            @endauth
        </div>
    </div>
</div>

<!-- METRIC CARDS (KPI Grid with Emerald, Amber, Crimson Accents) -->
<div class="metrics-grid">
    <!-- Total Monitored Countries -->
    <div class="glass-card metric-card">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Monitored Countries</span>
            <div class="metric-icon-wrapper">🌍</div>
        </div>
        <div class="metric-value-group">
            <div class="metric-number">{{ $totalCountries }}</div>
            <div class="metric-trend trend-up">
                ↑ +4% <span style="font-weight: 500; font-size: 0.7rem; color: var(--text-subtle);">vs last mo</span>
            </div>
        </div>
        <div class="metric-subtext">Cakupan pengawasan logistik global</div>
    </div>

    <!-- Low Risk Indicator Card -->
    <div class="glass-card metric-card accent-low">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Low Risk Zones</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-emerald-main);">🟢</div>
        </div>
        <div class="metric-value-group">
            <div class="metric-number" style="color: var(--risk-emerald-text);">{{ $lowRisk }}</div>
            <span class="badge-risk badge-risk-low">Stable</span>
        </div>
        <div class="metric-subtext">Rantai pasok beroperasi normal</div>
    </div>

    <!-- Medium Risk Indicator Card -->
    <div class="glass-card metric-card accent-medium">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Medium Risk Zones</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-amber-main);">🟡</div>
        </div>
        <div class="metric-value-group">
            <div class="metric-number" style="color: var(--risk-amber-text);">{{ $mediumRisk }}</div>
            <span class="badge-risk badge-risk-medium">Watch</span>
        </div>
        <div class="metric-subtext">Perlu pengawasan berkala</div>
    </div>

    <!-- High Risk Indicator Card -->
    <div class="glass-card metric-card accent-high">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">High Risk Alerts</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-crimson-main);">🔴</div>
        </div>
        <div class="metric-value-group">
            <div class="metric-number" style="color: var(--risk-crimson-text);">{{ $highRisk }}</div>
            <span class="badge-risk badge-risk-high">Critical</span>
        </div>
        <div class="metric-subtext">Potensi gangguan jalur distribusi</div>
    </div>
</div>

<!-- MAIN DASHBOARD GRID: MAP & CHART -->
<div class="dashboard-twin-grid">
    <!-- LEAFLET MAP CONTAINER -->
    <div class="glass-card map-card-container">
        <div class="map-header-bar">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0; color: var(--text-main);">
                    🗺️ Interactive Global Risk Map
                </h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                    Pemetaan geotagging tingkat risiko <strong>{{ count($allCountries) }} negara</strong> & status pelabuhan maritim.
                </p>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center; flex-wrap: wrap;">
                <button type="button" class="badge-risk badge-risk-low legend-filter-btn" onclick="filterMap('low')" style="border: none; cursor: pointer; transition: transform 0.15s ease;" title="Klik untuk filter negara Low Risk">🟢 Emerald: Low</button>
                <button type="button" class="badge-risk badge-risk-medium legend-filter-btn" onclick="filterMap('medium')" style="border: none; cursor: pointer; transition: transform 0.15s ease;" title="Klik untuk filter negara Medium Risk">🟡 Amber: Medium</button>
                <button type="button" class="badge-risk badge-risk-high legend-filter-btn" onclick="filterMap('high')" style="border: none; cursor: pointer; transition: transform 0.15s ease;" title="Klik untuk filter negara High Risk">🔴 Crimson: High</button>
            </div>
        </div>

        <div class="map-wrapper-inner" style="position: relative;">
            <!-- Map Filter Floating Overlay -->
            <div class="map-overlay-controls" style="z-index: 1000;">
                <button type="button" class="map-filter-btn active" data-filter="all" onclick="filterMap('all')">All Regions (48)</button>
                <button type="button" class="map-filter-btn" data-filter="high" onclick="filterMap('high')">High Risk</button>
                <button type="button" class="map-filter-btn" data-filter="ports" onclick="filterMap('ports')">Ports Layer</button>
            </div>
            <div id="map" style="width: 100%; height: 480px; position: relative; z-index: 1; border-radius: 12px; overflow: hidden;"></div>
        </div>
    </div>


    <!-- GLOBAL RISK INDEX & CHART -->
    <div style="display: flex; flex-direction: column; gap: 1.5rem;">
        <!-- Global Index Card -->
        <div class="glass-card" style="padding: 1.5rem;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 0.75rem;">
                <span class="metric-label">Global Risk Index Score</span>
                @if($globalRiskLevel === 'High')
                    <span class="badge-risk badge-risk-high">High Risk Overall</span>
                @elseif($globalRiskLevel === 'Medium')
                    <span class="badge-risk badge-risk-medium">Medium Risk Overall</span>
                @else
                    <span class="badge-risk badge-risk-low">Low Risk Overall</span>
                @endif
            </div>
            <div style="display: flex; align-items: baseline; gap: 0.75rem; margin-top: 0.5rem;">
                <div style="font-size: 3rem; font-weight: 800; line-height: 1; letter-spacing: -0.04em; color: var(--text-main);">
                    {{ number_format($globalRiskScore, 2) }}
                </div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">
                    / 100 Index Points
                </div>
            </div>
            <p style="font-size: 0.8rem; color: var(--text-subtle); margin-top: 0.75rem; margin-bottom: 0;">
                Skor agregat dihitung dari indeks inflasi, stabilitas politik, serta data cuaca maritim.
            </p>
        </div>

        <!-- Risk Distribution Chart Card -->
        <div class="glass-card" style="padding: 1.5rem; flex-grow: 1; display: flex; flex-direction: column;">
            <h4 style="font-size: 0.95rem; font-weight: 800; margin-bottom: 1rem; color: var(--text-main);">
                📊 Risk Level Distribution
            </h4>
            <div style="flex-grow: 1; position: relative; min-height: 220px;">
                <canvas id="riskDistributionChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- NEWS INTELLIGENCE & WATCHLIST TWIN SECTION -->
<div class="dashboard-twin-grid">
    <!-- NEWS INTELLIGENCE FEED -->
    <div class="glass-card" style="padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0; color: var(--text-main);">
                    📰 News Intelligence Feed
                </h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                    Informasi terupdate mengenai gangguan rantai pasok global.
                </p>
            </div>
            <a href="{{ route('news.index') }}" class="btn-enterprise btn-enterprise-outline" style="padding: 0.4rem 0.85rem; font-size: 0.75rem;">
                View All Feed ➔
            </a>
        </div>

        <div class="newsfeed-container">
            <!-- News Item 1 -->
            <div class="news-card-item">
                <div class="news-card-badge" style="background: rgba(239, 68, 68, 0.15); color: var(--risk-crimson-main);">
                    ⚓
                </div>
                <div class="news-card-content">
                    <div class="news-card-meta">
                        <span class="badge-risk badge-risk-high" style="padding: 0.15rem 0.5rem; font-size: 0.65rem;">High Impact</span>
                        <span>• 25 Mins Ago</span>
                        <span>• Maritime Logistics</span>
                    </div>
                    <h4 class="news-card-title">
                        <a href="{{ route('news.index') }}">Kemacetan Jalur Terusan Suez Berpotensi Menambah Lead Time Pengiriman 4-6 Hari</a>
                    </h4>
                    <p class="news-card-snippet">
                        Peningkatan kepadatan kapal kargo di Selat Bab el-Mandeb memicu penyesuaian rute kapal kontainer utama mengelilingi Afrika.
                    </p>
                </div>
            </div>

            <!-- News Item 2 -->
            <div class="news-card-item">
                <div class="news-card-badge" style="background: rgba(245, 158, 11, 0.15); color: var(--risk-amber-main);">
                    💱
                </div>
                <div class="news-card-content">
                    <div class="news-card-meta">
                        <span class="badge-risk badge-risk-medium" style="padding: 0.15rem 0.5rem; font-size: 0.65rem;">Medium Impact</span>
                        <span>• 2 Hours Ago</span>
                        <span>• Currency FX</span>
                    </div>
                    <h4 class="news-card-title">
                        <a href="{{ route('news.index') }}">Fluktuasi Nilai Tukar USD/IDR Mengubah Proyeksi Biaya Impor Bahan Baku</a>
                    </h4>
                    <p class="news-card-snippet">
                        Penguatan mata uang Dolar AS berdampak padamargin manufaktur lokal yang mengandalkan bahan baku impor dari kawasan Asia Timur.
                    </p>
                </div>
            </div>

            <!-- News Item 3 -->
            <div class="news-card-item">
                <div class="news-card-badge" style="background: rgba(16, 185, 129, 0.15); color: var(--risk-emerald-main);">
                    🌦️
                </div>
                <div class="news-card-content">
                    <div class="news-card-meta">
                        <span class="badge-risk badge-risk-low" style="padding: 0.15rem 0.5rem; font-size: 0.65rem;">Operational Update</span>
                        <span>• 5 Hours Ago</span>
                        <span>• Weather Advisory</span>
                    </div>
                    <h4 class="news-card-title">
                        <a href="{{ route('news.index') }}">Cuaca Pelabuhan Shanghai Kembali Normal Pasca Badai Topan</a>
                    </h4>
                    <p class="news-card-snippet">
                        Aktivitas bongkar muat di Pelabuhan Yangshan kembali beroperasi penuh secara bertahap mulai pagi hari ini.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- QUICK WATCHLIST SUMMARY -->
    <div class="glass-card" style="padding: 1.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem;">
            <div>
                <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0; color: var(--text-main);">
                    ⭐ Monitored Watchlist
                </h3>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                    Ringkasan negara berisiko tinggi yang paling sering dipantau.
                </p>
            </div>
        </div>

        <div class="watchlist-container">
            @forelse($topHighRiskCountries->take(4) as $country)
                @php
                    $level = $country->riskAssessment->risk_level ?? 'Low';
                    $score = $country->riskAssessment->risk_score ?? 0;
                @endphp
                <div class="watchlist-item-card">
                    <div class="watchlist-flag-title">
                        <span class="watchlist-flag-icon">🌐</span>
                        <div>
                            <div class="watchlist-name">{{ $country->name }}</div>
                            <div class="watchlist-region">{{ $country->region ?? 'Global Region' }}</div>
                        </div>
                    </div>
                    <div style="text-align: right;">
                        <div style="font-weight: 800; font-size: 0.95rem; color: var(--text-main);">{{ $score }} pts</div>
                        @if($level === 'High')
                            <span class="badge-risk badge-risk-high" style="padding: 0.15rem 0.5rem; font-size: 0.65rem;">High Risk</span>
                        @elseif($level === 'Medium')
                            <span class="badge-risk badge-risk-medium" style="padding: 0.15rem 0.5rem; font-size: 0.65rem;">Medium Risk</span>
                        @else
                            <span class="badge-risk badge-risk-low" style="padding: 0.15rem 0.5rem; font-size: 0.65rem;">Low Risk</span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="text-align: center; color: var(--text-muted); padding: 1.5rem;">
                    Belum ada data watchlist.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- HIGH RISK COUNTRIES OVERVIEW TABLE -->
<div class="glass-card custom-table-card mb-4">
    <div style="padding: 1.25rem 1.5rem; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--border-color);">
        <div>
            <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0; color: var(--text-main);">
                🚨 Top High-Risk Monitored Countries
            </h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                Negara dengan indeks risiko tertinggi yang memerlukan tindakan mitigasi lanjutan.
            </p>
        </div>
        <a href="{{ route('countries.index') }}" class="btn-enterprise btn-enterprise-primary" style="padding: 0.5rem 1rem; font-size: 0.8rem;">
            Lihat Semua Negara ➔
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Negara</th>
                    <th>Region</th>
                    <th>Risk Score</th>
                    <th>Status Risk Level</th>
                    <th>Aksi Detail</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topHighRiskCountries as $country)
                    <tr>
                        <td><strong>{{ $loop->iteration }}</strong></td>
                        <td>
                            <a href="{{ route('countries.show', $country) }}" style="color: var(--primary); font-weight: 700; text-decoration: none;">
                                🌐 {{ $country->name }}
                            </a>
                        </td>
                        <td>{{ $country->region ?? '-' }}</td>
                        <td>
                            <strong style="font-size: 1.05rem;">{{ $country->riskAssessment->risk_score ?? 0 }}</strong>
                        </td>
                        <td>
                            @php
                                $level = $country->riskAssessment->risk_level ?? 'Low';
                            @endphp
                            @if($level === 'High')
                                <span class="badge-risk badge-risk-high">High Risk</span>
                            @elseif($level === 'Medium')
                                <span class="badge-risk badge-risk-medium">Medium Risk</span>
                            @else
                                <span class="badge-risk badge-risk-low">Low Risk</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('countries.show', $country) }}" class="btn-enterprise btn-enterprise-outline" style="padding: 0.35rem 0.75rem; font-size: 0.75rem;">
                                👁️ View Profile
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Belum ada data Risk Assessment yang tersedia.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- LEAFLET & CHART INIT SCRIPTS -->
<script>
let leafletMap = null;
let countryMarkers = [];
let portMarkers = [];

document.addEventListener('DOMContentLoaded', function () {
    // CHART.JS DOUGHNUT INITIALIZATION
    const ctx = document.getElementById('riskDistributionChart').getContext('2d');
    
    // Check current theme colors for Chart.js
    const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
    const textLabelColor = isDark ? '#94a3b8' : '#475569';

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Low Risk', 'Medium Risk', 'High Risk'],
            datasets: [{
                data: [{{ $lowRisk }}, {{ $mediumRisk }}, {{ $highRisk }}],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 3,
                borderColor: isDark ? '#111827' : '#ffffff',
                hoverOffset: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        font: { family: 'Plus Jakarta Sans', weight: '700', size: 12 },
                        color: textLabelColor,
                        padding: 16,
                        usePointStyle: true,
                        pointStyle: 'circle'
                    }
                }
            },
            cutout: '72%'
        }
    });

    // LEAFLET MAP INITIALIZATION
    const mapElement = document.getElementById('map') || document.getElementById('riskMap');
    if (mapElement && typeof L !== 'undefined') {
        leafletMap = L.map(mapElement, { scrollWheelZoom: false }).setView([20, 0], 2);

        // Standard Reliable OpenStreetMap Tile Layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leafletMap);

        // Force Leaflet map to recalculate dimensions after rendering
        setTimeout(function() {
            leafletMap.invalidateSize();
        }, 300);

        // Render all 48 Monitored Country Markers
        const countries = @json($allCountries);

        countries.forEach(function (country) {
            if (country.latitude === null || country.longitude === null) return;

            let riskLevel = country.risk_assessment?.risk_level ?? 'Low';
            let riskScore = country.risk_assessment?.risk_score ?? 0;

            let color = '#10b981'; // Emerald for Low Risk
            if (riskLevel === 'High') {
                color = '#ef4444'; // Crimson for High Risk
            } else if (riskLevel === 'Medium') {
                color = '#f59e0b'; // Amber for Medium Risk
            }

            let circle = L.circleMarker([country.latitude, country.longitude], {
                radius: riskLevel === 'High' ? 11 : 8,
                fillColor: color,
                color: '#ffffff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.9
            });

            // Store metadata on marker for filtering
            circle.riskLevel = riskLevel.toLowerCase();
            circle.markerType = 'country';

            const popupContent = `
                <div class="custom-leaflet-popup">
                    <div class="popup-header">
                        <div class="popup-title">🌐 ${country.name}</div>
                        <span class="badge-risk badge-risk-${riskLevel.toLowerCase()}">${riskLevel} Risk</span>
                    </div>
                    <div class="popup-stat-grid">
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Region</span>
                            <span class="popup-stat-val">${country.region ?? '-'}</span>
                        </div>
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Risk Score</span>
                            <span class="popup-stat-val">${riskScore} / 100</span>
                        </div>
                    </div>
                    <a href="/countries/${country.id}">
                        <button class="popup-btn">View Country Intelligence ➔</button>
                    </a>
                </div>
            `;

            circle.bindPopup(popupContent);
            circle.addTo(leafletMap);
            countryMarkers.push(circle);
        });

        // Render Port Markers for Overlay Layer
        const ports = @json($allPorts ?? []);
        ports.forEach(function (port) {
            if (port.latitude === null || port.longitude === null) return;

            let statusColor = '#06b6d4'; // Cyan for Ports
            if (port.status === 'Closed') {
                statusColor = '#ef4444';
            } else if (port.status === 'Delayed') {
                statusColor = '#f59e0b';
            }

            let portCircle = L.circleMarker([port.latitude, port.longitude], {
                radius: 9,
                fillColor: statusColor,
                color: '#ffffff',
                weight: 2.5,
                opacity: 1,
                fillOpacity: 0.85
            });

            portCircle.riskLevel = (port.risk_level ?? 'low').toLowerCase();
            portCircle.markerType = 'port';

            const portPopup = `
                <div class="custom-leaflet-popup">
                    <div class="popup-header">
                        <div class="popup-title">⚓ ${port.port_name}</div>
                        <span class="badge-risk badge-risk-${(port.risk_level ?? 'low').toLowerCase()}">${port.status}</span>
                    </div>
                    <div class="popup-stat-grid">
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Country / City</span>
                            <span class="popup-stat-val">${port.country} (${port.city ?? '-'})</span>
                        </div>
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Delay Hours</span>
                            <span class="popup-stat-val">${port.delay_hours} hrs</span>
                        </div>
                    </div>
                    <a href="/ports">
                        <button class="popup-btn">Open Port Directory ➔</button>
                    </a>
                </div>
            `;

            portCircle.bindPopup(portPopup);
            portMarkers.push(portCircle);
        });
    }
});

// Interactive Dynamic Map Filter Function
function filterMap(category) {
    if (!leafletMap) return;

    category = category.toLowerCase();

    // Update active button state
    document.querySelectorAll('.map-filter-btn').forEach(btn => {
        if (btn.getAttribute('data-filter') === category) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    if (category === 'all') {
        // Show all 48 country markers, hide ports
        countryMarkers.forEach(m => leafletMap.addLayer(m));
        portMarkers.forEach(m => leafletMap.removeLayer(m));
    } else if (category === 'ports') {
        // Hide countries, show all port markers
        countryMarkers.forEach(m => leafletMap.removeLayer(m));
        portMarkers.forEach(m => leafletMap.addLayer(m));
    } else if (['high', 'medium', 'low'].includes(category)) {
        // Filter countries by risk level (high / medium / low)
        countryMarkers.forEach(m => {
            if (m.riskLevel === category) {
                leafletMap.addLayer(m);
            } else {
                leafletMap.removeLayer(m);
            }
        });
        portMarkers.forEach(m => leafletMap.removeLayer(m));
    }

    setTimeout(function() {
        leafletMap.invalidateSize();
    }, 100);
}
</script>

@endsection