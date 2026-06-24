@extends('layouts.app')

@push('styles')
    {{-- Pastikan Swiper CSS sudah ter-load dengan baik --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
        
        /* --- Hapus Animasi Hover --- */
        .btn-hover-anim {
            transition: none !important;
        }
        .btn-hover-anim:hover {
            transform: none;
        }

        /* Styling Swiper Khusus Mobile */
        .swiper-paket {
            width: 100%;
            padding: 20px 10px 50px 10px !important;
            margin-left: auto;
            margin-right: auto;
        }
        .swiper-paket .swiper-slide {
            height: auto !important;
            display: flex !important;
        }
        .swiper-button-next, .swiper-button-prev {
            color: #EAB308 !important;
            background: white;
            width: 40px; 
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 50;
            top: 40% !important;
            transition: none;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            transform: none;
            background: #fff;
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 16px !important; 
            font-weight: bold;
        }
        .pk-next { right: 0px !important; }
        .pk-prev { left: 0px !important; }
        .swiper-pagination-bullet-active { background: #EAB308 !important; }

        @media (max-width: 768px) {
            .swiper-paket { padding: 15px 5px 45px 5px !important; }
        }
        
        /* Kustom Flexbox Center agar satu baris persis memuat 3 card dengan lebar yang konsisten */
        .pc-kartu-tengah {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 2.5rem; /* Jarak antar card */
            max-width: 1250px;
            margin-left: auto;
            margin-right: auto;
        }
        .pc-kartu-tengah > div {
            width: 360px; /* Ukuran card konsisten */
        }

        /* --- Kustom Scrollbar Modern & Ramping --- */
        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 #f8fafc;
        }
        
        /* Untuk Chrome, Safari, Edge */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 10px;
        }
        
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }
    </style>
@endpush

