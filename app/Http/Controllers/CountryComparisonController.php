<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Services\GlobalSupplyChainApiService;
use Illuminate\Http\Request;

class CountryComparisonController extends Controller
{
    protected GlobalSupplyChainApiService $apiService;

    public function __construct(GlobalSupplyChainApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    public function index(Request $request)
    {
        $countries = Country::with('riskAssessment')->orderBy('name')->get();

        $c1Id = $request->get('country1', $countries->first()->id ?? null);
        $c2Id = $request->get('country2', $countries->skip(1)->first()->id ?? null);

        $country1 = null;
        $country2 = null;
        $c1Data = null;
        $c2Data = null;

        if ($c1Id) {
            $country1 = Country::with('riskAssessment')->find($c1Id);
            if ($country1) {
                $c1Data = [
                    'rest' => $this->apiService->getRestCountryData($country1->name),
                    'worldbank' => $this->apiService->getWorldBankData($country1->code ?? 'DE'),
                    'weather' => ($country1->latitude && $country1->longitude) ? $this->apiService->getWeather($country1->latitude, $country1->longitude) : null,
                ];
            }
        }

        if ($c2Id) {
            $country2 = Country::with('riskAssessment')->find($c2Id);
            if ($country2) {
                $c2Data = [
                    'rest' => $this->apiService->getRestCountryData($country2->name),
                    'worldbank' => $this->apiService->getWorldBankData($country2->code ?? 'AU'),
                    'weather' => ($country2->latitude && $country2->longitude) ? $this->apiService->getWeather($country2->latitude, $country2->longitude) : null,
                ];
            }
        }

        return view('countries.compare', compact('countries', 'country1', 'country2', 'c1Data', 'c2Data'));
    }
}
