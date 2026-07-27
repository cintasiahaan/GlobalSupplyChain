@extends('layouts.app')

@section('title', 'Currency Impact')

@section('content')

<div class="page-header">

    <h1>💱 Currency Impact</h1>

    <p>
        Monitor currency fluctuations affecting
        global supply chain costs.
    </p>

</div>


<div class="dashboard-grid">

    <div class="card">

        <h3>💵 USD</h3>

        <div class="card-number">
            Stable
        </div>

        <p>
            US Dollar market condition.
        </p>

    </div>


    <div class="card">

        <h3>💶 EUR</h3>

        <div class="card-number">
            Medium
        </div>

        <p>
            Euro currency risk.
        </p>

    </div>


    <div class="card">

        <h3>💴 JPY</h3>

        <div class="card-number">
            Low
        </div>

        <p>
            Japanese Yen currency risk.
        </p>

    </div>

</div>


<div class="content-card">

    <h2>Currency Risk Overview</h2>

    <p>
        Monitor exchange rate movements and
        currency volatility that may impact
        international procurement, transportation,
        and supply chain costs.
    </p>

</div>

@endsection