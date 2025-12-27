@extends('layouts.app')

@section('content')
<div class="py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-xl p-8 border border-gray-100">
        <h1 class="text-3xl font-black text-center mb-8 uppercase text-gray-800 tracking-tight">Cek Pesanan</h1>

        {{-- Form Pencarian --}}
        <div class="mb-10">
            <form action="{{ route('check_order.search') }}" method="GET" class="flex flex-col md:flex-row gap-2">
                <input type="text" 
                       name="invoice_code" 
                       placeholder="Masukkan kode invoice Anda..." 
                       class="flex-grow px-6 py-4 rounded-2xl border-2 border-gray-100 focus:border-primary focus:ring-2 focus:ring-yellow-100 outline-none transition text-lg" 
                       value="{{ request('invoice_code') }}"
                       required>
                <button type="submit" class="bg-primary hover:bg-yellow-600 text-white px-10 py-4 rounded-2xl font-bold uppercase transition shadow-lg shadow-yellow-200">
                    Cek
                </button>
            </form>
        </div>

        <hr class="mb-10 border-gray-100">

        {{-- Menampilkan Hasil --}}
        @if (isset($order))
            <div class="animate-fade-in">
                <div class="bg-gray-50 rounded-3xl p-6 md:p-8 border border-gray-100">
                    <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-6">
                        <div>
                            <span class="text-xs font-bold text-primary uppercase">Invoice</span>
                            <h2 class="text-2xl font-black text-gray-800">{{ $order->invoice_code }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                Tanggal Kirim: <strong>{{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d F Y') }}</strong>
                            </p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <span class="px-4 py-1 rounded-full text-xs font-bold text-center {{ $order->payment_status == 'PAID' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                                PEMBAYARAN: {{ $order->payment_status }}
                            </span>
                            <span class="px-4 py-1 rounded-full text-xs font-bold text-center {{ $order->order_status == 'SELESAI' ? 'bg-blue-100 text-blue-700' : 'bg-gray-200 text-gray-700' }}">
                                STATUS: {{ $order->order_status }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 pt-6">
                        <h4 class="font-bold text-gray-800 mb-4">Detail Menu:</h4>
                        <ul class="space-y-3">
                            @foreach ($order->items as $item)
                                <li class="bg-white p-4 rounded-2xl border border-gray-100 flex justify-between items-center shadow-sm">
                                    <div>
                                        <p class="font-bold text-gray-700">{{ $item->item_name }}</p>
                                        <p class="text-xs text-gray-400 italic">Lauk: {{ $item->side_dish }}</p>
                                    </div>
                                    <span class="font-black text-primary">{{ $item->quantity }} Box</span>
                                </li>
                            @endforeach
                        </ul>
                        <div class="mt-6 text-right">
                            <p class="text-gray-500 text-sm">Total Pembayaran:</p>
                            <p class="text-2xl font-black text-primary font-mono">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif (session('error'))
            <div class="text-center p-6 bg-red-50 rounded-2xl border border-red-100">
                <p class="text-red-600 font-bold tracking-tight">Invoice tidak ditemukan. Silakan cek kembali kode Anda.</p>
            </div>
        @else
            <div class="text-center py-10">
                <p class="text-gray-400 italic">Masukkan kode invoice Anda untuk melihat status pesanan secara real-time.</p>
            </div>
        @endif
    </div>
</div>
@endsection