@extends('layouts.app')

@section('title', 'User Dashboard')

@section('content')

<div class="page-header">

    <h1>👤 User Dashboard</h1>

    <p>
        Selamat datang, {{ auth()->user()->name }}.
        Selamat datang di Global Supply Chain Risk Intelligence.
    </p>

</div>


<div class="cards">

    <div class="card">

        <div class="card-title">
            🌍 Country Monitoring
        </div>

        <p>
            Lihat informasi risiko negara yang dapat memengaruhi
            rantai pasok global.
        </p>

        <a
            href="{{ route('countries.index') }}"
            style="
                display: inline-block;
                margin-top: 15px;
                padding: 10px 16px;
                background: #2563eb;
                color: white;
                border-radius: 8px;
                text-decoration: none;
            "
        >
            View Countries
        </a>

    </div>


    <div class="card">

        <div class="card-title">
            🌦️ Weather Monitoring
        </div>

        <p>
            Pantau kondisi cuaca yang berpotensi memengaruhi
            aktivitas supply chain global.
        </p>

        <a
            href="{{ route('weather.index') }}"
            style="
                display: inline-block;
                margin-top: 15px;
                padding: 10px 16px;
                background: #0891b2;
                color: white;
                border-radius: 8px;
                text-decoration: none;
            "
        >
            View Weather
        </a>

    </div>


    <div class="card">

        <div class="card-title">
            📊 Global Risk Dashboard
        </div>

        <p>
            Lihat ringkasan risiko supply chain global.
        </p>

        <a
            href="{{ route('dashboard') }}"
            style="
                display: inline-block;
                margin-top: 15px;
                padding: 10px 16px;
                background: #111827;
                color: white;
                border-radius: 8px;
                text-decoration: none;
            "
        >
            View Dashboard
        </a>

    </div>

</div>

@endsection