<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class OrderChart extends ChartWidget
{
    protected ?string $heading = 'Analisis Pemesanan Paket Bulanan'; // Model: paket [cite: 2025-12-30]

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    // Filter diperbaiki agar hanya satu dimensi (Tahun saja) untuk menghindari TypeError
    protected function getFilters(): ?array
    {
        $currentYear = (int) date('Y');
        $years = [];

        for ($i = 0; $i < 5; $i++) {
            $year = $currentYear - $i;
            $years[$year] = (string) $year;
        }

        return $years;
    }

    protected function getData(): array
    {
        // Ambil tahun dari filter, jika tidak ada pakai tahun sekarang
        $activeFilter = $this->filter ?? date('Y');

        $orders = Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->whereYear('created_at', $activeFilter)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Mapping data ke 12 bulan (Jan - Des)
        $data = array_fill(0, 12, 0);
        foreach ($orders as $order) {
            $data[$order->month - 1] = $order->total;
        }

        $highestValue = count($data) > 0 ? max($data) : 0;

        // Logika skala dinamis sesuai keinginan Anda
        if ($highestValue <= 10) {
            $maxAxis = $highestValue > 0 ? $highestValue : 5;
            $stepSize = 1;
        } else {
            $maxAxis = min(ceil($highestValue / 10) * 10, 100);
            $stepSize = 10;
        }

        return [
            'datasets' => [
                [
                    'label' => "Total Pesanan Paket Tahun " . $activeFilter,
                    'data' => $data,
                    'borderColor' => '#EAB308',
                    'backgroundColor' => 'rgba(234, 179, 8, 0.1)',
                    'fill' => 'start',
                    'tension' => 0.4,
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            'customMax' => $maxAxis,
            'customStep' => $stepSize,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        $config = $this->getData();
        
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'max' => $config['customMax'], // Skala terkunci di pesanan tertinggi atau kelipatan 10
                    'ticks' => [
                        'stepSize' => $config['customStep'], // Kelipatan 1 atau 10 sesuai jumlah
                        'precision' => 0,
                    ],
                ],
            ],
        ];
    }
}