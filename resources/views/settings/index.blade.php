@extends('layouts.app')

@section('title', 'System Settings')

@section('content')

<style>
    .settings-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        gap: 24px;
    }

    .settings-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 0;
        border-bottom: 1px solid var(--border-color);
    }

    .settings-item:last-child {
        border-bottom: none;
    }

    .settings-label {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-dark);
    }

    .settings-desc {
        font-size: 12px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* Switch toggle styling */
    .switch {
        position: relative;
        display: inline-block;
        width: 48px;
        height: 24px;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 24px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: var(--primary);
    }

    input:checked + .slider:before {
        transform: translateX(24px);
    }
</style>

<div class="page-header">
    <h1>⚙️ System & Alert Settings</h1>
    <p>Konfigurasi preferensi sistem monitoring, notifikasi otomatis, dan parameter live API.</p>
</div>

<div class="settings-grid">
    <!-- NOTIFICATION SETTINGS -->
    <div class="table-container">
        <h2>🔔 Alert & Notifications</h2>

        <div class="settings-item">
            <div>
                <div class="settings-label">Dashboard Real-Time Alerts</div>
                <div class="settings-desc">Tampilkan notifikasi pop-up ketika terjadi gangguan kritis.</div>
            </div>
            <label class="switch">
                <input type="checkbox" checked onchange="saveSetting('Dashboard Alerts')">
                <span class="slider"></span>
            </label>
        </div>

        <div class="settings-item">
            <div>
                <div class="settings-label">High-Risk Email Digest</div>
                <div class="settings-desc">Kirimkan ringkasan email harian untuk negara berisiko tinggi.</div>
            </div>
            <label class="switch">
                <input type="checkbox" checked onchange="saveSetting('Email Digest')">
                <span class="slider"></span>
            </label>
        </div>

        <div class="settings-item">
            <div>
                <div class="settings-label">Port Congestion Warning</div>
                <div class="settings-desc">Aktifkan alarm jika delay pelabuhan melebihi 24 jam.</div>
            </div>
            <label class="switch">
                <input type="checkbox" checked onchange="saveSetting('Port Congestion Warning')">
                <span class="slider"></span>
            </label>
        </div>
    </div>

    <!-- API & DATA UPDATES -->
    <div class="table-container">
        <h2>🌐 Data Synchronization</h2>

        <div class="settings-item">
            <div>
                <div class="settings-label">Auto Weather Refresh (Open-Meteo)</div>
                <div class="settings-desc">Singkronisasi otomatis data cuaca setiap 6 jam.</div>
            </div>
            <label class="switch">
                <input type="checkbox" checked onchange="saveSetting('Weather Auto Sync')">
                <span class="slider"></span>
            </label>
        </div>

        <div class="settings-item">
            <div>
                <div class="settings-label">Live Forex Rate Updating</div>
                <div class="settings-desc">Singkronisasi kurs valuta asing terhadap Rupiah harian.</div>
            </div>
            <label class="switch">
                <input type="checkbox" checked onchange="saveSetting('Forex Rate Sync')">
                <span class="slider"></span>
            </label>
        </div>

        <div class="settings-item">
            <div>
                <div class="settings-label">Interactive Map Clustering</div>
                <div class="settings-desc">Kelompokkan marker peta jika zoom out terlalu jauh.</div>
            </div>
            <label class="switch">
                <input type="checkbox" onchange="saveSetting('Map Clustering')">
                <span class="slider"></span>
            </label>
        </div>
    </div>
</div>

<div id="toast" style="display:none; position:fixed; bottom:30px; right:30px; background:#10b981; color:white; padding:12px 20px; border-radius:12px; font-weight:700; box-shadow:var(--shadow-lg); z-index:9999;">
    ✅ Pengaturan berhasil diperbarui!
</div>

<script>
function saveSetting(name) {
    const toast = document.getElementById('toast');
    toast.style.display = 'block';
    toast.innerText = '✅ Preferensi "' + name + '" berhasil disimpan!';
    setTimeout(() => {
        toast.style.display = 'none';
    }, 2500);
}
</script>

@endsection