@extends('layouts.app')

@section('title', 'Buat Artikel Analisis Baru')

@section('content')

<div class="glass-card mb-4" style="padding: 1.5rem 2rem;">
    <h2 style="font-size: 1.4rem; font-weight: 800; margin-bottom: 0.25rem;">
        ✍️ Buat Artikel Analisis Logistik Baru
    </h2>
    <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">
        Terbitkan laporan & analisis intelijen risiko rantai pasok untuk pengguna.
    </p>
</div>

<div class="glass-card" style="padding: 2rem;">
    <form method="POST" action="{{ route('admin.articles.store') }}">
        @csrf

        <div class="mb-3" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.35rem; color: var(--text-main);">Judul Artikel</label>
            <input type="text" name="title" required class="form-control" placeholder="Contoh: Analisis Dampak Kemacetan Selat Malaka Terhadap Biaya Impor" style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);">
        </div>

        <div class="mb-3" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.35rem; color: var(--text-main);">Kategori</label>
            <select name="category" style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);">
                <option value="Maritime Logistics">Maritime Logistics</option>
                <option value="Geopolitical Risk">Geopolitical Risk</option>
                <option value="Inflation & Economy">Inflation & Economy</option>
                <option value="Weather Advisory">Weather Advisory</option>
            </select>
        </div>

        <div class="mb-3" style="margin-bottom: 1.25rem;">
            <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.35rem; color: var(--text-main);">Ringkasan Artikel (Summary)</label>
            <textarea name="summary" rows="2" class="form-control" placeholder="Ringkasan singkat artikel..." style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);"></textarea>
        </div>

        <div class="mb-3" style="margin-bottom: 1.5rem;">
            <label style="display: block; font-weight: 700; font-size: 0.85rem; margin-bottom: 0.35rem; color: var(--text-main);">Isi Konten Artikel</label>
            <textarea name="content" rows="8" required class="form-control" placeholder="Tuliskan analisis lengkap..." style="width: 100%; padding: 0.75rem 1rem; border-radius: 8px; border: 1px solid var(--border-color); background: var(--bg-surface-elevated); color: var(--text-main);"></textarea>
        </div>

        <div style="display: flex; gap: 1rem;">
            <button type="submit" class="btn-enterprise btn-enterprise-primary" style="padding: 0.75rem 1.5rem;">
                🚀 Terbitkan Artikel
            </button>
            <a href="{{ route('admin.articles.index') }}" class="btn-enterprise btn-enterprise-outline" style="padding: 0.75rem 1.5rem;">
                Batal
            </a>
        </div>
    </form>
</div>

@endsection
