@extends('layouts.app')

@section('title', 'User Login Activity Log')

@section('content')

<div class="glass-card mb-4" style="padding: 1.5rem 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.25rem;">
                🔐 User Login Activity Monitoring
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">
                Pemantauan real-time aktivitas login pengguna terdaftar (User) ke sistem.
            </p>
        </div>

        <div style="display: flex; gap: 1rem;">
            <div class="glass-card" style="padding: 0.6rem 1.25rem; text-align: center;">
                <div style="font-size: 1.2rem; font-weight: 800; color: var(--primary);">{{ $totalLogins }}</div>
                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">Total Sesi Login User</div>
            </div>
            <div class="glass-card" style="padding: 0.6rem 1.25rem; text-align: center;">
                <div style="font-size: 1.2rem; font-weight: 800; color: var(--risk-emerald-main);">{{ $uniqueUsersCount }}</div>
                <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 700; text-transform: uppercase;">User Aktif</div>
            </div>
        </div>
    </div>
</div>

<!-- FILTER BAR -->
<div class="glass-card mb-4" style="padding: 1rem 1.5rem;">
    <form method="GET" action="{{ route('admin.user-logs.index') }}" style="display: flex; gap: 1rem; align-items: center; flex-wrap: wrap;">
        <div style="flex-grow: 1; min-width: 240px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama user, email, atau IP address..." class="form-control" style="width: 100%; padding: 0.6rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);">
        </div>

        <button type="submit" class="btn-enterprise btn-enterprise-primary" style="padding: 0.6rem 1.25rem;">
            🔍 Filter Log
        </button>

        @if(request()->filled('search'))
            <a href="{{ route('admin.user-logs.index') }}" class="btn-enterprise btn-enterprise-outline" style="padding: 0.6rem 1rem;">
                Reset
            </a>
        @endif
    </form>
</div>

<!-- USER LOGS TABLE -->
<div class="glass-card custom-table-card">
    <div style="overflow-x: auto;">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>IP Address</th>
                    <th>Perangkat / Browser (User Agent)</th>
                    <th>Waktu Login</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td><strong>{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</strong></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.6rem;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), #6366f1); color: white; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 0.8rem;">
                                    {{ strtoupper(substr($log->user_name, 0, 1)) }}
                                </div>
                                <strong style="color: var(--text-main);">{{ $log->user_name }}</strong>
                            </div>
                        </td>
                        <td>{{ $log->email }}</td>
                        <td>
                            @if($log->role === 'admin')
                                <span class="badge-risk badge-risk-high" style="padding: 0.2rem 0.5rem; font-size: 0.65rem;">🛠️ Admin</span>
                            @else
                                <span class="badge-risk badge-risk-low" style="padding: 0.2rem 0.5rem; font-size: 0.65rem;">👤 User</span>
                            @endif
                        </td>
                        <td>
                            <code style="background: var(--bg-surface-elevated); padding: 0.2rem 0.5rem; border-radius: 4px; font-size: 0.8rem;">
                                {{ $log->ip_address ?? '127.0.0.1' }}
                            </code>
                        </td>
                        <td>
                            <span style="font-size: 0.75rem; color: var(--text-muted);" title="{{ $log->user_agent }}">
                                {{ \Illuminate\Support\Str::limit($log->user_agent ?? 'Browser Chrome/Edge/Safari', 45) }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight: 700; font-size: 0.85rem;">{{ $log->logged_in_at ? $log->logged_in_at->format('d M Y, H:i:s') : '-' }}</div>
                            <div style="font-size: 0.7rem; color: var(--text-subtle);">{{ $log->logged_in_at ? $log->logged_in_at->diffForHumans() : '' }}</div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Belum ada riwayat log aktivitas login yang tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($logs->hasPages())
        <div style="padding: 1rem 1.5rem; border-top: 1px solid var(--border-color);">
            {{ $logs->links() }}
        </div>
    @endif
</div>

@endsection
