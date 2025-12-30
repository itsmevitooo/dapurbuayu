@extends('layouts.app')

@push('styles')
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
        [x-cloak] { display: none !important; }

        .swiper-button-next, .swiper-button-prev {
            color: #EAB308 !important;
            background: white;
            width: 40px; height: 40px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 50;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }
        
        .p-next, .r-next { right: 10px !important; }
        .p-prev, .r-prev { left: 10px !important; }
        .swiper-pagination-bullet-active { background: #EAB308 !important; }
        .swiper { width: 100%; padding: 20px 50px 40px 50px !important; }

        /* Style Pita & Rank */
        .ribbon-wrapper {
            width: 85px; height: 88px; overflow: hidden;
            position: absolute; top: -3px; left: -3px; z-index: 10;
        }
        .ribbon {
            font: bold 9px sans-serif; text-align: center;
            transform: rotate(-45deg); position: relative;
            padding: 7px 0; left: -25px; top: 15px; width: 120px;
            background-color: #EAB308; color: #fff;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            text-transform: uppercase;
        }
        .rank-badge {
            position: absolute; top: 10px; right: 10px;
            background: rgba(0,0,0,0.6); color: white;
            padding: 2px 10px; border-radius: 20px;
            font-size: 10px; font-weight: bold; backdrop-filter: blur(4px);
        }

        /* Memaksa slide swiper memiliki tinggi yang sama */
        .package-slider .swiper-slide { height: auto !important; display: flex; }
        
        /* Custom scrollbar halus untuk list menu */
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #EAB308; border-radius: 10px; }

        @media (max-width: 768px) {
            .swiper { padding: 15px 15px 45px 15px !important; }
        }
    </style>
@endpush

@section('content')
    <div x-data="{ openReview: false }">
        
        {{-- 1. Banner Utama --}}
        <section class="relative h-120 bg-cover bg-center rounded-lg shadow-xl mb-12" style="background-image: url('{{ asset('storage/banner.png') }}');">
            <div class="absolute inset-0 bg-black opacity-40 rounded-lg"></div>
            <div class="relative flex flex-col items-center justify-center h-full text-center">
                <h1 class="text-6xl md:text-8xl font-bold font-[Qwitcher_Grypen] mb-2 text-primary">Selamat Datang</h1>
                <p class="text-xs md:text-sm font-bold uppercase tracking-[0.3em] mb-8 font-inter text-white">Pesan katering terbaik untuk acara Anda.</p>
                <a href="#packages" class="bg-primary hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 uppercase text-xs tracking-widest">Order Sekarang</a>
            </div>
        </section>

    {{-- 2. Section Kenapa Memilih Kami (Tanpa Animasi) --}}
    <section class="mb-20 px-4 py-16 bg-primary rounded-3xl shadow-inner relative overflow-hidden">
        {{-- Dekorasi background statis --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white/20 rounded-full"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 bg-black/5 rounded-full"></div>

        <div class="relative z-10">
            <div class="text-center mb-12">
                <h2 class="text-5xl font-bold text-white font-[Qwitcher_Grypen]">Kenapa Memilih Kami?</h2>
                <div class="h-1.5 w-24 bg-white mx-auto mt-2 rounded-full"></div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                {{-- Card 1 --}}
                <div class="text-center p-8 bg-white rounded-3xl shadow-xl">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black mb-3 text-gray-800 uppercase tracking-tight">Bahan Berkualitas</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Kami hanya menggunakan bahan baku segar dan premium untuk setiap hidangan Anda.</p>
                </div>

                {{-- Card 2 --}}
                <div class="text-center p-8 bg-white rounded-3xl shadow-xl">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black mb-3 text-gray-800 uppercase tracking-tight">Tepat Waktu</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Pengiriman dijamin tepat waktu sesuai jadwal acara yang Anda tentukan.</p>
                </div>

                {{-- Card 3 --}}
                <div class="text-center p-8 bg-white rounded-3xl shadow-xl">
                    <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-black mb-3 text-gray-800 uppercase tracking-tight">Harga Terbaik</h3>
                    <p class="text-gray-500 text-sm leading-relaxed">Paket katering hemat dengan porsi melimpah dan rasa yang tak terlupakan.</p>
                </div>
            </div>
        </div>
    </section>

        {{-- 3. Section Paket Terlaris (DENGAN CARD PATEN) --}}
        <section id="packages" class="mb-12 py-10 bg-yellow-50 rounded-xl shadow-inner border border-yellow-100">
            <div class="text-center mb-4">
                <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Menu Terlaris</h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">Pilihan paket yang paling banyak dipesan pelanggan kami</p>
            </div>

            <div class="relative px-2 md:px-4">
                <div class="swiper package-slider">
                    <div class="swiper-wrapper">
                        @forelse($packages as $index => $package)
                        <div class="swiper-slide h-auto">
                            <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col h-full relative group w-full">
                                @if($index < 3)
                                <div class="ribbon-wrapper"><div class="ribbon">Best Seller</div></div>
                                <div class="rank-badge">RANK #{{ $index + 1 }}</div>
                                @endif

                                <div class="h-48 overflow-hidden">
                                    <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                </div>
                                
                                <div class="p-6 flex flex-col flex-grow font-inter relative bg-white">
                                    <h3 class="text-xl font-bold mb-3 text-gray-800 uppercase tracking-tight h-14 line-clamp-2">{{ $package->name }}</h3>
                                    <div class="flex-grow">
                                        <ul class="text-sm text-gray-600 mb-6 space-y-1 h-32 overflow-y-auto custom-scrollbar italic">
                                            @if(is_array($package->items))
                                                @foreach($package->items as $category)
                                                    @isset($category['menus'])
                                                        @foreach($category['menus'] as $menu) <li>• {{ $menu['name'] }}</li> @endforeach
                                                    @endisset
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="mt-auto pt-4 border-t border-gray-100 font-inter text-center">
                                        <p class="text-2xl font-black text-primary mb-4 italic">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                        <a href="{{ route('paket.detail', $package->id) }}" class="block w-full bg-primary text-white font-bold py-3 rounded-full uppercase text-[10px] tracking-widest transition-all hover:bg-yellow-600 shadow-md">Pilih Paket</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center w-full py-10 italic">Belum ada paket.</p>
                        @endforelse
                    </div>
                    <div class="swiper-button-next p-next"></div>
                    <div class="swiper-button-prev p-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        {{-- 4. Section Review Slider (FOTO SUDAH KEMBALI) --}}
        <section class="mb-12 px-4">
            <div class="flex flex-col md:flex-row justify-between items-end border-b-4 border-primary pb-4 mb-8 gap-4">
                <h2 class="text-5xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pelanggan</h2>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <a href="{{ url('/reviews') }}" class="flex-1 md:flex-none text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest transition border border-gray-200">Lihat Semua</a>
                    <button @click="openReview = true" class="flex-[2] md:flex-none bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest shadow-md transition">+ Tambah Review</button>
                </div>
            </div>
            
            <div class="relative px-2 md:px-4">
                <div class="swiper review-slider">
                    <div class="swiper-wrapper">
                        @forelse($reviews as $review)
                        <div class="swiper-slide">
                            <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-primary flex flex-col h-full w-full font-inter">
                                <div class="text-yellow-400 mb-2">
                                    @for($i = 1; $i <= 5; $i++) {!! $i <= $review->rating ? '★' : '<span class="text-gray-300">★</span>' !!} @endfor
                                </div>
                                <p class="italic text-gray-700 mb-4 flex-grow text-sm leading-relaxed">"{{ Str::limit($review->comment, 120) }}"</p>

                                {{-- Bagian Foto Review Pelanggan --}}
                                @if($review->image)
                                    <div class="flex gap-2 mb-4">
                                        @php
                                            $imgs = is_array($review->image) ? $review->image : json_decode($review->image, true);
                                            if(!$imgs && $review->image) $imgs = [$review->image];
                                        @endphp
                                        @if($imgs)
                                            @foreach(array_slice($imgs, 0, 3) as $img)
                                                <img src="{{ asset('storage/' . $img) }}" class="w-12 h-12 object-cover rounded-lg border border-gray-100 shadow-sm">
                                            @endforeach
                                        @endif
                                    </div>
                                @endif

                                <div class="flex items-center gap-2 pt-4 border-t border-gray-50">
                                    <div class="w-2 h-2 rounded-full bg-primary"></div>
                                    <small class="font-bold text-gray-600 uppercase tracking-widest text-[9px]">{{ $review->name }}</small>
                                </div>
                            </div>
                        </div>
                        @empty
                        <p class="text-center w-full py-10 italic text-gray-400">Belum ada review.</p>
                        @endforelse
                    </div>
                    <div class="swiper-button-next r-next"></div>
                    <div class="swiper-button-prev r-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        {{-- MODAL REVIEW (Silakan tempel kode modal Anda di sini) --}}

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.package-slider', {
                slidesPerView: 1, spaceBetween: 25,
                navigation: { nextEl: '.p-next', prevEl: '.p-prev' },
                pagination: { el: '.package-slider .swiper-pagination', clickable: true },
                breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
            new Swiper('.review-slider', {
                slidesPerView: 1, spaceBetween: 20, autoplay: { delay: 4000 },
                navigation: { nextEl: '.r-next', prevEl: '.r-prev' },
                pagination: { el: '.review-slider .swiper-pagination', clickable: true },
                breakpoints: { 768: { slidesPerView: 2 }, 1024: { slidesPerView: 3 } }
            });
        });
    </script>
@endsection