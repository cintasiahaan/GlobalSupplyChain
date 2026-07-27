@extends('layouts.app')

@section('title', 'Port Location & Marine Monitoring')

@section('content')

<!-- Leaflet CSS & JS CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<!-- HEADER BANNER -->
<div class="glass-card mb-4" style="padding: 1.5rem 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.25rem;">
                ⚓ World Port Location & Maritime Dashboard
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">
                Pemantauan geotagging pelabuhan internasional, kemacetan (*congestion*), penundaan, & kondisi gelombang laut (Open-Meteo Marine).
            </p>
        </div>
        @if($liveMarineData)
            <div class="glass-card" style="padding: 0.75rem 1.25rem; border-color: var(--border-highlight);">
                <div style="font-size: 0.7rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase;">🌊 Live Marine Advisory</div>
                <div style="font-weight: 800; font-size: 0.95rem; color: var(--text-main);">{{ $liveMarineData['sea_condition'] }}</div>
                <div style="font-size: 0.75rem; color: var(--text-subtle);">Wave Height: {{ $liveMarineData['wave_height'] }} | Swell: {{ $liveMarineData['swell_height'] }}</div>
            </div>
        @endif
    </div>
</div>

<!-- STAT METRIC CARDS -->
<div class="metrics-grid">
    <div class="glass-card metric-card">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Total Monitored Ports</span>
            <div class="metric-icon-wrapper">⚓</div>
        </div>
        <div class="metric-number">{{ $ports->count() }}</div>
        <div class="metric-subtext">Pelabuhan aktif terpantau</div>
    </div>

    <div class="glass-card metric-card accent-low">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Operational</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-emerald-main);">🟢</div>
        </div>
        <div class="metric-number" style="color: var(--risk-emerald-text);">
            {{ $ports->where('status', 'Operational')->count() }}
        </div>
        <div class="metric-subtext">Beroperasi normal</div>
    </div>

    <div class="glass-card metric-card accent-medium">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Delayed & Congested</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-amber-main);">🟡</div>
        </div>
        <div class="metric-number" style="color: var(--risk-amber-text);">
            {{ $ports->where('status', 'Delayed')->count() }}
        </div>
        <div class="metric-subtext">Mengalami keterlambatan</div>
    </div>

    <div class="glass-card metric-card accent-high">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Closed / High Risk</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-crimson-main);">🔴</div>
        </div>
        <div class="metric-number" style="color: var(--risk-crimson-text);">
            {{ $ports->where('status', 'Closed')->count() + $ports->where('risk_level', 'High')->count() }}
        </div>
        <div class="metric-subtext">Penutupan / risiko tinggi</div>
    </div>
</div>

<!-- INTERACTIVE LEAFLET PORT MAP CONTAINER -->
<div class="glass-card map-card-container mb-4">
    <div class="map-header-bar">
        <div>
            <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0; color: var(--text-main);">
                🗺️ Interactive Port Geotagging Map (World Port Index)
            </h3>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin: 0;">
                Klik marker pelabuhan untuk melihat detail keterlambatan (*delay hours*), *throughput*, & tingkat kemacetan.
            </p>
        </div>
        <div style="display: flex; gap: 0.5rem; align-items: center;">
            <span class="badge-risk badge-risk-low">🟢 Operational</span>
            <span class="badge-risk badge-risk-medium">🟡 Delayed</span>
            <span class="badge-risk badge-risk-high">🔴 Closed / High Risk</span>
        </div>
    </div>

    <div class="map-wrapper-inner">
        <div id="portMap" style="width: 100%; height: 500px; position: relative; z-index: 1;"></div>
    </div>
</div>

<!-- SEARCH & FILTER FORM -->
<div class="glass-card mb-4" style="padding: 1.25rem 1.5rem;">
    <form method="GET" action="{{ route('ports.index') }}" style="display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: center;">
        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.35rem;">Cari Pelabuhan / Kota</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama pelabuhan (misal: Shanghai, Singapore, Tanjung Priok)..." class="form-control" style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);">
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.35rem;">Filter Negara</label>
            <input type="text" name="country" value="{{ request('country') }}" placeholder="Nama Negara..." class="form-control" style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);">
        </div>

        <div>
            <label style="display: block; font-size: 0.75rem; font-weight: 700; color: var(--text-muted); text-transform: uppercase; margin-bottom: 0.35rem;">Status Operasional</label>
            <select name="status" style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);">
                <option value="">-- Semua Status --</option>
                <option value="Operational" {{ request('status') === 'Operational' ? 'selected' : '' }}>Operational</option>
                <option value="Delayed" {{ request('status') === 'Delayed' ? 'selected' : '' }}>Delayed</option>
                <option value="Closed" {{ request('status') === 'Closed' ? 'selected' : '' }}>Closed</option>
            </select>
        </div>

        <div style="padding-top: 1.25rem;">
            <button type="submit" class="btn-enterprise btn-enterprise-primary" style="padding: 0.65rem 1.25rem;">
                🔍 Cari Pelabuhan
            </button>
        </div>
    </form>
