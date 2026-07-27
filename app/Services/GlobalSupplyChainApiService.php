<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GlobalSupplyChainApiService
{
    /**
     * 1. Open-Meteo API - Weather Data (No API Key Required)
     */
    public function getWeather(float $latitude, float $longitude): ?array
    {
        $cacheKey = "weather_{$latitude}_{$longitude}";

        return Cache::remember($cacheKey, 1800, function () use ($latitude, $longitude) {
            try {
                $response = Http::timeout(10)->get('https://api.open-meteo.com/v1/forecast', [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,precipitation,weather_code,wind_speed_10m',
                    'timezone' => 'auto',
                ]);

                return $response->successful() ? $response->json() : null;
            } catch (\Throwable $e) {
                return null;
            }
        });
    }

    /**
     * 2. World Bank API - Country Indicators (GDP, Inflation, Population)
     */
    public function getWorldBankData(string $countryIso2): array
    {
        $cacheKey = "worldbank_{$countryIso2}";

        return Cache::remember($cacheKey, 86400, function () use ($countryIso2) {
            $data = [
                'gdp' => null,
                'inflation' => null,
                'population' => null,
            ];

            try {
                // GDP Indicator (NY.GDP.MKTP.CD)
                $gdpRes = Http::timeout(8)->get("https://api.worldbank.org/v2/country/{$countryIso2}/indicator/NY.GDP.MKTP.CD?format=json&mrnev=1");
                if ($gdpRes->successful() && isset($gdpRes->json()[1][0]['value'])) {
                    $data['gdp'] = $gdpRes->json()[1][0]['value'];
                }

                // Inflation Indicator (FP.CPI.TOTL.ZG)
                $infRes = Http::timeout(8)->get("https://api.worldbank.org/v2/country/{$countryIso2}/indicator/FP.CPI.TOTL.ZG?format=json&mrnev=1");
                if ($infRes->successful() && isset($infRes->json()[1][0]['value'])) {
                    $data['inflation'] = round($infRes->json()[1][0]['value'], 2);
                }

                // Population Indicator (SP.POP.TOTL)
                $popRes = Http::timeout(8)->get("https://api.worldbank.org/v2/country/{$countryIso2}/indicator/SP.POP.TOTL?format=json&mrnev=1");
                if ($popRes->successful() && isset($popRes->json()[1][0]['value'])) {
                    $data['population'] = $popRes->json()[1][0]['value'];
                }
            } catch (\Throwable $e) {
                // Return partials if available
            }

            return $data;
        });
    }

    /**
     * 3. REST Countries API - Country Metadata (Currencies, Languages, Subregion, Flag)
     */
    public function getRestCountryData(string $countryName): ?array
    {
        $cacheKey = "restcountries_" . md5($countryName);

        return Cache::remember($cacheKey, 86400, function () use ($countryName) {
            try {
                $response = Http::timeout(8)->get("https://restcountries.com/v3.1/name/" . urlencode($countryName));
                if ($response->successful() && is_array($response->json()) && isset($response->json()[0])) {
                    $item = $response->json()[0];

                    $currencies = [];
                    if (isset($item['currencies']) && is_array($item['currencies'])) {
                        foreach ($item['currencies'] as $code => $curr) {
                            $currencies[] = $code . ' (' . ($curr['name'] ?? '') . ')';
                        }
                    }

                    $languages = [];
                    if (isset($item['languages']) && is_array($item['languages'])) {
                        $languages = array_values($item['languages']);
                    }

                    return [
                        'flag' => $item['flags']['svg'] ?? ($item['flags']['png'] ?? null),
                        'capital' => $item['capital'][0] ?? '-',
                        'subregion' => $item['subregion'] ?? '-',
                        'population' => isset($item['population']) ? number_format($item['population']) : '-',
                        'currencies' => implode(', ', $currencies),
                        'languages' => implode(', ', $languages),
                        'googleMaps' => $item['maps']['googleMaps'] ?? null,
                    ];
                }
            } catch (\Throwable $e) {
                return null;
            }

            return null;
        });
    }

    /**
     * 4. ExchangeRate API - Realtime Currency FX Rates
     */
    public function getExchangeRate(string $baseCurrency = 'USD'): ?array
    {
        $cacheKey = "fx_rates_{$baseCurrency}";

        return Cache::remember($cacheKey, 3600, function () use ($baseCurrency) {
            try {
                $response = Http::timeout(8)->get("https://open.er-api.com/v6/latest/{$baseCurrency}");
                if ($response->successful() && $response->json('result') === 'success') {
                    return $response->json();
                }
            } catch (\Throwable $e) {
                return null;
            }

            return null;
        });
    }

    /**
     * 5. GNews API / News API Alternatif - Logistics & Trade News Feed
     */
    public function getLogisticsNews(string $query = 'shipping logistics economy'): array
    {
        $cacheKey = "gnews_" . md5($query);

        return Cache::remember($cacheKey, 1800, function () use ($query) {
            $articles = [];
            $apiKey = config('services.gnews.key', env('GNEWS_API_KEY'));

            if ($apiKey) {
                try {
                    $response = Http::timeout(8)->get("https://gnews.io/api/v4/search", [
                        'q' => $query,
                        'lang' => 'en',
                        'max' => 10,
                        'token' => $apiKey
                    ]);

                    if ($response->successful() && isset($response->json()['articles'])) {
                        foreach ($response->json()['articles'] as $art) {
                            $articles[] = [
                                'title' => $art['title'] ?? 'Global Logistics Alert',
                                'summary' => $art['description'] ?? ($art['title'] ?? ''),
                                'source' => $art['source']['name'] ?? 'GNews',
                                'url' => $art['url'] ?? '#',
                                'published_at' => $art['publishedAt'] ?? now()->toIso8601String(),
                            ];
                        }

                        return $articles;
                    }
                } catch (\Throwable $e) {
                    // Fallback to free news feed
                }
            }

            // Reliable Public Free Feed Fallback (ok.surf news feed)
            try {
                $res = Http::timeout(5)->get('https://ok.surf/api/v1/news/feed');
                if ($res->successful()) {
                    $feed = $res->json();
                    $items = array_merge($feed['Business'] ?? [], $feed['World'] ?? []);
                    foreach (array_slice($items, 0, 10) as $item) {
                        $articles[] = [
                            'title' => $item['title'] ?? 'World Supply Chain Update',
                            'summary' => $item['title'] ?? 'Live logistics news feed.',
                            'source' => $item['source'] ?? 'Global News',
                            'url' => $item['link'] ?? '#',
                            'published_at' => now()->toIso8601String(),
                        ];
                    }
                }
            } catch (\Throwable $e) {
                // Fallback empty
            }

            return $articles;
        });
    }

    /**
     * 6. Lexicon-Based Sentiment Analysis (Simple PHP Lexicon)
     */
    public function analyzeSentiment(string $text): array
    {
        $textLower = strtolower($text);

        $positiveWords = ['growth', 'increase', 'profit', 'stable', 'improve', 'surge', 'recovery', 'expansion', 'boost', 'gain'];
        $negativeWords = ['war', 'crisis', 'inflation', 'delay', 'disaster', 'strike', 'shortage', 'conflict', 'decline', 'drop', 'sanction', 'blockade'];

        $posCount = 0;
        $negCount = 0;

        foreach ($positiveWords as $word) {
            if (str_contains($textLower, $word)) {
                $posCount++;
            }
        }

        foreach ($negativeWords as $word) {
            if (str_contains($textLower, $word)) {
                $negCount++;
            }
        }

        if ($posCount > $negCount) {
            $sentiment = 'Positive';
        } elseif ($negCount > $posCount) {
            $sentiment = 'Negative';
        } else {
            $sentiment = 'Neutral';
        }

        return [
            'positive_score' => $posCount,
            'negative_score' => $negCount,
            'sentiment' => $sentiment,
        ];
    }
}
