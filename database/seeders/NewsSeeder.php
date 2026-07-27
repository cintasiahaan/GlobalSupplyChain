<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\News;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Suez Canal Congestion Delays Global Shipping',
                'summary' => 'Antrian kapal di Terusan Suez meningkat tajam akibat gangguan cuaca, berdampak pada jadwal pengiriman kontainer dari Asia ke Eropa.',
                'source' => 'Reuters',
                'category' => 'Logistics',
                'country' => 'Egypt',
                'impact_level' => 'High',
                'url' => 'https://www.reuters.com',
                'published_at' => now()->subDays(1),
            ],
            [
                'title' => 'China Manufacturing PMI Signals Slower Export Growth',
                'summary' => 'Data PMI manufaktur China turun ke level terendah dalam 6 bulan, menandakan pelemahan permintaan ekspor global.',
                'source' => 'Bloomberg',
                'category' => 'Economy',
                'country' => 'China',
                'impact_level' => 'Medium',
                'url' => 'https://www.bloomberg.com',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'US Port Workers Reach Tentative Labor Agreement',
                'summary' => 'Kesepakatan awal antara serikat pekerja pelabuhan dan operator terminal di pantai timur AS mengurangi risiko pemogokan.',
                'source' => 'Wall Street Journal',
                'category' => 'Labor',
                'country' => 'United States',
                'impact_level' => 'Medium',
                'url' => 'https://www.wsj.com',
                'published_at' => now()->subDays(2),
            ],
            [
                'title' => 'India Announces New Semiconductor Export Incentives',
                'summary' => 'Pemerintah India memperkenalkan insentif pajak baru untuk mendorong ekspor komponen semikonduktor.',
                'source' => 'Economic Times',
                'category' => 'Trade Policy',
                'country' => 'India',
                'impact_level' => 'Low',
                'url' => 'https://economictimes.indiatimes.com',
                'published_at' => now()->subDays(3),
            ],
            [
                'title' => 'Red Sea Shipping Disruptions Continue to Raise Freight Rates',
                'summary' => 'Gangguan keamanan di Laut Merah terus mendorong kenaikan tarif pengiriman kontainer rute Asia-Eropa.',
                'source' => 'Financial Times',
                'category' => 'Logistics',
                'country' => 'Egypt',
                'impact_level' => 'High',
                'url' => 'https://www.ft.com',
                'published_at' => now()->subDays(4),
            ],
            [
                'title' => 'Brazil Soybean Harvest Exceeds Expectations',
                'summary' => 'Panen kedelai Brazil melampaui perkiraan, berpotensi menekan harga komoditas global dan menambah kapasitas ekspor pelabuhan.',
                'source' => 'Reuters',
                'category' => 'Agriculture',
                'country' => 'Brazil',
                'impact_level' => 'Low',
                'url' => 'https://www.reuters.com',
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'Germany Faces Rail Freight Capacity Shortage',
                'summary' => 'Keterbatasan kapasitas kereta barang di Jerman memperlambat distribusi domestik menjelang musim belanja akhir tahun.',
                'source' => 'Deutsche Welle',
                'category' => 'Logistics',
                'country' => 'Germany',
                'impact_level' => 'Medium',
                'url' => 'https://www.dw.com',
                'published_at' => now()->subDays(6),
            ],
            [
                'title' => 'Japan Yen Volatility Raises Import Cost Concerns',
                'summary' => 'Fluktuasi nilai tukar yen yang tajam meningkatkan ketidakpastian biaya impor bagi manufaktur Jepang.',
                'source' => 'Nikkei Asia',
                'category' => 'Currency',
                'country' => 'Japan',
                'impact_level' => 'Medium',
                'url' => 'https://asia.nikkei.com',
                'published_at' => now()->subDays(7),
            ],
        ];

        foreach ($items as $item) {

            News::firstOrCreate(
                [
                    'title' => $item['title'],
                ],
                $item
            );

        }

        $this->command->info(
            count($items) .
            ' data News Intelligence berhasil diproses.'
        );
    }
}