</div>

<!-- PORT DIRECTORY TABLE -->
<div class="glass-card custom-table-card mb-4">
    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border-color);">
        <h3 style="font-size: 1.1rem; font-weight: 800; margin: 0;">
            ⚓ Daftar Pelabuhan Internasional
        </h3>
    </div>

    <div style="overflow-x: auto;">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Pelabuhan</th>
                    <th>Negara / Kota</th>
                    <th>Status</th>
                    <th>Congestion</th>
                    <th>Delay (Jam)</th>
                    <th>Annual Throughput</th>
                    <th>Risk Level</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ports as $port)
                    <tr>
                        <td><strong>{{ $loop->iteration }}</strong></td>
                        <td>
                            <strong style="color: var(--text-main);">⚓ {{ $port->port_name }}</strong>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ \Illuminate\Support\Str::limit($port->description, 50) }}</div>
                        </td>
                        <td>
                            <strong>{{ $port->country }}</strong>
                            <div style="font-size: 0.75rem; color: var(--text-subtle);">{{ $port->city ?? '-' }}</div>
                        </td>
                        <td>
                            @if($port->status === 'Operational')
                                <span class="badge-risk badge-risk-low">🟢 Operational</span>
                            @elseif($port->status === 'Delayed')
                                <span class="badge-risk badge-risk-medium">🟡 Delayed</span>
                            @else
                                <span class="badge-risk badge-risk-high">🔴 Closed</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-risk badge-risk-{{ strtolower($port->congestion_level) }}">
                                {{ $port->congestion_level }}
                            </span>
                        </td>
                        <td>
                            <strong style="font-size: 0.95rem; color: {{ $port->delay_hours > 20 ? 'var(--risk-crimson-main)' : 'var(--text-main)' }};">
                                {{ $port->delay_hours }} hrs
                            </strong>
                        </td>
                        <td>
                            {{ $port->throughput ? number_format($port->throughput) . ' TEU' : '-' }}
                        </td>
                        <td>
                            <span class="badge-risk badge-risk-{{ strtolower($port->risk_level) }}">
                                {{ $port->risk_level }} Risk
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Tidak ada data pelabuhan yang cocok dengan kriteria pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- LEAFLET PORT MAP SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mapElement = document.getElementById('portMap');
    if (mapElement && typeof L !== 'undefined') {
        const portMap = L.map(mapElement, { scrollWheelZoom: false }).setView([15, 20], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 18,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(portMap);

        setTimeout(function() {
            portMap.invalidateSize();
        }, 300);

        const ports = @json($allPorts ?? $ports);

        ports.forEach(function (port) {
            if (port.latitude === null || port.longitude === null) return;

            let statusColor = '#10b981'; // Green Operational
            if (port.status === 'Delayed') {
                statusColor = '#f59e0b'; // Yellow Delayed
            } else if (port.status === 'Closed' || port.risk_level === 'High') {
                statusColor = '#ef4444'; // Red Closed/High Risk
            }

            let marker = L.circleMarker([port.latitude, port.longitude], {
                radius: port.status === 'Closed' ? 12 : 9,
                fillColor: statusColor,
                color: '#ffffff',
                weight: 2,
                opacity: 1,
                fillOpacity: 0.85
            }).addTo(portMap);

            const popupHtml = `
                <div class="custom-leaflet-popup">
                    <div class="popup-header">
                        <div class="popup-title">⚓ ${port.port_name}</div>
                        <span class="badge-risk badge-risk-${(port.risk_level ?? 'low').toLowerCase()}">${port.risk_level ?? 'Low'} Risk</span>
                    </div>
                    <div class="popup-stat-grid">
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Country / City</span>
                            <span class="popup-stat-val">${port.country} (${port.city ?? '-'})</span>
                        </div>
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Status</span>
                            <span class="popup-stat-val">${port.status}</span>
                        </div>
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Congestion</span>
                            <span class="popup-stat-val">${port.congestion_level}</span>
                        </div>
                        <div class="popup-stat-item">
                            <span class="popup-stat-label">Delay</span>
                            <span class="popup-stat-val">${port.delay_hours} Hours</span>
                        </div>
                    </div>
                    <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem;">
                        ${port.description ?? ''}
                    </div>
                </div>
            `;

            marker.bindPopup(popupHtml);
        });
    }
});
</script>

@endsection