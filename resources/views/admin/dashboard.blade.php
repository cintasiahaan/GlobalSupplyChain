@extends('layouts.app')

@section('title', 'Admin Control Panel')

@section('content')

<div class="glass-card mb-4" style="padding: 1.5rem 2rem;">
    <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.25rem;">
        🛠️ Admin Control Panel
    </h2>
    <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">
        Selamat datang, <strong>{{ auth()->user()->name }}</strong>. Panel pusat manajemen dan pemantauan sistem.
    </p>
</div>

<div class="metrics-grid">
    <div class="glass-card metric-card">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Registered Users</span>
            <div class="metric-icon-wrapper">👥</div>
        </div>
        <div class="metric-number">{{ \App\Models\User::count() }}</div>
        <div class="metric-subtext">Pengguna terdaftar</div>
        <a href="{{ route('admin.user-logs.index') }}" class="btn-enterprise btn-enterprise-primary" style="margin-top: 1rem; width: 100%; font-size: 0.75rem;">
            🔐 User Login Activity Logs
        </a>
    </div>

    <div class="glass-card metric-card accent-medium">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Risk Assessments</span>
            <div class="metric-icon-wrapper" style="color: var(--primary);">📋</div>
        </div>
        <div class="metric-number">{{ \App\Models\RiskAssessment::count() }}</div>
        <div class="metric-subtext">Evaluasi risiko aktif</div>
        <a href="{{ route('admin.risk-assessments.index') }}" class="btn-enterprise btn-enterprise-primary" style="margin-top: 1rem; width: 100%; font-size: 0.75rem;">
            📋 Risk Assessment Management
        </a>
    </div>

    <div class="glass-card metric-card accent-low">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Published Articles</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-emerald-main);">📝</div>
        </div>
        <div class="metric-number">{{ \App\Models\Article::count() }}</div>
        <div class="metric-subtext">Artikel riset & analisis</div>
        <a href="{{ route('admin.articles.index') }}" class="btn-enterprise btn-enterprise-primary" style="margin-top: 1rem; width: 100%; font-size: 0.75rem;">
            📝 Kelola Artikel
        </a>
    </div>

    <div class="glass-card metric-card accent-high">
        <div class="metric-card-accent-bar"></div>
        <div class="metric-header">
            <span class="metric-label">Total Monitored Ports</span>
            <div class="metric-icon-wrapper" style="color: var(--risk-crimson-main);">⚓</div>
        </div>
        <div class="metric-number">{{ \App\Models\Port::count() }}</div>
        <div class="metric-subtext">Dataset pelabuhan dunia</div>
        <a href="{{ route('ports.index') }}" class="btn-enterprise btn-enterprise-outline" style="margin-top: 1rem; width: 100%; font-size: 0.75rem;">
            ⚓ Port Directory
        </a>
    </div>
</div>

<div class="glass-card mb-4" style="padding: 1.5rem;">
    <h3 style="font-size: 1.1rem; font-weight: 800; margin-bottom: 0.5rem; color: var(--text-main);">
        ⚡ Quick Administrative Tools
    </h3>
    <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 1.25rem;">
        Akses cepat ke modul kelola data dan pemantauan sistem:
    </p>

    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.user-logs.index') }}" class="btn-enterprise btn-enterprise-primary">
            🔐 User Login Activity Logs
        </a>
        <a href="{{ route('admin.risk-assessments.index') }}" class="btn-enterprise btn-enterprise-primary">
            📋 Management Risk Assessments
        </a>
        <a href="{{ route('admin.articles.index') }}" class="btn-enterprise btn-enterprise-primary">
            📝 Kelola Artikel Analisis
        </a>
        <a href="{{ route('countries.compare') }}" class="btn-enterprise btn-enterprise-outline">
            ⚔️ Country Comparison Engine
        </a>
        <a href="{{ route('admin.settings.index') }}" class="btn-enterprise btn-enterprise-outline">
            ⚙️ System Settings
        </a>
    </div>
</div>

@endsection