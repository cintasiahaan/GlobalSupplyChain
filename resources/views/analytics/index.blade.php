@extends('layouts.app')

@section('title', 'Supply Chain Analytics')

@section('content')

<style>
    .analytics-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px;
        margin-bottom: 28px;
    }

    .chart-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    .chart-card h2 {
        font-size: 17px;
        font-weight: 800;
        margin-bottom: 16px;
        color: var(--text-dark);
    }

    .chart-container-box {
        position: relative;
        height: 280px;
    }

    @media (max-width: 900px) {
        .analytics-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="page-header">
    <h1>📈 Global Supply Chain Analytics</h1>
    <p>Analisis komprehensif indikator risiko rantai pasok global dan laporan stabilitas maritim.</p>
</div>

<!-- SUMMARY CARDS -->
<div class="cards">
    <div class="card">
        <div class="card-title">🌍 Total Countries</div>
        <div class="card-number">{{ $totalCountries }}</div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Negara dalam pemantauan</p>
    </div>

    <div class="card">
        <div class="card-title">📋 Risk Assessments</div>
        <div class="card-number">{{ $totalRiskAssessments }}</div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Penilaian risiko terverifikasi</p>
    </div>

    <div class="card">
        <div class="card-title">🔴 High Risk Countries</div>
        <div class="card-number" style="color: #dc2626;">{{ $highRiskCountries }}</div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Negara risiko kritis</p>
    </div>

    <div class="card">
        <div class="card-title">🌦️ Weather Locations</div>
        <div class="card-number">{{ $totalWeather }}</div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Titik pemantauan cuaca</p>
    </div>
</div>

<!-- CHART VISUALIZATIONS -->
<div class="analytics-grid">
    <div class="chart-card">
        <h2>📊 Visualisasi Distribusi Risiko Negara</h2>
        <div class="chart-container-box">
            <canvas id="analyticsDoughnutChart"></canvas>
        </div>
    </div>

    <div class="chart-card">
        <h2>⚓ High Risk & Congestion Indicators</h2>
        <div class="chart-container-box">
            <canvas id="analyticsBarChart"></canvas>
        </div>
    </div>
</div>

<!-- INTELLIGENCE OVERVIEW TABLE -->
<div class="table-container">
    <h2>🌐 Global Risk Intelligence Indicators Summary</h2>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>Domain Monitoring</th>
                    <th>Indikator Risiko Utama</th>
                    <th>Total Terdeteksi</th>
                    <th>Status Sistem</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>💱 Currency Impact</strong></td>
                    <td>High Volatility Exchange Rates</td>
                    <td><strong style="font-size: 16px;">{{ $highCurrencyImpact }}</strong></td>
                    <td>
                        @if($highCurrencyImpact > 0)
                            <span class="badge-risk badge-risk-high">🔴 Attention Required</span>
                        @else
                            <span class="badge-risk badge-risk-low">🟢 Stable</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td><strong>📰 News Intelligence</strong></td>
                    <td>High Disruptive News Alerts</td>
                    <td><strong style="font-size: 16px;">{{ $highImpactNews }}</strong></td>
                    <td>
                        @if($highImpactNews > 0)
                            <span class="badge-risk badge-risk-high">🔴 High Impact Alert</span>
                        @else
                            <span class="badge-risk badge-risk-low">🟢 Normal</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td><strong>⚓ Port Monitoring</strong></td>
                    <td>High Congestion Ports</td>
                    <td><strong style="font-size: 16px;">{{ $highRiskPorts }}</strong></td>
                    <td>
                        @if($highRiskPorts > 0)
                            <span class="badge-risk badge-risk-high">🔴 Congested</span>
                        @else
                            <span class="badge-risk badge-risk-low">🟢 Smooth</span>
                        @endif
                    </td>
                </tr>

                <tr>
                    <td><strong>⏱️ Port Delays</strong></td>
                    <td>Total Delayed Shipping Ports</td>
                    <td><strong style="font-size: 16px;">{{ $delayedPorts }}</strong></td>
                    <td>
                        @if($delayedPorts > 0)
                            <span class="badge-risk badge-risk-medium">🟡 Delayed Operations</span>
                        @else
                            <span class="badge-risk badge-risk-low">🟢 On Schedule</span>
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- CHART JS SCRIPT -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    // DOUGHNUT CHART
    const ctxDoughnut = document.getElementById('analyticsDoughnutChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Low Risk', 'Medium Risk', 'High Risk'],
            datasets: [{
                data: [{{ $lowRiskCountries }}, {{ $mediumRiskCountries }}, {{ $highRiskCountries }}],
                backgroundColor: ['#22c55e', '#f59e0b', '#ef4444'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { position: 'bottom' } }
        }
    });

    // BAR CHART
    const ctxBar = document.getElementById('analyticsBarChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['High Currency', 'High Impact News', 'High Risk Ports', 'Delayed Ports'],
            datasets: [{
                label: 'Jumlah Kasus Terdeteksi',
                data: [{{ $highCurrencyImpact }}, {{ $highImpactNews }}, {{ $highRiskPorts }}, {{ $delayedPorts }}],
                backgroundColor: ['#3b82f6', '#ea580c', '#ef4444', '#f59e0b'],
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 } }
            },
            plugins: { legend: { display: false } }
        }
    });
});
</script>

@endsection