<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class TrackVisitorSession
{
    public function handle(Request $request, Closure $next)
    {
        // Ambil IP address unik pengunjung
        $ip = $request->ip();
        
        // Buat kunci unik untuk hari ini
        $cacheKey = 'visitor_' . date('Y-m-d') . '_' . md5($ip);

        // Simpan ke cache selama 24 jam (tidak membebani database sama sekali)
        if (!Cache::has($cacheKey)) {
            Cache::put($cacheKey, true, now()->addDay());
            
            // Tambahkan counter harian secara global di memori
            $dailyCount = (int) Cache::get('counter_daily_' . date('Y-m-d'), 0);
            Cache::put('counter_daily_' . date('Y-m-d'), $dailyCount + 1, now()->addDay());

            // Tambahkan counter mingguan
            $weekKey = 'counter_week_' . now()->startOfWeek()->format('Y-m-d');
            $weeklyCount = (int) Cache::get($weekKey, 0);
            Cache::put($weekKey, $weeklyCount + 1, now()->addWeek());

            // Tambahkan counter bulanan
            $monthKey = 'counter_month_' . date('Y-m');
            $monthlyCount = (int) Cache::get($monthKey, 0);
            Cache::put($monthKey, $monthlyCount + 1, now()->addMonth());
        }

        return $next($request);
    }
}