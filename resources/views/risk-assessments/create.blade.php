@extends('layouts.app')

@section('title', 'Risk Assessment')

@section('content')

<div class="page-header">

    <a
        href="{{ route('countries.show', $country) }}"
        style="
            display: inline-block;
            margin-bottom: 20px;
            color: #2563eb;
            text-decoration: none;
            font-weight: 600;
        "
    >
        ← Back to Country Detail
    </a>

    <h1>
        📊 Risk Assessment
    </h1>

    <p>
        Evaluate supply chain risks for
        <strong>{{ $country->name }}</strong>
    </p>

</div>


<div class="table-container">

    <h2>
        🌍 {{ $country->name }}
    </h2>

    <p style="color: #64748b;">
        Enter risk values from 0 to 100.
    </p>


    @if($errors->any())

        <div
            style="
                padding: 15px;
                margin: 20px 0;
                background: #fee2e2;
                color: #991b1b;
                border-radius: 10px;
            "
        >

            <strong>
                Please fix the following errors:
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
        method="POST"
        action="{{
            route(
                'admin.risk-assessments.store',
                $country
            )
        }}"
        style="
            margin-top: 30px;
        "
    >

        @csrf


        <div
            style="
                display: grid;
                grid-template-columns:
                    repeat(
                        auto-fit,
                        minmax(250px, 1fr)
                    );
                gap: 25px;
            "
        >


            {{-- WEATHER --}}

            <div>

                <label>
                    🌦️ Weather Risk
                </label>

                <input
                    type="number"
                    name="weather_risk"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{
                        old(
                            'weather_risk',
                            optional(
                                $country->riskAssessment
                            )->weather_risk
                        )
                    }}"
                    required
                    style="
                        width: 100%;
                        padding: 14px;
                        margin-top: 8px;
                        border: 1px solid #d1d5db;
                        border-radius: 8px;
                    "
                >

            </div>


            {{-- ECONOMIC --}}

            <div>

                <label>
                    💰 Economic Risk
                </label>

                <input
                    type="number"
                    name="economic_risk"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{
                        old(
                            'economic_risk',
                            optional(
                                $country->riskAssessment
                            )->economic_risk
                        )
                    }}"
                    required
                    style="
                        width: 100%;
                        padding: 14px;
                        margin-top: 8px;
                        border: 1px solid #d1d5db;
                        border-radius: 8px;
                    "
                >

            </div>


            {{-- CURRENCY --}}

            <div>

                <label>
                    💱 Currency Risk
                </label>

                <input
                    type="number"
                    name="currency_risk"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{
                        old(
                            'currency_risk',
                            optional(
                                $country->riskAssessment
                            )->currency_risk
                        )
                    }}"
                    required
                    style="
                        width: 100%;
                        padding: 14px;
                        margin-top: 8px;
                        border: 1px solid #d1d5db;
                        border-radius: 8px;
                    "
                >

            </div>


            {{-- POLITICAL --}}

            <div>

                <label>
                    🏛️ Political Risk
                </label>

                <input
                    type="number"
                    name="political_risk"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{
                        old(
                            'political_risk',
                            optional(
                                $country->riskAssessment
                            )->political_risk
                        )
                    }}"
                    required
                    style="
                        width: 100%;
                        padding: 14px;
                        margin-top: 8px;
                        border: 1px solid #d1d5db;
                        border-radius: 8px;
                    "
                >

            </div>


            {{-- PORT --}}

            <div>

                <label>
                    ⚓ Port Risk
                </label>

                <input
                    type="number"
                    name="port_risk"
                    min="0"
                    max="100"
                    step="0.01"
                    value="{{
                        old(
                            'port_risk',
                            optional(
                                $country->riskAssessment
                            )->port_risk
                        )
                    }}"
                    required
                    style="
                        width: 100%;
                        padding: 14px;
                        margin-top: 8px;
                        border: 1px solid #d1d5db;
                        border-radius: 8px;
                    "
                >

            </div>

        </div>


        <div
            style="
                margin-top: 35px;
                padding: 20px;
                background: #f8fafc;
                border-radius: 10px;
            "
        >

            <strong>
                Risk Score Calculation
            </strong>

            <p style="color: #64748b;">

                Risk Score =
                (Weather + Economic + Currency
                + Political + Port) ÷ 5

            </p>

            <p style="color: #64748b;">

                0–39.99 = 🟢 Low Risk<br>

                40–69.99 = 🟡 Medium Risk<br>

                70–100 = 🔴 High Risk

            </p>

        </div>


        <button
            type="submit"
            style="
                margin-top: 25px;
                padding: 14px 25px;
                background: #2563eb;
                color: white;
                border: none;
                border-radius: 8px;
                cursor: pointer;
                font-size: 16px;
                font-weight: 600;
            "
        >
            📊 Calculate & Save Risk Assessment
        </button>

    </form>

</div>

@endsection