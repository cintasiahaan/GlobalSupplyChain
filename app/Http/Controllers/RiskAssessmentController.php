<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\RiskAssessment;

class RiskAssessmentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $riskAssessments = RiskAssessment::with('country')
            ->orderByDesc('risk_score')
            ->get();

        return view(
            'admin.risk-assessments.index',
            compact('riskAssessments')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create(
        Country $country
    ) {

        // Cek apakah negara sudah memiliki Risk Assessment
        $riskAssessment = $country->riskAssessment;

        return view(
            'admin.risk-assessments.create',
            compact(
                'country',
                'riskAssessment'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        Country $country
    ) {

        $validated = $request->validate([

            'weather_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'economic_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'currency_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'political_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'port_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | HITUNG RISK SCORE
        |--------------------------------------------------------------------------
        */

        $riskScore = (

            $validated['weather_risk'] +

            $validated['economic_risk'] +

            $validated['currency_risk'] +

            $validated['political_risk'] +

            $validated['port_risk']

        ) / 5;


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN RISK LEVEL
        |--------------------------------------------------------------------------
        */

        if (
            $riskScore < 40
        ) {

            $riskLevel = 'Low';

        } elseif (
            $riskScore < 70
        ) {

            $riskLevel = 'Medium';

        } else {

            $riskLevel = 'High';

        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN / UPDATE
        |--------------------------------------------------------------------------
        |
        | updateOrCreate digunakan agar satu negara
        | hanya memiliki satu Risk Assessment.
        |
        */

        RiskAssessment::updateOrCreate(

            [
                'country_id' => $country->id
            ],

            [

                'weather_risk' =>
                    $validated['weather_risk'],

                'economic_risk' =>
                    $validated['economic_risk'],

                'currency_risk' =>
                    $validated['currency_risk'],

                'political_risk' =>
                    $validated['political_risk'],

                'port_risk' =>
                    $validated['port_risk'],

                'risk_score' =>
                    round(
                        $riskScore,
                        2
                    ),

                'risk_level' =>
                    $riskLevel,

            ]

        );


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.risk-assessments.index'
            )
            ->with(
                'success',
                'Risk Assessment berhasil disimpan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        RiskAssessment $riskAssessment
    ) {

        $riskAssessment->load(
            'country'
        );


        return view(
            'admin.risk-assessments.edit',
            compact(
                'riskAssessment'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        RiskAssessment $riskAssessment
    ) {

        $validated = $request->validate([

            'weather_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'economic_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'currency_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'political_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

            'port_risk' => [
                'required',
                'numeric',
                'min:0',
                'max:100'
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | HITUNG ULANG RISK SCORE
        |--------------------------------------------------------------------------
        */

        $riskScore = (

            $validated['weather_risk'] +

            $validated['economic_risk'] +

            $validated['currency_risk'] +

            $validated['political_risk'] +

            $validated['port_risk']

        ) / 5;


        /*
        |--------------------------------------------------------------------------
        | TENTUKAN RISK LEVEL
        |--------------------------------------------------------------------------
        */

        if (
            $riskScore < 40
        ) {

            $riskLevel = 'Low';

        } elseif (
            $riskScore < 70
        ) {

            $riskLevel = 'Medium';

        } else {

            $riskLevel = 'High';

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE
        |--------------------------------------------------------------------------
        */

        $riskAssessment->update([

            'weather_risk' =>
                $validated['weather_risk'],

            'economic_risk' =>
                $validated['economic_risk'],

            'currency_risk' =>
                $validated['currency_risk'],

            'political_risk' =>
                $validated['political_risk'],

            'port_risk' =>
                $validated['port_risk'],

            'risk_score' =>
                round(
                    $riskScore,
                    2
                ),

            'risk_level' =>
                $riskLevel,

        ]);


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'admin.risk-assessments.index'
            )
            ->with(
                'success',
                'Risk Assessment berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(
        RiskAssessment $riskAssessment
    ) {

        $riskAssessment->delete();


        return redirect()
            ->route(
                'admin.risk-assessments.index'
            )
            ->with(
                'success',
                'Risk Assessment berhasil dihapus.'
            );
    }
}