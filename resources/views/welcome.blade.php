@extends('layouts.app')

@push('styles')
    {{-- Alpine.js & Swiper.js --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');

        [x-cloak] { display: none !important; }

        /* Desain Tombol Navigasi Umum */
        .swiper-button-next, .swiper-button-prev {
            color: #EAB308 !important;
            background: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            z-index: 50;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
        }
        
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 16px;
            font-weight: bold;
        }

        .p-next, .r-next { right: 10px !important; }
        .p-prev, .r-prev { left: 10px !important; }

        .swiper-pagination-bullet-active {
            background: #EAB308 !important;
        }

        .swiper {
            width: 100%;
            padding: 20px 50px 40px 50px !important;
        }

        .swiper-slide {
            height: auto !important;
            display: flex;
            justify-content: center;
        }

        /* PENYESUAIAN UNTUK MOBILE (HP) */
        @media (max-width: 768px) {
            .swiper { 
                padding: 15px 15px 45px 15px !important; 
            }
            
            .swiper-button-next, .swiper-button-prev { 
                display: flex !important;
                width: 32px;
                height: 32px;
                background: rgba(255, 255, 255, 0.9);
            }

            .swiper-button-next:after, .swiper-button-prev:after {
                font-size: 12px;
            }

            .p-next, .r-next { right: 5px !important; }
            .p-prev, .r-prev { left: 5px !important; }
        }
    </style>
@endpush

@section('content')
    <div x-data="{ openReview: false }">
        
        {{-- 1. Banner Utama --}}
        <section class="relative h-120 bg-cover bg-center rounded-lg shadow-xl mb-12" style="background-image: url('{{ asset('storage/banner.png') }}');">
            <div class="absolute inset-0 bg-black opacity-40 rounded-lg"></div>
            <div class="relative flex flex-col items-center justify-center h-full text-center">
                {{-- Text Kuning Sesuai Request --}}
                <h1 class="text-6xl md:text-8xl font-bold font-[Qwitcher_Grypen] mb-2 text-primary">Selamat Datang</h1>
                {{-- Text Putih Sesuai Request --}}
                <p class="text-xs md:text-sm font-bold uppercase tracking-[0.3em] mb-8 font-inter text-white">Pesan katering terbaik untuk acara Anda.</p>
                <a href="#packages" class="bg-primary hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 uppercase text-xs tracking-widest">Order Sekarang</a>
            </div>
        </section>

        {{-- 2. Kenapa Memilih Kami --}}
        <section class="mb-12 py-7 bg-primary rounded-lg shadow-xl">
            <div class="max-w-6xl mx-auto px-4 py-8 text-white text-center">
                <h2 class="text-5xl font-bold font-[Qwitcher_Grypen] mb-10">Kenapa memilih kami</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-gray-900 font-inter">
                    <div class="bg-white p-8 rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-105">
                        <svg class="h-12 w-12 mb-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <h3 class="font-bold uppercase tracking-widest text-xs">Pemesanan Mudah</h3>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-105">
                        <svg class="h-12 w-12 mb-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.757c1.246 0 2.25 1.004 2.25 2.25v.75m-11 5h-4.5V9h4.5m11 4l-4 4H9m11-4V9c0-1.246-1.004-2.25-2.25-2.25H14l-2-4H9L7 9H4v11h14l2-4" /></svg>
                        <h3 class="font-bold uppercase tracking-widest text-xs">Kualitas Terbaik</h3>
                    </div>
                    <div class="bg-white p-8 rounded-xl shadow-lg flex flex-col items-center transition-transform hover:scale-105">
                        <svg class="h-12 w-12 mb-4 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0" /></svg>
                        <h3 class="font-bold uppercase tracking-widest text-xs">Pengiriman Cepat</h3>
                    </div>
                </div>
            </div>
        </section>

        {{-- 3. Section Paket Slider --}}
        <section id="packages" class="mb-12 py-8 bg-yellow-50 rounded-lg shadow-inner">
            <h2 class="text-6xl font-bold text-primary text-center font-[Qwitcher_Grypen] mb-8">Paket yang tersedia</h2>
            <div class="relative px-2 md:px-4">
                <div class="swiper package-slider">
                    <div class="swiper-wrapper">
                        @forelse($packages as $package)
                        <div class="swiper-slide">
                            <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col w-full">
                                <img src="{{ asset('storage/' . $package->image) }}" class="w-full h-48 object-cover">
                                <div class="p-6 flex flex-col flex-grow font-inter">
                                    <h3 class="text-xl font-bold mb-3 text-gray-800 uppercase tracking-tight">{{ $package->name }}</h3>
                                    <div class="flex-grow">
                                        <ul class="text-sm text-gray-600 mb-6 space-y-1">
                                            @if(is_array($package->items))
                                                @foreach($package->items as $category)
                                                    @isset($category['menus'])
                                                        @foreach($category['menus'] as $menu) <li>• {{ $menu['name'] }}</li> @endforeach
                                                    @endisset
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                    <div class="mt-4 pt-4 border-t border-gray-100 font-inter">
                                        <p class="text-2xl font-black text-primary mb-4 text-center italic">Rp {{ number_format($package->price, 0, ',', '.') }}</p>
                                        <a href="{{ route('paket.detail', $package->id) }}" class="block w-full bg-primary text-white font-bold py-3 rounded-full text-center uppercase text-[10px] tracking-widest transition-all hover:bg-yellow-600">Pilih Paket</a>
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

        {{-- 4. Section Review Slider --}}
        <section class="mb-12 px-4">
            <div class="flex justify-between items-center border-b-4 border-primary pb-2 mb-6">
                <h2 class="text-4xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pelanggan</h2>
                <button @click="openReview = true" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded-full text-xs md:text-[10px] uppercase tracking-widest shadow-md transition">
                    + Tambah Review
                </button>
            </div>
            
            <div class="relative px-2 md:px-4">
                <div class="swiper review-slider">
                    <div class="swiper-wrapper">
                        @forelse($reviews as $review)
                        <div class="swiper-slide">
                            <div class="bg-white p-6 rounded-lg shadow-lg border-t-4 border-primary flex flex-col h-full w-full font-inter">
                                <div class="text-yellow-400 mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        {!! $i <= $review->rating ? '★' : '<span class="text-gray-300">★</span>' !!}
                                    @endfor
                                </div>
                                <p class="italic text-gray-700 mb-3 flex-grow text-sm md:text-base leading-relaxed">"{{ $review->comment }}"</p>
                                <small class="font-bold text-gray-600 uppercase border-t pt-3 tracking-widest text-[10px]">- {{ $review->name }}</small>
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

        {{-- 5. MODAL TAMBAH REVIEW --}}
        <div x-show="openReview" 
             class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm" 
             x-cloak 
             x-transition>
            <div @click.away="openReview = false" class="bg-white w-full max-w-md rounded-2xl shadow-2xl p-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-3xl font-bold text-primary font-[Qwitcher_Grypen]">Tulis Review</h3>
                    <button @click="openReview = false" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                </div>

                <form action="{{ route('reviews.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4 font-inter">
                    @csrf
                    <div>
                        <label class="block text-[9px] font-bold uppercase text-gray-400 mb-1 ml-1 tracking-widest">Nama Anda</label>
                        <input type="text" name="name" placeholder="Contoh: Budi Santoso" required class="w-full border-none bg-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-primary text-sm">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold uppercase text-gray-400 mb-1 ml-1 tracking-widest">Rating</label>
                        <select name="rating" class="w-full border-none bg-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-primary text-sm">
                            <option value="5">⭐⭐⭐⭐⭐ Sangat Puas</option>
                            <option value="4">⭐⭐⭐⭐ Puas</option>
                            <option value="3">⭐⭐⭐ Cukup</option>
                            <option value="2">⭐⭐ Kurang</option>
                            <option value="1">⭐ Buruk</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold uppercase text-gray-400 mb-1 ml-1 tracking-widest">Gambar / Foto (Opsional)</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-primary file:text-white hover:file:bg-yellow-600 cursor-pointer bg-gray-100 rounded-xl p-2">
                    </div>
                    <div>
                        <label class="block text-[9px] font-bold uppercase text-gray-400 mb-1 ml-1 tracking-widest">Komentar</label>
                        <textarea name="comment" rows="3" placeholder="Ceritakan pengalaman Anda..." required class="w-full border-none bg-gray-100 rounded-xl p-3 focus:ring-2 focus:ring-primary text-sm"></textarea>
                    </div>
                    <button type="submit" class="w-full bg-primary text-white font-bold py-4 rounded-xl uppercase text-xs tracking-widest shadow-lg hover:bg-yellow-600 transition duration-300">
                        Kirim Review
                    </button>
                </form>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new Swiper('.package-slider', {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: { nextEl: '.p-next', prevEl: '.p-prev' },
                pagination: { el: '.package-slider .swiper-pagination', clickable: true },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });

            new Swiper('.review-slider', {
                slidesPerView: 1,
                spaceBetween: 20,
                autoplay: { delay: 4000 },
                navigation: { nextEl: '.r-next', prevEl: '.r-prev' },
                pagination: { el: '.review-slider .swiper-pagination', clickable: true },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1024: { slidesPerView: 3 }
                }
            });
        });
    </script>
@endsection