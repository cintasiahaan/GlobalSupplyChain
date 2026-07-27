@extends('layouts.app')

@section('content')

<style>

    .currency-detail-page {
        padding: 30px;
    }

    .back-btn {
        display: inline-block;
        margin-bottom: 20px;
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .page-title {
        font-size: 30px;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .page-subtitle {
        color: #64748b;
        margin-bottom: 30px;
    }

    .summary-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-card {
        background: white;
        border-radius: 18px;
        padding: 22px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .summary-label {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 10px;
    }

    .summary-value {
        font-size: 23px;
        font-weight: 800;
        color: #0f172a;
    }

    .risk-badge {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 30px;
        font-size: 12px;
        font-weight: 800;
    }

    .risk-high {
        background: #fee2e2;
        color: #dc2626;
    }

    .risk-medium {
        background: #fef3c7;
        color: #d97706;
    }

    .risk-low {
        background: #dcfce7;
        color: #16a34a;
    }

    .risk-unknown {
        background: #f1f5f9;
        color: #64748b;
    }

    .content-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 25px;
    }

    .content-card {
        background: white;
        border-radius: 18px;
        padding: 25px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 8px 25px rgba(0,0,0,.05);
    }

    .content-card h4 {
        font-weight: 700;
        margin-bottom: 15px;
        color: #1e293b;
    }

    .content-card p {
        color: #64748b;
        line-height: 1.7;
    }

    .currency-history-card {
        background: #ffffff;
        border-radius: 20px;
        padding: 28px;
        margin-top: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,.06);
        border: 1px solid #e9ecef;
    }

    .currency-history-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        gap: 20px;
    }

    .currency-history-title {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .currency-history-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: linear-gradient(
            135deg,
            #2563eb,
            #3b82f6
        );
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 23px;
    }

    .currency-history-title h4 {
        margin: 0;
        font-size: 20px;
        font-weight: 700;
        color: #1e293b;
    }

    .currency-history-title p {
        margin: 5px 0 0;
        color: #64748b;
        font-size: 14px;
    }

    .records-badge {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
        padding: 8px 15px;
        border-radius: 30px;
        font-size: 13px;
        font-weight: 700;
        white-space: nowrap;
    }

    .currency-history-table-wrapper {
        overflow-x: auto;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
    }

    .currency-history-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 850px;
    }

    .currency-history-table thead {
        background: #f8fafc;
    }

    .currency-history-table th {
        padding: 15px 18px;
        text-align: left;
        font-size: 12px;
        font-weight: 700;
        text-transform: uppercase;
        color: #64748b;
        border-bottom: 1px solid #e5e7eb;
    }

    .currency-history-table td {
        padding: 16px 18px;
        font-size: 14px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
    }

    .currency-history-table tbody tr:hover {
        background: #f8fafc;
    }

    .currency-code {
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 700;
        padding: 6px 12px;
        border-radius: 8px;
    }

    .exchange-rate {
        font-weight: 700;
        color: #0f172a;
    }

    .change-up {
        color: #dc2626;
        font-weight: 700;
    }

    .change-down {
        color: #16a34a;
        font-weight: 700;
    }

    .change-neutral {
        color: #64748b;
        font-weight: 600;
    }

    .empty-history {
        text-align: center;
        padding: 50px 25px;
        background: #f8fafc;
        border-radius: 15px;
        border: 1px dashed #cbd5e1;
    }

    .empty-history-icon {
        font-size: 45px;
        margin-bottom: 15px;
    }

    .empty-history h5 {
        color: #334155;
        font-weight: 700;
        margin-bottom: 8px;
    }

    .empty-history p {
        color: #64748b;
        margin: 0;
    }

    .error-box {
        background: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        padding: 18px;
        border-radius: 12px;
        margin-bottom: 25px;
    }

    @media(max-width: 900px) {

        .summary-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .content-grid {
            grid-template-columns: 1fr;
        }

    }

    @media(max-width: 600px) {

        .currency-detail-page {
            padding: 15px;
        }

        .summary-grid {
            grid-template-columns: 1fr;
        }

        .currency-history-header {
            flex-direction: column;
            align-items: flex-start;
        }

    }

</style>


