@extends('layouts.app')

@section('title', 'Kelola Artikel Analisis')

@section('content')

<div class="glass-card mb-4" style="padding: 1.5rem 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.25rem;">
                📝 Kelola Artikel & Publikasi Analisis Logistik
            </h2>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">
                Manajemen publikasi artikel riset & insight rantai pasok global.
            </p>
        </div>
        <a href="{{ route('admin.articles.create') }}" class="btn-enterprise btn-enterprise-primary">
            ➕ Buat Artikel Baru
        </a>
    </div>
</div>

<div class="glass-card custom-table-card">
    <div style="overflow-x: auto;">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Judul Artikel</th>
                    <th>Kategori</th>
                    <th>Penulis</th>
                    <th>Tanggal Terbit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                    <tr>
                        <td><strong>{{ $loop->iteration }}</strong></td>
                        <td>
                            <strong style="color: var(--text-main);">{{ $article->title }}</strong>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ \Illuminate\Support\Str::limit($article->summary, 60) }}</div>
                        </td>
                        <td><span class="badge-risk badge-risk-low">{{ $article->category }}</span></td>
                        <td>{{ $article->author }}</td>
                        <td>{{ $article->published_at ? $article->published_at->format('d M Y') : '-' }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Hapus artikel ini?');" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-enterprise" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239,68,68,0.3); padding: 0.35rem 0.75rem; font-size: 0.75rem;">
                                    🗑️ Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 2rem; color: var(--text-muted);">
                            Belum ada artikel analisis yang diterbitkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
