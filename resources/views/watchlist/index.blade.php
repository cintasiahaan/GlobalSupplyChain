@extends('layouts.app')

@section('title', 'My Watchlist')

@section('content')

<div class="page-header">
    <h1>⭐ My Watchlist</h1>
    <p>Daftar negara yang masuk dalam perhatian khusus dan pemantauan prioritasi Anda.</p>
</div>

<div class="cards">
    <div class="card">
        <div class="card-title">⭐ Watched Countries</div>
        <div class="card-number" style="color: #f59e0b;">{{ $watchlists->count() }}</div>
        <p style="font-size: 12px; color: var(--text-muted); margin-top: 4px;">Negara yang Anda tambahkan ke watchlist</p>
    </div>
</div>

<div class="table-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>⭐ Daftar Negara Terpantau</h2>
        <a href="{{ route('countries.index') }}" class="btn-ui btn-ui-secondary" style="font-size: 12px;">+ Tambah Negara Lain</a>
    </div>

    <div style="overflow-x: auto;">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Negara</th>
                    <th>Region</th>
                    <th>Risk Level Status</th>
                    <th>Risk Score Index</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($watchlists as $watchlist)
                    <tr>
                        <td><strong>{{ $loop->iteration }}</strong></td>
                        <td>
                            @if($watchlist->country)
                                <a href="{{ route('countries.show', $watchlist->country) }}" style="color: var(--text-dark); font-weight: 700; text-decoration: none;">
                                    🌍 {{ $watchlist->country->name }}
                                </a>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $watchlist->country->region ?? '-' }}</td>
                        <td>
                            @php
                                $level = $watchlist->country->riskAssessment->risk_level ?? 'Low';
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
                                {{ $watchlist->country->riskAssessment->risk_score ?? '-' }}
                            </strong>
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                @if($watchlist->country)
                                    <a href="{{ route('countries.show', $watchlist->country) }}" class="btn-ui btn-ui-primary" style="padding: 6px 12px; font-size: 12px;">
                                        👁️ Profile
                                    </a>
                                @endif

                                <form method="POST" action="{{ route('watchlist.destroy', $watchlist) }}" style="margin:0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-ui btn-ui-danger" style="padding: 6px 12px; font-size: 12px;">
                                        ❌ Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: var(--text-muted);">
                            <div style="font-size: 36px; margin-bottom: 8px;">⭐</div>
                            Belum ada negara yang ditambahkan ke Watchlist Anda.<br>
                            <a href="{{ route('countries.index') }}" style="color: var(--primary); font-weight: 700; text-decoration: none; display: inline-block; margin-top: 8px;">Jelajahi Country Monitoring ➔</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection