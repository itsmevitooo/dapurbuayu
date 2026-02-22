@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Detail Order</h2>
        <div class="h-1 w-20 bg-primary mx-auto mt-2"></div>
    </div>
    
    <div class="bg-white shadow-2xl rounded-3xl overflow-hidden lg:flex min-h-[600px] border border-gray-100">
        
        {{-- Sisi Kiri: Informasi Paket --}}
        <div class="lg:w-1/3 p-8 bg-gray-50 border-r border-gray-100 flex flex-col">
            <div class="sticky top-8">
                <h3 class="text-4xl font-black mb-6 text-gray-800 italic uppercase tracking-tighter">
                    {{ $package->name }}
                </h3>
                
                <div class="w-full h-64 overflow-hidden rounded-lg bg-gray-100 mb-6">
                    @if($package->image)
                        <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                             <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                             <span class="text-xs mt-2 uppercase">Gambar belum tersedia</span>
                        </div>
                    @endif
                </div>
        
                <div class="space-y-4">
                    <div class="bg-primary p-6 rounded-3xl text-white shadow-lg shadow-yellow-200">
                        <p class="text-xs uppercase font-black tracking-widest opacity-80 mb-1">Harga Satuan</p>
                        <p class="text-4xl font-black">Rp. {{ number_format($package->price, 0, ',', '.') }}</p>
                    </div>
                    <a href="{{ route('home') }}" class="flex items-center justify-center text-gray-500 hover:text-primary font-bold text-sm transition">← Kembali ke Beranda</a>
                </div>
            </div>
        </div>

        {{-- Sisi Kanan: Form --}}
        <div class="lg:w-2/3 p-8 lg:p-12">
            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                    <ul class="list-disc list-inside text-sm text-red-600 font-bold">
                        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('order.process_detail') }}" method="POST" class="space-y-10">
                @csrf
                <input type="hidden" name="package_id" value="{{ $package->id }}">

                {{-- 1. Pilihan Menu --}}
                <div class="space-y-6">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-wider italic">Isi Menu Paket</h3>
                    
                    <div class="bg-white border-2 border-dashed border-gray-200 rounded-3xl p-6">
                        <div class="space-y-6">
                            @php
                                // Pisahkan menu berdasarkan is_selectable
                                $fixedMenus = $package->details->where('is_selectable', false);
                                $optionalMenus = $package->details->where('is_selectable', true);
                            @endphp

                            {{-- Bagian Menu Tetap (Otomatis dapat) --}}
                            @if($fixedMenus->count() > 0)
                                <div>
                                    <p class="text-xs font-black text-gray-400 uppercase mb-3 tracking-widest">Menu Utama (Tetap)</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        @foreach($fixedMenus as $detail)
                                            {{-- Tambahkan looping untuk array name --}}
                                            @if(is_array($detail->name))
                                                @foreach($detail->name as $menuItem)
                                                    <div class="flex items-center p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="font-bold text-gray-700 text-sm">{{ $menuItem }}</span>
                                                        <input type="hidden" name="selections[]" value="{{ $menuItem }}">
                                                    </div>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Bagian Menu Opsional (Bisa Dipilih) --}}
                            @if($optionalMenus->count() > 0)
                                <div class="pt-4 border-t border-gray-100">
                                    <p class="text-xs font-black text-primary uppercase mb-4 tracking-widest">Pilih Lauk (Pilih salah satu per kategori)</p>
                                    
                                    @foreach($optionalMenus->groupBy('category') as $category => $items)
                                        <div class="mb-6 last:mb-0">
                                            <label class="text-sm font-bold text-gray-500 mb-3 block uppercase italic tracking-tight">{{ $category }}</label>
                                            
                                            {{-- Flex wrap agar tombol tidak panjang dan lebarnya sesuai teks --}}
                                            <div class="flex flex-wrap gap-3">
                                                @foreach($items as $detail)
                                                    @if(is_array($detail->name))
                                                        @foreach($detail->name as $menuItem)
                                                            <label class="relative cursor-pointer group">
                                                                {{-- Gunakan type="radio" dan name berdasarkan kategori agar hanya bisa pilih satu --}}
                                                                <input type="radio" 
                                                                    name="selections[{{ $category }}]" 
                                                                    value="{{ $menuItem }}" 
                                                                    class="peer hidden" 
                                                                    required>
                                                                
                                                                {{-- Desain Button: Tanpa lingkaran, lebar otomatis --}}
                                                                <div class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-100 rounded-2xl transition-all duration-200 
                                                                    peer-checked:border-primary peer-checked:bg-yellow-50 peer-checked:shadow-md
                                                                    group-hover:border-primary group-hover:bg-gray-50">
                                                                    
                                                                    <span class="font-bold text-gray-700 text-sm peer-checked:text-primary whitespace-nowrap">
                                                                        {{ $menuItem }}
                                                                    </span>
                                                                </div>
                                                            </label>
                                                        @endforeach
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            @if($package->details->count() == 0)
                                <div class="text-center py-4">
                                    <p class="text-gray-400 italic">Menu belum diinput di database.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                {{-- 2. Data Pengiriman --}}
                <div class="space-y-6">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-wider italic">Informasi Pengiriman</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-bold text-gray-700 mb-2">Nama Penerima</label><input type="text" name="full_name" required class="w-full rounded-2xl border-gray-200 p-4" placeholder="Nama lengkap"></div>
                        <div><label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp</label><input type="tel" name="phone_number" required class="w-full rounded-2xl border-gray-200 p-4" placeholder="0812xxxx"></div>
                    </div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label><textarea name="address" rows="3" required class="w-full rounded-2xl border-gray-200 p-4" placeholder="Alamat detail..."></textarea></div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengiriman</label>
                        <input type="date" name="delivery_date" required min="{{ \Carbon\Carbon::now()->addDays(2)->format('Y-m-d') }}" class="w-full rounded-2xl border-gray-200 p-4">
                    </div>
                </div>

                {{-- 3. Kuantitas --}}
                <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <label class="block text-xl font-black text-gray-800 mb-1">Kuantitas Pesanan</label>
                            <p class="text-xs text-gray-500 font-bold">Minimal: {{ $package->min_order ?? 1 }} Porsi.</p>
                        </div>
                        <div class="flex items-center bg-white p-2 rounded-2xl shadow-inner border border-gray-200">
                            <input type="number" name="quantity" min="{{ $package->min_order ?? 1 }}" value="{{ $package->min_order ?? 1 }}" required class="w-32 bg-transparent border-none text-center text-2xl font-black text-primary">
                            <span class="pr-4 text-gray-400 font-bold"> Porsi </span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white font-black py-6 rounded-3xl shadow-2xl transition-all hover:-translate-y-1">
                    Lanjutkan ke Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>
@endsection