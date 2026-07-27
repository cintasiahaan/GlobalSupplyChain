@extends('layouts.app')

@section('title', 'Currency Impact Intelligence')

@section('content')

<div class="page-header">
    <h1>💱 Currency Impact Intelligence</h1>
    <p>Pantau fluktuasi nilai tukar valuta asing (Forex Volatility) dan kalkulasi dampaknya terhadap biaya impor & transaksi supply chain.</p>
</div>

<div class="table-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2>🌍 Monitoring Nilai Tukar per Negara</h2>
        <span style="font-size: 13px; color: var(--text-muted);">Integrasi live Forex API ke IDR</span>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px;">
        @forelse($countries as $country)
            <div class="card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 17px; font-weight: 800; margin-bottom: 6px;">🌍 {{ $country->name }}</h3>
                    <p style="font-size: 13px; color: var(--text-muted); margin-bottom: 16px;">
                        Region: {{ $country->region ?? '-' }}
                    </p>
                </div>

                <a href="{{ route('currency-impact.show', $country) }}" class="btn-ui btn-ui-primary" style="width: 100%; font-size: 12.5px;">
                    💱 Cek Dampak Valuta ➔
                </a>
            </div>
        @empty
            <div style="grid-column: 1 / -1; padding: 30px; text-align: center; color: var(--text-muted);">
                Belum ada data negara terdaftar.
            </div>
        @endforelse
    </div>
</div>

@endsection