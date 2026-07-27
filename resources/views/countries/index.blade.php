@extends('layouts.app')

@section('title', 'Country Monitoring')

@section('content')

<style>
    .filter-card {
        background: var(--card-bg);
        border-radius: 16px;
        padding: 20px 24px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        margin-bottom: 24px;
    }

    .filter-form {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 180px;
    }

    .filter-group label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
        text-transform: uppercase;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .filter-control {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid var(--border-color);
        border-radius: 10px;
        font-size: 14px;
        font-family: inherit;
        background: #f8fafc;
        color: var(--text-dark);
        transition: all 0.2s ease;
    }

    .filter-control:focus {
        outline: none;
        border-color: var(--primary);
        background: white;
    }

    .filter-actions {
        display: flex;
        gap: 10px;
    }

    .pagination-wrapper {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
</style>

<div class="page-header">
    <h1>🌍 Country Risk Monitoring</h1>
    <p>Pantau status risiko dan indeks stabilitas negara pemasok dalam Global Supply Chain.</p>
</div>

<!-- FILTER & SEARCH CARD -->
<div class="filter-card">
    <form method="GET" action="{{ route('countries.index') }}" class="filter-form">
        <div class="filter-group">
            <label for="search">🔍 Cari Nama Negara</label>
            <input
                type="text"
                id="search"
                name="search"
                class="filter-control"
                placeholder="misal: Indonesia, Japan..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="filter-group">
            <label for="region">🌐 Region / Wilayah</label>
            <select id="region" name="region" class="filter-control">
                <option value="">Semua Region</option>
                @foreach($regions as $region)
                    <option value="{{ $region }}" {{ request('region') == $region ? 'selected' : '' }}>
                        {{ $region }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="filter-group">
            <label for="risk_level">⚠️ Risk Level</label>
            <select id="risk_level" name="risk_level" class="filter-control">
                <option value="">Semua Risk Level</option>
                <option value="High" {{ request('risk_level') == 'High' ? 'selected' : '' }}>🔴 High Risk</option>
                <option value="Medium" {{ request('risk_level') == 'Medium' ? 'selected' : '' }}>🟡 Medium Risk</option>
                <option value="Low" {{ request('risk_level') == 'Low' ? 'selected' : '' }}>🟢 Low Risk</option>
            </select>
        </div>

        <div class="filter-actions">
            <button type="submit" class="btn-ui btn-ui-primary">
                Filter Data
            </button>
            <a href="{{ route('countries.index') }}" class="btn-ui btn-ui-secondary">
                Reset
            </a>
        </div>
    </form>
</div>

<!-- SUMMARY CARDS -->
<div class="cards">
    <div class="card">
        <div class="card-title">🌍 Total Hasil Filter</div>
        <div class="card-number">{{ $countries->total() }}</div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Negara terdaftar di halaman ini</p>
    </div>

    <div class="card">
        <div class="card-title">🔴 High Risk</div>
        <div class="card-number" style="color: #dc2626;">
            {{ $countries->filter(fn($c) => ($c->riskAssessment->risk_level ?? '') === 'High')->count() }}
        </div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Dalam halaman aktif</p>
    </div>

    <div class="card">
        <div class="card-title">🟡 Medium Risk</div>
        <div class="card-number" style="color: #d97706;">
            {{ $countries->filter(fn($c) => ($c->riskAssessment->risk_level ?? '') === 'Medium')->count() }}
        </div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Dalam halaman aktif</p>
    </div>

    <div class="card">
        <div class="card-title">🟢 Low Risk</div>
        <div class="card-number" style="color: #16a34a;">
            {{ $countries->filter(fn($c) => ($c->riskAssessment->risk_level ?? 'Low') === 'Low')->count() }}
        </div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Dalam halaman aktif</p>
    </div>
</div>

<!-- COUNTRY TABLE -->
<div class="table-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; flex-wrap: wrap; gap: 12px;">
        <h2>Daftar Monitoring Negara</h2>
        <a href="{{ route('watchlist.index') }}" class="btn-ui btn-ui-warning">
            ⭐ My Watchlist
        </a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Negara</th>
                    <th>Region</th>
                    <th>Risk Level</th>
                    <th>Risk Score Index</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($countries as $country)
                    <tr>
                        <td><strong>{{ $loop->iteration + ($countries->currentPage() - 1) * $countries->perPage() }}</strong></td>
                        <td>
                            <a href="{{ route('countries.show', $country) }}" style="color: var(--text-dark); font-weight: 700; text-decoration: none;">
                                🌍 {{ $country->name }}
                            </a>
                        </td>
                        <td>{{ $country->region ?? '-' }}</td>
                        <td>
                            @php
                                $level = $country->riskAssessment->risk_level ?? 'Low';
                            @endphp
                            @if($level === 'High')
                                <span class="badge-risk badge-risk-high">🔴 High</span>
                            @elseif($level === 'Medium')
                                <span class="badge-risk badge-risk-medium">🟡 Medium</span>
                            @else
                                <span class="badge-risk badge-risk-low">🟢 Low</span>
                            @endif
                        </td>
                        <td>
                            <strong style="font-size: 15px;">
                                {{ $country->riskAssessment->risk_score ?? 0 }}
                            </strong> / 100
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                <a href="{{ route('countries.show', $country) }}" class="btn-ui btn-ui-primary" style="padding: 6px 12px; font-size: 12px;">
                                    👁️ Detail Profile
                                </a>

                                @auth
                                    <form method="POST" action="{{ route('watchlist.store', $country) }}" style="margin:0;">
                                        @csrf
                                        <button type="submit" class="btn-ui btn-ui-warning" style="padding: 6px 12px; font-size: 12px;">
                                            ⭐ Add Watchlist
                                        </button>
                                    </form>

                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('admin.risk-assessments.create', $country) }}" class="btn-ui btn-ui-secondary" style="padding: 6px 12px; font-size: 12px;">
                                            ✏️ Edit Assessment
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <div style="font-size: 36px; margin-bottom: 8px;">🌍</div>
                            Tidak ada data negara yang sesuai dengan filter pencarian.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="pagination-wrapper">
        {{ $countries->links() }}
    </div>
</div>

@endsection