<div class="currency-detail-page">

    <a
        href="{{ route('currency-impact.index') }}"
        class="back-btn"
    >
        ← Kembali ke Currency Impact
    </a>


    <h1 class="page-title">

        💱 Currency Impact -
        {{ $country->name }}

    </h1>


    <p class="page-subtitle">

        Analisis nilai tukar dan dampaknya terhadap
        rantai pasok global.

    </p>


    @if($currencyError)

        <div class="error-box">

            ⚠️

            {{ $currencyError }}

        </div>

    @endif


    <div class="summary-grid">

        <div class="summary-card">

            <div class="summary-label">
                Currency
            </div>

            <div class="summary-value">

                {{ $currencyCode ?? '-' }}

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-label">
                Exchange Rate
            </div>

            <div class="summary-value">

                @if($exchangeRate !== null)

                    Rp
                    {{ number_format(
                        $exchangeRate,
                        2,
                        ',',
                        '.'
                    ) }}

                @else

                    -

                @endif

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-label">
                Change
            </div>

            <div class="summary-value">

                @if($changePercent !== null)

                    {{ number_format(
                        $changePercent,
                        2
                    ) }}%

                @else

                    -

                @endif

            </div>

        </div>


        <div class="summary-card">

            <div class="summary-label">
                Currency Risk
            </div>

            <div class="summary-value">

                <span class="risk-badge {{ $riskClass }}">

                    {{ $currencyRisk }}

                </span>

            </div>

        </div>

    </div>


    <div class="content-grid">

        <div class="content-card">

            <h4>
                📊 Supply Chain Impact
            </h4>

            <p>

                {{ $impact
                    ?? 'Belum ada analisis dampak.'
                }}

            </p>

        </div>


        <div class="content-card">

            <h4>
                💡 Recommendation
            </h4>

            <p>

                {{ $recommendation
                    ?? 'Belum ada rekomendasi.'
                }}

            </p>

        </div>

    </div>


    <!-- HISTORY -->

    <div class="currency-history-card">

        <div class="currency-history-header">

            <div class="currency-history-title">

                <div class="currency-history-icon">
                    📈
                </div>

                <div>

                    <h4>
                        Currency Exchange History
                    </h4>

                    <p>

                        Riwayat nilai tukar
                        <strong>
                            {{ $currencyCode ?? '-' }}
                        </strong>
                        terhadap Rupiah (IDR).

                    </p>

                </div>

            </div>


            <div class="records-badge">

                {{ $currencyHistory->count() }}
                Records

            </div>

        </div>


        @if($currencyHistory->count() > 0)

            <div class="currency-history-table-wrapper">

                <table class="currency-history-table">

                    <thead>

                        <tr>

                            <th>No</th>
                            <th>Date</th>
                            <th>Currency</th>
                            <th>Exchange Rate</th>
                            <th>Previous Rate</th>
                            <th>Change</th>
                            <th>Risk</th>

                        </tr>

                    </thead>


                    <tbody>

                        @foreach($currencyHistory as $index => $history)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>


                                <td>

                                    @if($history->recorded_at)

                                        {{ $history->recorded_at->format(
                                            'd M Y H:i'
                                        ) }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    <span class="currency-code">

                                        {{ $history->currency_code }}

                                    </span>

                                </td>


                                <td>

                                    <span class="exchange-rate">

                                        Rp
                                        {{ number_format(
                                            $history->exchange_rate,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    </span>

                                </td>


                                <td>

                                    @if(
                                        $history->previous_rate
                                        !== null
                                    )

                                        Rp
                                        {{ number_format(
                                            $history->previous_rate,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if(
                                        $history->change_percent > 0
                                    )

                                        <span class="change-up">

                                            ↑
                                            {{ number_format(
                                                abs(
                                                    $history->change_percent
                                                ),
                                                2
                                            ) }}%

                                        </span>

                                    @elseif(
                                        $history->change_percent < 0
                                    )

                                        <span class="change-down">

                                            ↓
                                            {{ number_format(
                                                abs(
                                                    $history->change_percent
                                                ),
                                                2
                                            ) }}%

                                        </span>

                                    @else

                                        <span class="change-neutral">

                                            — 0.00%

                                        </span>

                                    @endif

                                </td>


                                <td>

                                    <span
                                        class="risk-badge
                                        {{ $history->risk_level === 'HIGH'
                                            ? 'risk-high'
                                            : (
                                                $history->risk_level === 'MEDIUM'
                                                ? 'risk-medium'
                                                : (
                                                    $history->risk_level === 'LOW'
                                                    ? 'risk-low'
                                                    : 'risk-unknown'
                                                )
                                            )
                                        }}"
                                    >

                                        {{ $history->risk_level }}

                                    </span>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-history">

                <div class="empty-history-icon">
                    📊
                </div>

                <h5>
                    Belum Ada Histori
                </h5>

                <p>

                    Data histori nilai tukar akan otomatis
                    tersimpan setelah sistem berhasil
                    mengambil data dari API.

                </p>

            </div>

        @endif

    </div>

</div>

@endsection