@extends('layouts.app')

@section('title', 'Edit Risk Assessment')

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

    .form-container {
        max-width: 800px;
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .country-box {
        background: #f8fafc;
        padding: 18px;
        border-radius: 10px;
        margin-bottom: 25px;
        border: 1px solid #e2e8f0;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #334155;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        box-sizing: border-box;
        font-size: 15px;
    }

    .form-group input:focus {
        outline: none;
        border-color: #2563eb;
    }

    .error-message {
        color: #dc2626;
        font-size: 13px;
        margin-top: 5px;
    }

    .button-container {
        display: flex;
        gap: 10px;
        margin-top: 25px;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 11px 18px;
        border: none;
        border-radius: 8px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary {
        background: #2563eb;
        color: white;
    }

    .btn-secondary {
        background: #64748b;
        color: white;
    }

</style>


<div class="page-header">

    <h1>
        ✏️ Edit Risk Assessment
    </h1>

    <p>
        Perbarui data risiko supply chain negara.
    </p>

</div>


<div class="form-container">

    {{-- COUNTRY INFORMATION --}}

    <div class="country-box">

        <strong>
            🌍 Negara
        </strong>

        <h2 style="margin: 8px 0 0 0;">

            {{ $riskAssessment->country->name ?? 'Country tidak ditemukan' }}

        </h2>

    </div>


    {{-- FORM --}}

    <form
        action="{{ route(
            'admin.risk-assessments.update',
            $riskAssessment
        ) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        {{-- WEATHER RISK --}}

        <div class="form-group">

            <label>
                🌦️ Weather Risk
            </label>

            <input
                type="number"
                name="weather_risk"
                min="0"
                max="100"
                step="0.01"
                value="{{ old(
                    'weather_risk',
                    $riskAssessment->weather_risk
                ) }}"
                required
            >

            @error('weather_risk')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- ECONOMIC RISK --}}

        <div class="form-group">

            <label>
                📉 Economic Risk
            </label>

            <input
                type="number"
                name="economic_risk"
                min="0"
                max="100"
                step="0.01"
                value="{{ old(
                    'economic_risk',
                    $riskAssessment->economic_risk
                ) }}"
                required
            >

            @error('economic_risk')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- CURRENCY RISK --}}

        <div class="form-group">

            <label>
                💱 Currency Risk
            </label>

            <input
                type="number"
                name="currency_risk"
                min="0"
                max="100"
                step="0.01"
                value="{{ old(
                    'currency_risk',
                    $riskAssessment->currency_risk
                ) }}"
                required
            >

            @error('currency_risk')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- POLITICAL RISK --}}

        <div class="form-group">

            <label>
                🏛️ Political Risk
            </label>

            <input
                type="number"
                name="political_risk"
                min="0"
                max="100"
                step="0.01"
                value="{{ old(
                    'political_risk',
                    $riskAssessment->political_risk
                ) }}"
                required
            >

            @error('political_risk')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- PORT RISK --}}

        <div class="form-group">

            <label>
                ⚓ Port Risk
            </label>

            <input
                type="number"
                name="port_risk"
                min="0"
                max="100"
                step="0.01"
                value="{{ old(
                    'port_risk',
                    $riskAssessment->port_risk
                ) }}"
                required
            >

            @error('port_risk')

                <div class="error-message">
                    {{ $message }}
                </div>

            @enderror

        </div>


        {{-- BUTTON --}}

        <div class="button-container">

            <button
                type="submit"
                class="btn btn-primary"
            >
                💾 Simpan Perubahan
            </button>


            <a
                href="{{ route(
                    'admin.risk-assessments.index'
                ) }}"
                class="btn btn-secondary"
            >
                ← Kembali
            </a>

        </div>

    </form>

</div>

@endsection