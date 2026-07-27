<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Watchlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class CountryController extends Controller
{
    public function index(Request $request)
    {
        $query = Country::with('riskAssessment');

        // Search negara
        if ($request->filled('search')) {
            $query->where(
                'name',
                'like',
                '%' . $request->search . '%'
            );
        }

        // Filter region
        if ($request->filled('region')) {
            $query->where(
                'region',
                $request->region
            );
        }

        // Filter risiko
        if ($request->filled('risk_level')) {
            $query->whereHas(
                'riskAssessment',
                function ($q) use ($request) {
                    $q->where(
                        'risk_level',
                        $request->risk_level
                    );
                }
            );
        }

        $countries = $query
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        $regions = Country::whereNotNull('region')
            ->distinct()
            ->orderBy('region')
            ->pluck('region');

        return view(
            'countries.index',
            compact(
                'countries',
                'regions'
            )
        );
    }

    public function show(Country $country)
    {
        $country->load('riskAssessment');

        $watchlistId = Watchlist::where(
            'user_id',
            Auth::id()
        )
        ->where(
            'country_id',
            $country->id
        )
        ->value('id');

        // Live REST Countries API Integration (API #4)
        $countryApiData = null;
        try {
            $response = Http::timeout(5)->get('https://restcountries.com/v3.1/name/' . urlencode($country->name));
            if ($response->successful() && is_array($response->json())) {
                $data = $response->json()[0] ?? null;
                if ($data) {
                    $countryApiData = [
                        'flag' => $data['flags']['svg'] ?? ($data['flags']['png'] ?? null),
                        'capital' => $data['capital'][0] ?? '-',
                        'population' => isset($data['population']) ? number_format($data['population']) : '-',
                        'subregion' => $data['subregion'] ?? '-',
                        'googleMaps' => $data['maps']['googleMaps'] ?? null,
                    ];
                }
            }
        } catch (\Throwable $e) {
            $countryApiData = null;
        }

        return view(
            'countries.show',
            compact(
                'country',
                'watchlistId',
                'countryApiData'
            )
        );
    }
}