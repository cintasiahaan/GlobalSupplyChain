<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Port;
use App\Models\News;
use App\Models\RiskAssessment;
use App\Models\CurrencyImpact;
use App\Services\GlobalSupplyChainApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SupplyChainApiController extends Controller
{
    protected GlobalSupplyChainApiService $apiService;

    public function __construct(GlobalSupplyChainApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * 1. GET /api/countries
     */
    public function countries(Request $request): JsonResponse
    {
        $query = Country::with('riskAssessment');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        $countries = $query->orderBy('name')->get();

        return response()->json([
            'status' => 'success',
            'total' => $countries->count(),
            'data' => $countries,
        ]);
    }

    /**
     * 2. GET /api/risk
     */
    public function risk(): JsonResponse
    {
        $assessments = RiskAssessment::with('country')->get();
        $avgScore = round(RiskAssessment::avg('risk_score') ?? 0, 2);

        $globalLevel = 'Low';
        if ($avgScore >= 70) {
            $globalLevel = 'High';
        } elseif ($avgScore >= 40) {
            $globalLevel = 'Medium';
        }

        return response()->json([
            'status' => 'success',
            'global_risk_score' => $avgScore,
            'global_risk_level' => $globalLevel,
            'total_assessments' => $assessments->count(),
            'data' => $assessments,
        ]);
    }

    /**
     * 3. GET /api/ports
     */
    public function ports(Request $request): JsonResponse
    {
        $query = Port::query();

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $ports = $query->orderBy('name')->get();

        return response()->json([
            'status' => 'success',
            'total' => $ports->count(),
            'data' => $ports,
        ]);
    }

    /**
     * 4. GET /api/news
     */
    public function news(): JsonResponse
    {
        $dbNews = News::latest('published_at')->take(15)->get();
        $liveNews = $this->apiService->getLogisticsNews('shipping logistics');

        // Apply sentiment analysis to live news
        $formattedLive = array_map(function ($article) {
            $sentimentData = $this->apiService->analyzeSentiment($article['title'] . ' ' . $article['summary']);
            $article['sentiment_analysis'] = $sentimentData;
            return $article;
        }, $liveNews);

        return response()->json([
            'status' => 'success',
            'database_news' => $dbNews,
            'live_gnews' => $formattedLive,
        ]);
    }

    /**
     * 5. GET /api/currency
     */
    public function currency(Request $request): JsonResponse
    {
        $base = strtoupper($request->get('base', 'USD'));
        $fxData = $this->apiService->getExchangeRate($base);
        $dbCurrencies = CurrencyImpact::all();

        return response()->json([
            'status' => 'success',
            'base_currency' => $base,
            'live_rates' => $fxData['rates'] ?? [],
            'database_currency_records' => $dbCurrencies,
        ]);
    }
}
