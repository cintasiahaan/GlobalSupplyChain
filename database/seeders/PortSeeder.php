<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Port;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $ports = [
            [
                'port_name' => 'Port of Shanghai',
                'country' => 'China',
                'city' => 'Shanghai',
                'latitude' => 31.23040000,
                'longitude' => 121.47370000,
                'status' => 'Operational',
                'congestion_level' => 'Medium',
                'delay_hours' => 6.5,
                'throughput' => 47000000,
                'risk_level' => 'Medium',
                'description' => 'Pelabuhan kontainer tersibuk di dunia, kepadatan sedang akibat volume ekspor tinggi.',
                'recorded_at' => now()->subHours(2),
            ],
            [
                'port_name' => 'Port of Singapore',
                'country' => 'Singapore',
                'city' => 'Singapore',
                'latitude' => 1.29027000,
                'longitude' => 103.85195900,
                'status' => 'Operational',
                'congestion_level' => 'Low',
                'delay_hours' => 1.2,
                'throughput' => 37000000,
                'risk_level' => 'Low',
                'description' => 'Beroperasi normal dengan waktu tunggu kapal yang rendah.',
                'recorded_at' => now()->subHours(3),
            ],
            [
                'port_name' => 'Port of Los Angeles',
                'country' => 'United States',
                'city' => 'Los Angeles',
                'latitude' => 33.74230000,
                'longitude' => -118.26730000,
                'status' => 'Delayed',
                'congestion_level' => 'High',
                'delay_hours' => 28.0,
                'throughput' => 9200000,
                'risk_level' => 'High',
                'description' => 'Antrian kapal memanjang akibat kekurangan tenaga kerja bongkar muat.',
                'recorded_at' => now()->subHours(1),
            ],
            [
                'port_name' => 'Port of Rotterdam',
                'country' => 'Netherlands',
                'city' => 'Rotterdam',
                'latitude' => 51.92440000,
                'longitude' => 4.47770000,
                'status' => 'Operational',
                'congestion_level' => 'Medium',
                'delay_hours' => 8.0,
                'throughput' => 14500000,
                'risk_level' => 'Medium',
                'description' => 'Gerbang logistik utama Eropa, kepadatan meningkat menjelang akhir kuartal.',
                'recorded_at' => now()->subHours(4),
            ],
            [
                'port_name' => 'Port of Santos',
                'country' => 'Brazil',
                'city' => 'Santos',
                'latitude' => -23.96080000,
                'longitude' => -46.33390000,
                'status' => 'Delayed',
                'congestion_level' => 'High',
                'delay_hours' => 36.5,
                'throughput' => 4600000,
                'risk_level' => 'High',
                'description' => 'Penundaan signifikan akibat lonjakan ekspor komoditas pertanian.',
                'recorded_at' => now()->subHours(5),
            ],
            [
                'port_name' => 'Port of Tanjung Priok (Jakarta)',
                'country' => 'Indonesia',
                'city' => 'Jakarta',
                'latitude' => -6.10390000,
                'longitude' => 106.88060000,
                'status' => 'Operational',
                'congestion_level' => 'Medium',
                'delay_hours' => 5.0,
                'throughput' => 6800000,
                'risk_level' => 'Medium',
                'description' => 'Aktivitas bongkar muat normal dengan kepadatan sedang di dermaga utama.',
                'recorded_at' => now()->subHours(2),
            ],
            [
                'port_name' => 'Port of Hamburg',
                'country' => 'Germany',
                'city' => 'Hamburg',
                'latitude' => 53.55110000,
                'longitude' => 9.99370000,
                'status' => 'Operational',
                'congestion_level' => 'Low',
                'delay_hours' => 2.5,
                'throughput' => 8500000,
                'risk_level' => 'Low',
                'description' => 'Operasional lancar, kapasitas terminal masih memadai.',
                'recorded_at' => now()->subHours(6),
            ],
            [
                'port_name' => 'Port of Tokyo',
                'country' => 'Japan',
                'city' => 'Tokyo',
                'latitude' => 35.67620000,
                'longitude' => 139.65030000,
                'status' => 'Closed',
                'congestion_level' => 'High',
                'delay_hours' => 48.0,
                'throughput' => 4300000,
                'risk_level' => 'High',
                'description' => 'Ditutup sementara akibat cuaca ekstrem, operasional dijadwalkan pulih dalam 2 hari.',
                'recorded_at' => now()->subHours(1),
            ],
            [
                'port_name' => 'Port of Jebel Ali (Dubai)',
                'country' => 'United Arab Emirates',
                'city' => 'Dubai',
                'latitude' => 24.98570000,
                'longitude' => 55.06820000,
                'status' => 'Operational',
                'congestion_level' => 'Low',
                'delay_hours' => 1.8,
                'throughput' => 13700000,
                'risk_level' => 'Low',
                'description' => 'Pusat hub maritim Timur Tengah beroperasi dengan efisiensi tinggi.',
                'recorded_at' => now()->subHours(3),
            ],
            [
                'port_name' => 'Port of Busan',
                'country' => 'South Korea',
                'city' => 'Busan',
                'latitude' => 35.17960000,
                'longitude' => 129.07560000,
                'status' => 'Operational',
                'congestion_level' => 'Medium',
                'delay_hours' => 4.2,
                'throughput' => 22000000,
                'risk_level' => 'Low',
                'description' => 'Pelabuhan kontainer utama Korea Selatan beroperasi lancar.',
                'recorded_at' => now()->subHours(4),
            ],
        ];

        foreach ($ports as $port) {
            Port::updateOrCreate(
                ['port_name' => $port['port_name']],
                $port
            );
        }

        $this->command->info(count($ports) . ' data Port Monitoring berhasil diproses.');
    }
}
