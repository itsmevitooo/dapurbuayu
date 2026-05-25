@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div x-data="{ 
    openGridModal: false,
    openCarouselModal: false, 
    currentIndex: 0,
    currentCategory: '',
    photos: [],
    gridPage: 1,
    photosPerPage: 6,

    get totalGridPages() { return Math.ceil(this.photos.length / this.photosPerPage) || 1; },
    get pagedPhotos() {
        let start = (this.gridPage - 1) * this.photosPerPage;
        return this.photos.slice(start, start + this.photosPerPage);
    },
    
    openGrid(categoryName, photoArray) {
        this.currentCategory = categoryName;
        this.photos = photoArray;
        this.gridPage = 1;
        this.openGridModal = true;
    },
    
    openPhotoDetail(index, categoryName, photoArray) {
        this.currentCategory = categoryName;
        this.photos = photoArray;
        this.currentIndex = index;
        this.openCarouselModal = true;
    },
    
    nextPhoto() { if (this.currentIndex < this.photos.length - 1) this.currentIndex++; else this.currentIndex = 0; },
    prevPhoto() { if (this.currentIndex > 0) this.currentIndex--; else this.currentIndex = this.photos.length - 1; }
}" 
class="py-12 px-4 max-w-7xl mx-auto"
@keydown.window.escape="openCarouselModal = false; if(!openCarouselModal) openGridModal = false"
@keydown.window.arrow-right="if(openCarouselModal) nextPhoto()"
@keydown.window.arrow-left="if(openCarouselModal) prevPhoto()">

    <div class="text-center mb-16">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Galeri Kami</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Koleksi Foto Hidangan dan Momen Spesial</p>
    </div>

    @php $groupedGalleries = $galleries->groupBy('category'); @endphp

    @forelse($groupedGalleries as $category => $items)
        @php
            // BAGIAN YANG DIUPDATE: Mengambil data langsung dari relasi gallery
            $categoryPhotosArr = $items->map(function($item) {
                return [
                    'src' => asset('storage/' . $item->image),
                    'title' => $item->title ?? 'Galeri Dapur Bu Ayu',
                    'category' => $item->category,
                    'is_customer' => $item->category == 'testimoni pelanggan',
                    'rating' => $item->review ? (int)$item->review->rating : 5,
                    'comment' => $item->review ? $item->review->comment : 'Tidak ada komentar',
                    'author' => $item->review ? $item->review->name : 'Pelanggan Dapur Bu Ayu'
                ];
            })->toArray();
        @endphp

        <div class="mb-20 relative group-section">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-wider flex items-center flex-1">
                    {{ $category }}
                    <span class="hidden md:block flex-1 h-px bg-gray-200 ml-6"></span>
                </h2>
                <button @click="openGrid('{{ $category }}', {{ json_encode($categoryPhotosArr) }})" 
                        class="px-6 py-3 bg-[#F1B168] hover:bg-[#E29A4D] text-white rounded-full font-inter text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition shadow-md">
                    <span>Lihat Semua Foto</span>
                </button>
            </div>
            
            <div class="swiper mySwiper-{{ Str::slug($category) }} overflow-visible">
                <div class="swiper-wrapper">
                    @foreach($categoryPhotosArr as $index => $photo)
                        <div class="swiper-slide">
                            <div class="group relative overflow-hidden rounded-[2rem] shadow-sm bg-white cursor-pointer h-full"
                                 @click="openPhotoDetail({{ $index }}, '{{ $category }}', {{ json_encode($categoryPhotosArr) }})">
                                <div class="aspect-square overflow-hidden">
                                    <img src="{{ $photo['src'] }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @empty
        <div class="text-center py-20 bg-gray-50 rounded-[3rem]">
            <p class="text-gray-400 italic text-lg tracking-widest uppercase font-bold">Belum ada koleksi foto.</p>
        </div>
    @endforelse

    {{-- MODAL GRID --}}
    <div x-show="openGridModal" class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/70 backdrop-blur-md" @click="openGridModal = false" x-cloak>
        <div class="bg-white rounded-[2.5rem] max-w-5xl w-full p-8" @click.stop>
            <h3 class="text-xl font-black uppercase mb-4" x-text="'Foto ' + currentCategory"></h3>
            <div class="grid grid-cols-2 md:grid-cols-6 gap-4">
                <template x-for="(photo, index) in pagedPhotos" :key="index">
                    <img :src="photo.src" class="w-full aspect-square object-cover rounded-xl cursor-pointer" @click="openPhotoDetail(((gridPage-1)*photosPerPage)+index, currentCategory, photos)">
                </template>
            </div>
        </div>
    </div>

    {{-- MODAL CAROUSEL --}}
    <div x-show="openCarouselModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90" @click="openCarouselModal = false" x-cloak>
        <div class="max-w-4xl w-full" @click.stop>
            <img :src="photos[currentIndex]?.src" class="max-h-[60vh] mx-auto rounded-2xl">
            <div class="text-white mt-4 text-center">
                <h3 class="font-bold text-lg" x-text="photos[currentIndex]?.title"></h3>
                <p class="italic text-sm" x-show="photos[currentIndex]?.is_customer" x-text="photos[currentIndex]?.comment"></p>
            </div>
        </div>
    </div>
</div>

<style>[x-cloak] { display: none !important; }</style>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($groupedGalleries as $category => $items)
            new Swiper(".mySwiper-{{ Str::slug($category) }}", { slidesPerView: 1, spaceBetween: 20, breakpoints: { 640: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1024: { slidesPerView: 4 } } });
        @endforeach
    });
</script>
@endsection