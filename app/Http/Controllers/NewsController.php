<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Facades\Http;

class NewsController extends Controller
{
    public function index()
    {
        $dbNews = News::latest('published_at')->get();

        // Live News API Integration (API #5)
        $liveNews = [];
        try {
            $response = Http::timeout(5)->get('https://ok.surf/api/v1/news/feed');
            if ($response->successful()) {
                $feed = $response->json();
                $businessNews = array_merge(
                    $feed['Business'] ?? [],
                    $feed['World'] ?? []
                );

                foreach (array_slice($businessNews, 0, 10) as $item) {
                    $liveNews[] = (object)[
                        'title' => $item['title'] ?? 'World Supply Chain Update',
                        'summary' => $item['title'] ?? 'Live global news feed update.',
                        'source' => $item['source'] ?? 'Global News',
                        'category' => 'Business & Logistics',
                        'country' => 'Global',
                        'impact_level' => (str_contains(strtolower($item['title'] ?? ''), 'crisis') || str_contains(strtolower($item['title'] ?? ''), 'war') || str_contains(strtolower($item['title'] ?? ''), 'surge')) ? 'High' : 'Medium',
                        'url' => $item['link'] ?? '#',
                        'published_at' => now(),
                    ];
                }
            }
        } catch (\Throwable $e) {
            $liveNews = [];
        }

        return view('news.index', [
            'news' => $dbNews,
            'liveNews' => $liveNews
        ]);
    }
}
