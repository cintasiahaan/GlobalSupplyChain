<?php

namespace App\Http\Controllers;

use App\Models\Port;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PortController extends Controller
{
    public function index(Request $request)
    {
        $query = Port::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('port_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhere('country', 'like', "%{$search}%");
            });
        }

        if ($request->filled('country')) {
            $query->where('country', 'like', "%{$request->country}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('risk_level')) {
            $query->where('risk_level', $request->risk_level);
        }

        $ports = $query->latest('recorded_at')->get();
        $allPorts = Port::all(); // Passed to map for complete geotagging

        $countriesList = Port::distinct()->pluck('country');

        // Live Open-Meteo Marine API Integration for Ports
        $liveMarineData = null;
        try {
            $response = Http::timeout(5)->get('https://marine-api.open-meteo.com/v1/marine', [
                'latitude' => 1.290270,  // Port of Singapore / Malacca Strait
                'longitude' => 103.851959,
                'current' => 'wave_height,wave_direction,wave_period,swell_wave_height',
                'timezone' => 'auto',
            ]);

            if ($response->successful()) {
                $current = $response->json('current');
                $waveHeight = $current['wave_height'] ?? 0.5;
                $liveMarineData = [
                    'location' => 'Strait of Malacca & Singapore Port Channel',
                    'wave_height' => $waveHeight . ' m',
                    'swell_height' => ($current['swell_wave_height'] ?? 0.4) . ' m',
                    'sea_condition' => $waveHeight > 2.0 ? '🔴 Rough Seas (High Risk)' : ($waveHeight > 1.0 ? '🟡 Moderate Swell' : '🟢 Calm Sea (Safe)'),
                ];
            }
        } catch (\Throwable $e) {
            $liveMarineData = null;
        }

        return view('ports.index', compact('ports', 'allPorts', 'countriesList', 'liveMarineData'));
    }
}
