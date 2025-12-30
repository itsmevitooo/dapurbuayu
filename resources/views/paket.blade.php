@extends('layouts.app')

@section('content')
<div class="max-w-[95%] mx-auto px-4 py-4">
    {{-- Header Judul (Tanpa Animasi) --}}
    <div class="text-center mb-10">
        <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Menu Paket Kami</h2>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Pilih Kategori Hidangan Spesial Dapur Bu Ayu</p>
    </div>

    {{-- Tab Navigasi Kategori --}}
    <div class="flex flex-wrap justify-center gap-3 mb-10">
        @php
            $categories = [
                'nasi_box' => 'Nasi Box',
                'prasmanan' => 'Prasmanan',
                'tumpeng' => 'Tumpeng',
                'akikah' => 'Akikah'
            ];
        @endphp

        @foreach($categories as $key => $label)
            <a href="{{ route('paket.index', ['category' => $key]) }}" 
               class="px-8 py-3 rounded-full border-2 transition-all duration-500 font-bold uppercase text-[11px] tracking-widest font-inter
               {{ $category == $key 
                  ? 'bg-primary border-primary text-white shadow-md scale-105' 
                  : 'border-gray-100 text-gray-400 hover:border-primary/50 hover:text-primary bg-white' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Grid Produk --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        @forelse($pakets as $p)
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col w-full h-full transition-transform hover:scale-[1.02] duration-300">
                {{-- Foto Produk --}}
                <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-48 object-cover" alt="{{ $p->name }}">
                
                <div class="p-6 flex flex-col flex-grow font-inter">
                    {{-- Nama Paket --}}
                    <h3 class="text-2xl font-bold mb-3 text-gray-800 uppercase italic">{{ $p->name }}</h3>
                    
                    {{-- Daftar Menu / Lauk --}}
                    <div class="flex-grow">
                        <ul class="text-sm text-gray-600 mb-6 space-y-1">
                            @if(is_array($p->items))
                                @foreach($p->items as $categoryItem)
                                    @isset($categoryItem['menus'])
                                        @foreach($categoryItem['menus'] as $menu) 
                                            <li>• {{ $menu['name'] }}</li> 
                                        @endforeach
                                    @endisset
                                @endforeach
                            @endif
                        </ul>
                    </div>

                    {{-- Bagian Harga & Tombol --}}
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-2xl font-extrabold text-primary mb-4 text-center">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                        <a href="{{ route('paket.detail', $p->id) }}" class="block w-full bg-primary text-white font-bold py-3 rounded-full text-center uppercase text-[10px] tracking-widest shadow-md hover:bg-yellow-600 transition-colors">
                            Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20 bg-white rounded-xl border-2 border-dashed border-gray-100">
                <h3 class="text-xl font-bold text-gray-400 font-inter tracking-widest uppercase">Belum Ada Paket</h3>
                <p class="text-gray-300 text-sm mt-1">Kami sedang menyiapkan menu terbaik untuk kategori ini.</p>
            </div>
        @endforelse
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
</style>
@endsection