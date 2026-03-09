@extends('layouts.app')

@section('content')
<style>
    @media print {
        body * { visibility: hidden; }
        #print-area, #print-area * { visibility: visible; }
        #print-area {
            position: absolute; left: 0; top: 0; width: 100%;
            border: none !important; box-shadow: none !important;
            padding: 0 !important; margin: 0 !important;
        }
        .no-print { display: none !important; }
        @page { margin: 0.5cm; }
    }
    /* Animasi sederhana */
    .animate-fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

{{-- Masukkan Script Midtrans Snap --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>

<div class="py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-xl p-8 md:p-12 border border-gray-50 print:shadow-none print:border-none print:p-0">
        
        {{-- Header Form --}}
        <div class="text-center mb-12 no-print">
            <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Cek Pesanan Anda</h2>
            <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-4 font-bold">Pantau Status Hidangan Spesial Dapur Bu Ayu</p>
        </div>

        <div class="mb-12 no-print">
            <form action="{{ route('check_order.search') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" name="invoice_code" placeholder="Masukkan kode invoice (INV-XXXX)..." class="w-full px-8 py-5 rounded-2xl border-none bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary outline-none transition text-lg font-medium shadow-inner" value="{{ request('invoice_code') }}" required>
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-primary text-white px-12 py-5 rounded-2xl font-bold uppercase text-xs tracking-[0.2em] transition-all active:scale-95">
                    Cek Sekarang
                </button>
            </form>
        </div>

        @if (isset($order))
            <div class="animate-fade-in mt-8 print:mt-0">
                <div id="print-area" class="bg-white rounded-[2rem] p-6 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden print:border-none print:p-0">
                    
                    <div class="flex flex-row justify-between items-start mb-10 border-b border-gray-100 pb-8 print:mb-6">
                        <div>
                            <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full mb-3 print:border">Invoice Resmi</span>
                            <h2 class="text-4xl font-black text-gray-800 tracking-tighter">{{ $order->invoice_code }}</h2>
                            <p class="text-sm text-gray-500 mt-2 font-medium">
                                Tanggal Kirim: <strong class="text-gray-800">{{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d F Y') }}</strong>
                            </p>
                        </div>
                        
                        {{-- STATUS SECTION --}}
                        <div class="flex flex-col items-end gap-4 text-right">
                            <div class="flex flex-col gap-1.5">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Status Pembayaran</p>
                                <span class="inline-block w-32 py-2.5 rounded-xl text-[10px] font-black tracking-widest uppercase text-center {{ in_array(strtoupper($order->payment_status), ['PAID', 'LUNAS', 'SUCCESS']) ? 'bg-green-500 text-white' : 'bg-orange-400 text-white' }} print:border print:text-black">
                                    {{ $order->payment_status }}
                                </span>
                            </div>
                            <div class="flex flex-col gap-1.5">
                                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Status Pesanan</p>
                                <span class="inline-block w-32 py-2.5 rounded-xl text-[10px] font-black tracking-widest uppercase text-center bg-gray-100 text-gray-600 border border-gray-200 print:text-black">
                                    {{ $order->order_status }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 print:mb-4">Rincian Paket</h4>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="group bg-gray-50/50 p-6 rounded-2xl flex justify-between items-center print:bg-white print:border-b print:rounded-none print:px-0">
                                    <div class="flex-grow">
                                        <p class="text-[10px] font-bold uppercase text-primary mb-1 print:text-black">Nama Paket:</p>
                                        <p class="font-black text-gray-800 text-2xl uppercase tracking-tight">
                                            {{ $item->item_name }}
                                        </p>
                                        <p class="text-[10px] text-gray-500 mt-1 font-medium">
                                            Menu: 
                                            <span class="italic text-gray-400">
                                                {{-- REVISI DI SINI: Mengatasi error Array to String conversion --}}
                                                @if(is_array($item->side_dish))
                                                    {{ implode(', ', $item->side_dish) }}
                                                @else
                                                    {{ $item->side_dish ?? 'Standar' }}
                                                @endif
                                            </span>
                                        </p>
                                    </div>

                                    <div class="text-right ml-4">
                                        <div class="mb-1">
                                            <span class="text-3xl font-black text-gray-900">{{ $item->quantity }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase ml-1">Box</span>
                                        </div>
                                        <p class="text-sm font-bold text-primary mt-1">Subtotal: Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- SEKSI PEMBAYARAN & PRINT --}}
                        <div class="mt-12 p-8 bg-gray-900 rounded-[2.5rem] text-white flex flex-col md:flex-row justify-between items-center gap-6 print:bg-white print:text-black print:border-t-2 print:border-gray-900 print:rounded-none print:px-0">
                            <div class="text-center md:text-left">
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1 print:text-black">Total Pembayaran</p>
                                <p class="text-4xl font-black text-primary italic font-inter print:text-black print:not-italic">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto no-print">
                                {{-- TOMBOL BAYAR --}}
                                @if(strtoupper($order->payment_status) == 'PENDING' && $order->snap_token)
                                    <button id="pay-button" class="bg-orange-500 hover:bg-orange-600 text-white text-[10px] font-bold py-4 px-10 rounded-2xl uppercase tracking-[0.2em] transition shadow-lg flex items-center justify-center gap-2">
                                        💳 Bayar Sekarang
                                    </button>
                                @endif

                                <button onclick="window.print()" class="bg-white/10 hover:bg-white/20 text-white text-[10px] font-bold py-4 px-8 rounded-2xl uppercase tracking-[0.2em] transition border border-white/20">
                                    🖨️ Cetak Bukti
                                </button>
                            </div>
                        </div>
                        
                        <div class="hidden print:block mt-10 text-center">
                            <p class="text-[10px] text-gray-400 font-bold uppercase tracking-[0.3em]">Terima Kasih Telah Memilih Dapur Bu Ayu</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Script untuk Handle Snap Midtrans --}}
            @if($order->snap_token)
            <script type="text/javascript">
                const payButton = document.getElementById('pay-button');
                if(payButton) {
                    payButton.onclick = function () {
                        window.snap.pay('{{ $order->snap_token }}', {
                            onSuccess: function (result) {
                                window.location.href = "{{ route('order.success') }}";
                            },
                            onPending: function (result) {
                                location.reload();
                            },
                            onError: function (result) {
                                alert("Pembayaran gagal, silakan coba lagi.");
                            },
                            onClose: function () {
                                console.log('customer closed the popup without finishing the payment');
                            }
                        });
                    };
                }
            </script>
            @endif

        @elseif (session('error') || request()->has('invoice_code'))
            <div class="text-center p-10 bg-red-50 rounded-[2rem] border border-red-100 mt-8 no-print">
                <p class="text-red-600 font-bold">⚠️ {{ session('error') ?? 'Pesanan tidak ditemukan. Periksa kembali kode invoice Anda.' }}</p>
            </div>
        @endif
    </div>
</div>
@endsection