<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Cache;

class VisitorOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Ambil data dari cache memori sementara
        $todayCount = (int) Cache::get('counter_daily_' . date('Y-m-d'), 0);
        
        $weekKey = 'counter_week_' . now()->startOfWeek()->format('Y-m-d');
        $weeklyCount = (int) Cache::get($weekKey, 0);
        
        $monthKey = 'counter_month_' . date('Y-m');
        $monthlyCount = (int) Cache::get($monthKey, 0);

        return [
            Stat::make('Pengunjung Hari Ini', number_format($todayCount, 0, ',', '.') . ' Orang')
                ->description('Total kunjungan web hari ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Pengunjung Minggu Ini', number_format($weeklyCount, 0, ',', '.') . ' Orang')
                ->description('Total kunjungan web minggu ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('primary'),

            Stat::make('Pengunjung Bulan Ini', number_format($monthlyCount, 0, ',', '.') . ' Orang')
                ->description('Total kunjungan web bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('warning'),
        ];
    }
}