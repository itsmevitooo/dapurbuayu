<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class OrderStats extends BaseWidget
{
    // Mengatur agar stats muncul paling atas (urutan 1)
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        return [
            Stat::make('Pesanan Hari Ini', Order::where('created_at', '>=', now()->startOfDay())->count())
                ->description('Total pesanan masuk hari ini')
                ->descriptionIcon('heroicon-m-shopping-cart')
                ->color('warning'), // Warna kuning khas Dapur Bu Ayu

            Stat::make('Pesanan Minggu Ini', Order::where('created_at', '>=', now()->startOfWeek())->count())
                ->description('Total pesanan dari hari Senin')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('success'),

            Stat::make('Pesanan Bulan Ini', Order::where('created_at', '>=', now()->startOfMonth())->count())
                ->description('Ringkasan performa bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('info'),
        ];
    }
}