@section('content')
<div class="max-w-[95%] mx-auto px-4 py-12">
    {{-- Header Judul --}}
    <div class="text-center mb-12">
        <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Menu Paket Kami</h2>
        <div class="h-1.5 w-24 bg-primary mx-auto mt-4 rounded-full"></div>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-6 font-bold">Pilih Kategori Hidangan Spesial Dapur Bu Ayu</p>
    </div>

    {{-- Tab Navigasi Kategori --}}
    <div class="flex flex-wrap justify-center gap-3 mb-16">
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
               class="px-8 py-3 rounded-full border-2 duration-300 font-bold uppercase text-[11px] tracking-widest font-inter btn-hover-anim
               {{ $category == $key 
                  ? 'bg-primary border-primary text-white shadow-lg' 
                  : 'border-gray-200 text-gray-400 hover:border-primary hover:text-primary bg-white' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- Tampilan Slider (Hanya Tampil di HP/Tablet, disembunyikan via md:hidden) --}}
    <div class="md:hidden relative px-4">
        <div class="swiper swiper-paket">
            <div class="swiper-wrapper">
                @forelse($pakets as $p)
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col w-full h-full">
                            <div class="h-48 overflow-hidden">
                                <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-full object-cover" alt="{{ $p->name }}">
                            </div>
                            <div class="p-6 flex flex-col flex-grow font-inter">
                                <h3 class="text-2xl font-bold mb-4 text-gray-800 uppercase italic text-center line-clamp-2">{{ $p->name }}</h3>
                                
                                {{-- Deskripsi Singkat Mobile --}}
                                @if(!empty($p->description))
                                    <p class="text-sm text-gray-600 mb-4 italic font-inter whitespace-pre-line leading-relaxed line-clamp-3">
                                        {!! nl2br(e($p->description)) !!}
                                    </p>
                                @endif

                                <div class="flex-grow">
                                    <ul class="text-sm text-gray-600 mb-6 space-y-1.5 h-32 overflow-y-auto custom-scrollbar italic text-left">
                                        @forelse($p->details as $detail)
                                            <li class="flex items-start">
                                                <span class="mr-2 text-primary">•</span>
                                                <span>
                                                    @if(is_array($detail->name))
                                                        {{ implode(', ', $detail->name) }}
                                                    @else
                                                        {{ $detail->name }}
                                                    @endif
                                                </span>
                                            </li>
                                        @empty
                                            <li class="text-gray-400 italic text-xs">Menu belum diinput</li>
                                        @endforelse
                                    </ul>
                                </div>
                                <div class="mt-auto pt-6 border-t border-gray-100">
                                    <p class="text-2xl font-black text-primary mb-4 text-center italic">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                                    <a href="{{ route('paket.detail', $p->id) }}" class="block w-full bg-slate-800 text-white font-bold py-3 rounded-full text-center uppercase text-[10px] tracking-widest shadow-md hover:bg-slate-900 transition-colors btn-hover-anim">
                                        Pilih Paket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    {{-- Kotak putih polos disembunyikan saat paket kosong pada slider mobile --}}
                    <div class="swiper-slide w-full py-20 text-center flex items-center justify-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-400 font-inter tracking-widest uppercase">Belum Ada Paket</h3>
                            <p class="text-gray-300 text-sm mt-2">Kami sedang menyiapkan menu terbaik.</p>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-button-next pk-next"></div>
            <div class="swiper-button-prev pk-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    {{-- Tampilan Desktop (Disembunyikan pada layar kecil via hidden md:flex) --}}
    <div class="hidden md:flex w-full py-4">
        <div class="pc-kartu-tengah">
            @forelse($pakets as $p)
                <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col h-full group">
                    <div class="h-48 overflow-hidden">
                        <img src="{{ asset('storage/' . $p->image) }}" class="w-full h-full object-cover duration-500 group-hover:scale-110" alt="{{ $p->name }}">
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow font-inter">
                        {{-- Judul Paket dipaksa rata tengah --}}
                        <h3 class="text-2xl font-bold mb-2 text-gray-800 uppercase italic text-center line-clamp-2">{{ $p->name }}</h3>
                        
                        {{-- Deskripsi dengan fungsi enter --}}
                        @if(!empty($p->description))
                            <p class="text-sm text-gray-600 mb-4 italic font-inter whitespace-pre-line leading-relaxed font-normal normal-case">
                                {!! nl2br(e($p->description)) !!}
                            </p>
                        @endif
                        
                        <div class="flex-grow">
                            <ul class="text-sm text-gray-600 mb-6 space-y-1.5 h-32 overflow-y-auto custom-scrollbar italic text-left">
                                @forelse($p->details as $detail)
                                    <li class="flex items-start">
                                        <span class="mr-2 text-primary">•</span>
                                        <span>
                                            @if(is_array($detail->name))
                                                {{ implode(', ', $detail->name) }}
                                            @else
                                                {{ $detail->name }}
                                            @endif
                                        </span>
                                    </li>
                                @empty
                                    <li class="text-gray-400 italic text-xs">Menu belum diinput</li>
                                @endforelse
                            </ul>
                        </div>

                        {{-- Bagian Harga & Tombol --}}
                        <div class="mt-auto pt-6 border-t border-gray-100">
                            <p class="text-2xl font-black text-primary mb-4 text-center italic">Rp {{ number_format($p->price, 0, ',', '.') }}</p>
                            <a href="{{ route('paket.detail', $p->id) }}" class="block w-full bg-slate-800 text-white font-bold py-3 rounded-full text-center uppercase text-[10px] tracking-widest shadow-md hover:bg-slate-900 transition-colors btn-hover-anim">
                                Pilih Paket
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                {{-- Teks polos saat kosong, tanpa border putus-putus atau background putih --}}
                <div class="w-full text-center py-20">
                    <h3 class="text-2xl font-bold text-gray-400 font-inter tracking-widest uppercase">Belum Ada Paket</h3>
                    <p class="text-gray-400 text-sm mt-2 font-inter">Kami sedang menyiapkan menu terbaik untuk kategori ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Swiper khusus halaman paket mobile
            new Swiper('.swiper-paket', {
                slidesPerView: 1, 
                spaceBetween: 20, 
                loop: false, 
                navigation: { 
                    nextEl: '.pk-next', 
                    prevEl: '.pk-prev' 
                }, 
                pagination: { 
                    el: '.swiper-paket .swiper-pagination', 
                    clickable: true 
                },
                breakpoints: {
                    768: { slidesPerView: 2, spaceBetween: 20 }
                }
            });
        });
    </script>
@endpush