@extends('layouts.app')

@section('title', 'Tambah Risk Assessment')

@section('content')

<div class="page-header">

    <h1>➕ Tambah Risk Assessment</h1>

    <p>
        Tambahkan penilaian risiko untuk negara yang dipilih.
    </p>

</div>


<div class="table-container">

    <h2>
        🌍 {{ $country->name }}
    </h2>

    @if($errors->any())

        <div style="
            background: #fee2e2;
            color: #b91c1c;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        ">

            <strong>
                Terdapat kesalahan:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route(
            'admin.risk-assessments.store',
            $country
        ) }}"
        method="POST"
    >

        @csrf


        <div style="
            display: grid;
            grid-template-columns:
                repeat(2, 1fr);
            gap: 20px;
        ">


            {{-- WEATHER RISK --}}

            <div>

                <label>
                    🌦️ Weather Risk
                </label>

                <input
                    type="number"
                    name="weather_risk"
                    value="{{ old('weather_risk', 0) }}"
                    min="0"
                    max="100"
                    step="0.01"
                    required
                    style="
                        width: 100%;
                        padding: 12px;
                        margin-top: 8px;
                        border: 1px solid #cbd5e1;
                        border-radius: 8px;
                    "
                >

                <small>
                    Masukkan nilai 0 sampai 100.
                </small>

            </div>


            {{-- ECONOMIC RISK --}}

            <div>

                <label>
                    📈 Economic Risk
                </label>

                <input
                    type="number"
                    name="economic_risk"
                    value="{{ old('economic_risk', 0) }}"
                    min="0"
                    max="100"
                    step="0.01"
                    required
                    style="
                        width: 100%;
                        padding: 12px;
                        margin-top: 8px;
                        border: 1px solid #cbd5e1;
                        border-radius: 8px;
                    "
                >

                <small>
                    Masukkan nilai 0 sampai 100.
                </small>

            </div>


            {{-- CURRENCY RISK --}}

            <div>

                <label>
                    💱 Currency Risk
                </label>

                <input
                    type="number"
                    name="currency_risk"
                    value="{{ old('currency_risk', 0) }}"
                    min="0"
                    max="100"
                    step="0.01"
                    required
                    style="
                        width: 100%;
                        padding: 12px;
                        margin-top: 8px;
                        border: 1px solid #cbd5e1;
                        border-radius: 8px;
                    "
                >

                <small>
                    Masukkan nilai 0 sampai 100.
                </small>

            </div>


            {{-- POLITICAL RISK --}}

            <div>

                <label>
                    🏛️ Political Risk
                </label>

                <input
                    type="number"
                    name="political_risk"
                    value="{{ old('political_risk', 0) }}"
                    min="0"
                    max="100"
                    step="0.01"
                    required
                    style="
                        width: 100%;
                        padding: 12px;
                        margin-top: 8px;
                        border: 1px solid #cbd5e1;
                        border-radius: 8px;
                    "
                >

                <small>
                    Masukkan nilai 0 sampai 100.
                </small>

            </div>


            {{-- PORT RISK --}}

            <div>

                <label>
                    🚢 Port Risk
                </label>

                <input
                    type="number"
                    name="port_risk"
                    value="{{ old('port_risk', 0) }}"
                    min="0"
                    max="100"
                    step="0.01"
                    required
                    style="
                        width: 100%;
                        padding: 12px;
                        margin-top: 8px;
                        border: 1px solid #cbd5e1;
                        border-radius: 8px;
                    "
                >

                <small>
                    Masukkan nilai 0 sampai 100.
                </small>

            </div>

        </div>


        <div style="
            margin-top: 30px;
            padding: 15px;
            background: #f1f5f9;
            border-radius: 8px;
        ">

            <strong>
                ℹ️ Informasi
            </strong>

            <p style="
                margin-bottom: 0;
                color: #64748b;
            ">

                Risk Score akan dihitung otomatis
                dari rata-rata 5 faktor risiko.
                Risk Level juga akan ditentukan
                secara otomatis.

            </p>

        </div>


        <div style="
            display: flex;
            gap: 10px;
            margin-top: 25px;
        ">


            <button
                type="submit"
                style="
                    padding: 12px 20px;
                    background: #2563eb;
                    color: white;
                    border: none;
                    border-radius: 8px;
                    cursor: pointer;
                "
            >

                💾 Simpan Risk Assessment

            </button>


            <a
                href="{{ route(
                    'admin.risk-assessments.index'
                ) }}"
                style="
                    padding: 12px 20px;
                    background: #64748b;
                    color: white;
                    border-radius: 8px;
                    text-decoration: none;
                "
            >

                Batal

            </a>

        </div>

    </form>

</div>

@endsection