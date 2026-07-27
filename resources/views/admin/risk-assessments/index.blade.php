@extends('layouts.app')

@section('title', 'Risk Assessment Management')

@section('content')

<style>
    .page-header {
        margin-bottom: 25px;
    }

    .page-header h1 {
        margin-bottom: 8px;
    }

    .page-header p {
        color: #64748b;
    }

    .top-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }

    .btn {
        display: inline-block;
        padding: 10px 16px;
        border-radius: 8px;
        text-decoration: none;
        color: white;
        border: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-dashboard {
        background: #111827;
    }

    .btn-country {
        background: #2563eb;
    }

    .btn-weather {
        background: #0891b2;
    }

    .btn-danger {
        background: #dc2626;
    }

    .table-container {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow-x: auto;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 1100px;
    }

    th,
    td {
        padding: 14px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }

    th {
        background: #f8fafc;
        color: #334155;
        font-weight: 600;
    }

    tr:hover {
        background: #f8fafc;
    }

    .risk-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }

    .risk-low {
        background: #dcfce7;
        color: #166534;
    }

    .risk-medium {
        background: #fef3c7;
        color: #92400e;
    }

    .risk-high {
        background: #fee2e2;
        color: #b91c1c;
    }

    .risk-unknown {
        background: #e2e8f0;
        color: #475569;
    }

    .success-message {
        background: #dcfce7;
        color: #166534;
        padding: 14px 18px;
        border-radius: 8px;
        margin-bottom: 20px;
    }

    .empty-data {
        text-align: center;
        padding: 40px !important;
        color: #64748b;
        white-space: normal;
    }

    .action-container {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .action-container form {
        margin: 0;
    }
</style>


{{-- ===================================================== --}}
{{-- PAGE HEADER --}}
{{-- ===================================================== --}}

<div class="page-header">

    <h1>
        📊 Risk Assessment Management
    </h1>

    <p>
        Kelola dan pantau tingkat risiko supply chain setiap negara.
    </p>

</div>


{{-- ===================================================== --}}
{{-- SUCCESS MESSAGE --}}
{{-- ===================================================== --}}

@if(session('success'))

    <div class="success-message">
        ✅ {{ session('success') }}
    </div>

@endif


{{-- ===================================================== --}}
{{-- TOP ACTIONS --}}
{{-- ===================================================== --}}

<div class="top-actions">

    <a
        href="{{ route('admin.dashboard') }}"
        class="btn btn-dashboard"
    >
        🛠️ Admin Dashboard
    </a>

    <a
        href="{{ route('countries.index') }}"
        class="btn btn-country"
    >
        🌍 Country Monitoring
    </a>

    <a
        href="{{ route('weather.index') }}"
        class="btn btn-weather"
    >
        🌦️ Weather Monitoring
    </a>

</div>


{{-- ===================================================== --}}
{{-- TABLE CONTAINER --}}
{{-- ===================================================== --}}

<div class="table-container">

    <h2>
        🌍 Global Risk Assessment Data
    </h2>

    <p style="color: #64748b;">

        Total Risk Assessment:

        <strong>
            {{ $riskAssessments->count() }}
        </strong>

    </p>


    <table>

        <thead>

            <tr>

                <th>#</th>

                <th>Country</th>

                <th>Weather Risk</th>

                <th>Economic Risk</th>

                <th>Currency Risk</th>

                <th>Political Risk</th>

                <th>Port Risk</th>

                <th>Risk Score</th>

                <th>Risk Level</th>

                <th>Action</th>

            </tr>

        </thead>


        <tbody>

            {{-- ================================================= --}}
            {{-- CEK APAKAH DATA TERSEDIA --}}
            {{-- ================================================= --}}

            @if($riskAssessments->count() > 0)


                {{-- ================================================= --}}
                {{-- LOOP DATA --}}
                {{-- ================================================= --}}

                @foreach($riskAssessments as $assessment)

                    <tr>

                        {{-- NOMOR --}}

                        <td>
                            {{ $loop->iteration }}
                        </td>


                        {{-- COUNTRY --}}

                        <td>

                            @if($assessment->country)

                                <strong>
                                    🌍 {{ $assessment->country->name }}
                                </strong>

                            @else

                                <span>
                                    Country tidak ditemukan
                                </span>

                            @endif

                        </td>


                        {{-- WEATHER RISK --}}

                        <td>
                            {{ $assessment->weather_risk ?? 0 }}
                        </td>


                        {{-- ECONOMIC RISK --}}

                        <td>
                            {{ $assessment->economic_risk ?? 0 }}
                        </td>


                        {{-- CURRENCY RISK --}}

                        <td>
                            {{ $assessment->currency_risk ?? 0 }}
                        </td>


                        {{-- POLITICAL RISK --}}

                        <td>
                            {{ $assessment->political_risk ?? 0 }}
                        </td>


                        {{-- PORT RISK --}}

                        <td>
                            {{ $assessment->port_risk ?? 0 }}
                        </td>


                        {{-- RISK SCORE --}}

                        <td>

                            <strong>
                                {{ number_format(
                                    $assessment->risk_score ?? 0,
                                    2
                                ) }}
                            </strong>

                        </td>


                        {{-- RISK LEVEL --}}

                        <td>

                            @if($assessment->risk_level === 'Low')

                                <span class="risk-badge risk-low">
                                    🟢 Low
                                </span>

                            @elseif($assessment->risk_level === 'Medium')

                                <span class="risk-badge risk-medium">
                                    🟡 Medium
                                </span>

                            @elseif($assessment->risk_level === 'High')

                                <span class="risk-badge risk-high">
                                    🔴 High
                                </span>

                            @else

                                <span class="risk-badge risk-unknown">
                                    ⚪ Unknown
                                </span>

                            @endif

                        </td>


                        {{-- ACTION --}}

                        <td>

                            <div class="action-container">


                                {{-- EDIT --}}

                                <a
                                    href="{{ route(
                                        'admin.risk-assessments.edit',
                                        $assessment->id
                                    ) }}"
                                    class="btn btn-country"
                                >
                                    ✏️ Edit
                                </a>


                                {{-- DELETE --}}

                                <form
                                    action="{{ route(
                                        'admin.risk-assessments.destroy',
                                        $assessment->id
                                    ) }}"
                                    method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus Risk Assessment ini?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger"
                                    >
                                        🗑️ Hapus
                                    </button>

                                </form>


                            </div>

                        </td>

                    </tr>

                @endforeach


            @else


                {{-- ================================================= --}}
                {{-- JIKA DATA KOSONG --}}
                {{-- ================================================= --}}

                <tr>

                    <td
                        colspan="10"
                        class="empty-data"
                    >

                        <div style="font-size: 40px;">
                            📊
                        </div>

                        <br>

                        <strong>
                            Belum ada data Risk Assessment.
                        </strong>

                        <br><br>

                        Silakan masuk ke
                        <strong>
                            Country Monitoring
                        </strong>
                        untuk menambahkan data.

                    </td>

                </tr>


            @endif

        </tbody>

    </table>

</div>

@endsection