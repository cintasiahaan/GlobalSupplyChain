<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Port;
use App\Models\RiskAssessment;

class DashboardController extends Controller
{
    public function index()
    {
        // Total negara
        $totalCountries = Country::count();

        // Jumlah berdasarkan level risiko
        $lowRisk = RiskAssessment::where(
            'risk_level',
            'Low'
        )->count();

        $mediumRisk = RiskAssessment::where(
            'risk_level',
            'Medium'
        )->count();

        $highRisk = RiskAssessment::where(
            'risk_level',
            'High'
        )->count();


        // Rata-rata global risk score
        $globalRiskScore = round(
            RiskAssessment::avg('risk_score') ?? 0,
            2
        );

        // Level risiko global berdasarkan rata-rata skor
        if ($globalRiskScore < 40) {
            $globalRiskLevel = 'Low';
        } elseif ($globalRiskScore < 70) {
            $globalRiskLevel = 'Medium';
        } else {
            $globalRiskLevel = 'High';
        }


        // Seluruh negara beserta risk assessment-nya (untuk peta)
        $allCountries = Country::with('riskAssessment')->get();

        // Data pelabuhan untuk overlay peta
        $allPorts = Port::all();


        // 5 negara dengan risiko tertinggi
        $topHighRiskCountries = Country::with(
            'riskAssessment'
        )
        ->whereHas('riskAssessment')
        ->join(
            'risk_assessments',
            'countries.id',
            '=',
            'risk_assessments.country_id'
        )
        ->orderByDesc(
            'risk_assessments.risk_score'
        )
        ->select(
            'countries.*'
        )
        ->limit(5)
        ->get();


        // Data untuk chart distribusi risiko
        $riskDistribution = [
            'Low' => $lowRisk,
            'Medium' => $mediumRisk,
            'High' => $highRisk,
        ];


        return view(
            'dashboard',
            compact(
                'totalCountries',
                'lowRisk',
                'mediumRisk',
                'highRisk',
                'globalRiskScore',
                'globalRiskLevel',
                'allCountries',
                'allPorts',
                'topHighRiskCountries',
                'riskDistribution'
            )
        );
    }
}