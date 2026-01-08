@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-20 text-center">
    <div class="bg-white p-12 rounded-[3rem] shadow-2xl border border-gray-100">
        <div class="w-24 h-24 bg-green-100 text-green-600 rounded-full flex items-center justify-center mx-auto mb-8 shadow-inner">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        
        <h1 class="text-4xl font-black text-gray-900 mb-4 tracking-tight uppercase italic">Pesanan Berhasil!</h1>
        <p class="text-gray-500 text-lg mb-10 max-w-md mx-auto leading-relaxed">
            Terima kasih! Pesanan Anda telah kami terima dan sedang diproses oleh tim <span class="text-primary font-bold italic">Dapur Bu Ayu</span>.
        </p>

        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('home') }}" class="px-8 py-4 bg-gray-900 text-white font-black rounded-2xl hover:bg-black transition-all shadow-xl">
                KEMBALI KE BERANDA
            </a>
            <a href="{{ route('check_order.index') }}" class="px-8 py-4 bg-primary text-white font-black rounded-2xl hover:bg-yellow-600 transition-all shadow-xl shadow-yellow-100">
                CEK STATUS PESANAN
            </a>
        </div>
    </div>
</div>
@endsection