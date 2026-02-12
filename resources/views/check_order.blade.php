@extends('layouts.app')

@section('content')
<div class="py-8">
    {{-- Container Utama --}}
    <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-xl p-8 md:p-12 border border-gray-50 print:shadow-none print:border-none print:p-0">
        
        {{-- Header Judul - Sembunyi saat cetak --}}
        <div class="text-center mb-12 no-print">
            <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Cek Pesanan Anda</h2>
            <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-4 font-bold">Pantau Status Hidangan Spesial Dapur Bu Ayu</p>
        </div>

        {{-- Form Pencarian - Sembunyi saat cetak --}}
        <div class="mb-12 no-print">
            <form action="{{ route('check_order.search') }}" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" 
                           name="invoice_code" 
                           placeholder="Masukkan kode invoice (Contoh: INV-XXXX)..." 
                           class="w-full px-8 py-5 rounded-2xl border-none bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary outline-none transition text-lg font-medium placeholder:text-gray-400 shadow-inner" 
                           value="{{ request('invoice_code') }}"
                           required>
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-primary text-white px-12 py-5 rounded-2xl font-bold uppercase text-xs tracking-[0.2em] transition-all duration-300 shadow-lg active:scale-95">
                    Cek Sekarang
                </button>
            </form>
        </div>

        {{-- Garis Pemisah - Sembunyi saat cetak --}}
        <div class="relative flex py-5 items-center no-print">
            <div class="flex-grow border-t border-gray-100"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-widest">Hasil Pencarian</span>
            <div class="flex-grow border-t border-gray-100"></div>
        </div>

        {{-- Menampilkan Hasil --}}
        @if (isset($order))
            <div class="animate-fade-in mt-8 print:mt-0 print:animate-none">
                <div id="print-area" class="bg-white rounded-[2rem] p-6 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden print:border-none print:p-0">
                    
                    {{-- Header Invoice --}}
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6 mb-8 relative z-10 print:flex-row print:mb-6">
                        <div>
                            <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full mb-3 print:border print:border-primary">Invoice Resmi</span>
                            <h2 class="text-3xl font-bold text-gray-800 font-inter">{{ $order->invoice_code }}</h2>
                            <p class="text-sm text-gray-500 mt-2 flex items-center">
                                <span class="mr-2 no-print">📅</span> Tanggal Kirim: <strong class="ml-1 text-gray-700">{{ \Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d F Y') }}</strong>
                            </p>
                        </div>
                        <div class="flex flex-wrap md:flex-col gap-3 print:items-end">
                            <span class="px-6 py-2 rounded-xl text-[10px] font-black tracking-widest text-center shadow-sm {{ $order->payment_status == 'PAID' || $order->payment_status == 'LUNAS' ? 'bg-green-500 text-white' : 'bg-orange-400 text-white' }} print:text-black print:border print:border-gray-300">
                                STATUS BAYAR: {{ $order->payment_status }}
                            </span>
                            <span class="px-6 py-2 rounded-xl text-[10px] font-black tracking-widest text-center bg-gray-100 text-gray-600 shadow-sm border border-gray-200 print:text-black">
                                STATUS ORDER: {{ $order->order_status }}
                            </span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-200 pt-8 print:pt-4">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6 print:mb-3">Rincian Pesanan</h4>
                        <div class="space-y-4">
                            @foreach ($order->items as $item)
                                <div class="group bg-gray-50/50 p-5 rounded-2xl border border-transparent flex justify-between items-start print:bg-white print:border-b print:rounded-none print:px-0">
                                    <div class="flex-grow">
                                        <p class="font-bold text-gray-800 text-lg">{{ $item->item_name }}</p>
                                        
                                        {{-- LOGIKA PEMANGGILAN MENU --}}
                                        <div class="mt-2">
                                            <p class="text-[10px] font-bold uppercase text-gray-400 mb-1 print:text-black">Pilihan Menu:</p>
                                            <ul class="text-xs text-gray-600 italic space-y-1 list-disc ml-4">
                                                {{-- Cek jika data side_dish adalah array (JSON) atau string --}}
                                                @if(is_array($item->side_dish))
                                                    @foreach($item->side_dish as $lauk)
                                                        <li>{{ $lauk }}</li>
                                                    @endforeach
                                                @elseif(!empty($item->side_dish))
                                                    {{-- Jika string dipisah koma, kita pecah jadi list --}}
                                                    @foreach(explode(',', $item->side_dish) as $lauk)
                                                        <li>{{ trim($lauk) }}</li>
                                                    @endforeach
                                                @else
                                                    <li class="list-none ml-0 text-gray-400 font-normal">Tidak ada pilihan menu tambahan.</li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>

                                    <div class="text-right ml-4">
                                        <div class="mb-1">
                                            <span class="text-lg font-black text-gray-900">{{ $item->quantity }}</span>
                                            <span class="text-[10px] font-bold text-gray-400 uppercase ml-1">Box</span>
                                        </div>
                                        <p class="text-[10px] text-gray-400 font-medium">
                                            Rp {{ number_format($item->price, 0, ',', '.') }} / box
                                        </p>
                                        <p class="text-sm font-bold text-gray-700 mt-1">
                                            Total: Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        {{-- Total Biaya --}}
                        <div class="mt-10 p-8 bg-gray-900 rounded-[2rem] text-white flex flex-col md:flex-row justify-between items-center gap-4 print:bg-white print:text-black print:border-t-2 print:border-gray-900 print:rounded-none print:mt-6 print:px-0">
                            <div>
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1 print:text-black">Total Keseluruhan</p>
                                <p class="text-3xl font-bold text-primary italic font-inter print:text-black print:not-italic">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <button onclick="window.print()" class="bg-white/10 hover:bg-white/20 text-white text-[10px] font-bold py-3 px-6 rounded-xl uppercase tracking-widest transition no-print">
                                🖨️ Cetak Bukti Pesanan
                            </button>
                        </div>
                    </div>

                    <div class="hidden print:block mt-8 text-center text-[10px] text-gray-400">
                        <p>Terima kasih telah memesan di Dapur Bu Ayu.</p>
                        <p>Dicetak pada: {{ now()->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        @elseif (session('error'))
            <div class="text-center p-10 bg-red-50 rounded-[2rem] border border-red-100 mt-8">
                <div class="text-red-400 mb-4 text-4xl">⚠️</div>
                <h3 class="text-red-600 font-bold text-lg">Invoice Tidak Ditemukan</h3>
                <p class="text-red-400 text-sm mt-1 uppercase tracking-tighter font-bold">Pastikan kode invoice benar.</p>
            </div>
        @else
            <div class="text-center py-16 opacity-40 no-print">
                <p class="text-gray-700 font-medium italic">Silakan masukkan kode invoice di atas...</p>
            </div>
        @endif
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&family=Inter:wght@400;700;900&display=swap');
    
    .animate-fade-in { animation: fadeIn 0.6s ease-out forwards; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    @media print {
        .no-print, header, nav, footer, .form-pencarian { display: none !important; }
        body { background: white !important; }
        .max-w-4xl { max-width: 100% !important; width: 100% !important; box-shadow: none !important; border: none !important; }
        .text-primary { color: #000 !important; }
        * { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    }
</style>
@endsection