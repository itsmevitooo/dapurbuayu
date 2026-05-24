<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


<div x-data="{ 
    openGridModal: false,
    openCarouselModal: false, 
    currentIndex: 0,
    currentCategory: '',
    photos: [],
    
    // State untuk paginasi grid
    gridPage: 1,
    photosPerPage: 6, // 6 foto per halaman agar pas dengan grid 6 kolom

    get totalGridPages() {
        return Math.ceil(this.photos.length / this.photosPerPage) || 1;
    },

    get pagedPhotos() {
        let start = (this.gridPage - 1) * this.photosPerPage;
        let end = start + this.photosPerPage;
        return this.photos.slice(start, end);
    },
    
    openGrid(categoryName, photoArray) {
        this.currentCategory = categoryName;
        this.photos = photoArray;
        this.gridPage = 1; // Reset ke halaman pertama setiap kali buka modal
        this.openGridModal = true;
    },
    
    openPhotoDetail(index, categoryName, photoArray) {
        this.currentCategory = categoryName;
        this.photos = photoArray;
        this.currentIndex = index;
        this.openCarouselModal = true;
    },
    
    nextPhoto() {
        if (this.currentIndex < this.photos.length - 1) {
            this.currentIndex++;
        } else {
            this.currentIndex = 0;
        }
    },
    prevPhoto() {
        if (this.currentIndex > 0) {
            this.currentIndex--;
        } else {
            this.currentIndex = this.photos.length - 1;
        }
    }
}" 
class="py-12 px-4 max-w-7xl mx-auto"
@keydown.window.escape="openCarouselModal = false; if(!openCarouselModal) openGridModal = false"
@keydown.window.arrow-right="if(openCarouselModal) nextPhoto()"
@keydown.window.arrow-left="if(openCarouselModal) prevPhoto()">

    
    <div class="text-center mb-16">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Galeri Kami</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Koleksi Foto Hidangan dan Momen Spesial</p>
    </div>

    <?php
        $groupedGalleries = $galleries->groupBy('category');
        $allReviews = \App\Models\Review::whereNotNull('image')->get();
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $groupedGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
            $categoryPhotosArr = [];
            foreach($items as $item) {
                $pureGalleryFilename = basename($item->image);
                
                $path = $item->image;
                if (!Str::contains($path, '/')) {
                    $path = ($category == 'customer') ? 'reviews/' . $path : 'pakets/' . $path;
                }
                
                $reviewData = null;
                if ($category == 'customer') {
                    $reviewData = $allReviews->first(function($review) use ($pureGalleryFilename) {
                        if (is_array($review->image)) {
                            foreach ($review->image as $imgTrack) {
                                if (Str::contains(basename($imgTrack), $pureGalleryFilename)) {
                                    return true;
                                }
                            }
                            return false;
                        }
                        return Str::contains(basename($review->image), $pureGalleryFilename);
                    });
                }

                $categoryPhotosArr[] = [
                    'src' => asset('storage/' . $path),
                    'title' => $item->title,
                    'category' => $category,
                    'is_customer' => $category == 'customer',
                    'rating' => $reviewData ? (int)$reviewData->rating : 5,
                    'comment' => $reviewData ? $reviewData->comment : 'Tidak ada komentar',
                    'author' => $reviewData ? $reviewData->name : 'Pelanggan Dapur Bu Ayu'
                ];
            }
        ?>

        <div class="mb-20 relative group-section">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <h2 class="text-2xl font-black text-gray-800 uppercase tracking-wider flex items-center flex-1">
                    <?php echo e($category == 'customer' ? 'Review Pelanggan' : $category); ?>

                    <span class="hidden md:block flex-1 h-px bg-gray-200 ml-6"></span>
                </h2>
                
                
                <button @click="openGrid('<?php echo e($category); ?>', <?php echo e(json_encode($categoryPhotosArr)); ?>)" 
                        class="px-6 py-3 bg-[#F1B168] hover:bg-[#E29A4D] text-white rounded-full font-inter text-xs font-bold uppercase tracking-wider flex items-center gap-2 self-start sm:self-auto transition duration-300 ease-in-out transform active:scale-95 shadow-md">
                    <span>Lihat Semua Foto</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"></path></svg>
                </button>
            </div>
            
            <div class="swiper mySwiper-<?php echo e(Str::slug($category)); ?> overflow-visible">
                <div class="swiper-wrapper">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categoryPhotosArr; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $photo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="group relative overflow-hidden rounded-[2rem] shadow-sm bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl h-full cursor-pointer"
                                 @click="openPhotoDetail(<?php echo e($index); ?>, '<?php echo e($category); ?>', <?php echo e(json_encode($categoryPhotosArr)); ?>)">

                                <div class="aspect-square overflow-hidden">
                                    <img src="<?php echo e($photo['src']); ?>" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                         onerror="this.src='https://placehold.co/600x600?text=Foto+Menu'">
                                </div>
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent p-6 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end">
                                    <h3 class="text-white font-bold text-lg leading-tight"><?php echo e($photo['title']); ?></h3>
                                    <p class="text-primary text-[10px] font-black uppercase mt-1 tracking-widest">
                                        <?php echo e($category == 'customer' ? 'Review Pelanggan' : $category); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                <div class="swiper-button-next custom-nav opacity-20 group-section-hover:opacity-100 transition-opacity"></div>
                <div class="swiper-button-prev custom-nav opacity-20 group-section-hover:opacity-100 transition-opacity"></div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-20 bg-gray-50 rounded-[3rem]">
            <p class="text-gray-400 italic text-lg tracking-widest uppercase font-bold">Belum ada koleksi foto saat ini.</p>
        </div>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

    
    <div x-show="openGridModal" 
         class="fixed inset-0 z-40 flex items-center justify-center p-4 bg-black/70 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="openGridModal = false"
         x-cloak>
         
        <div class="bg-white rounded-[2.5rem] max-w-5xl w-full overflow-hidden flex flex-col shadow-2xl" @click.stop>
            <div class="p-6 border-b border-gray-100 flex items-center justify-between px-8">
                <div>
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-wider" x-text="currentCategory == 'customer' ? 'Semua Review Pelanggan' : 'Semua Foto ' + currentCategory"></h3>
                    <p class="text-xs text-gray-400 mt-1 font-mono" x-text="photos.length + ' Foto ditemukan'"></p>
                </div>
                <button class="text-gray-400 hover:text-gray-600 text-3xl font-light transition" @click="openGridModal = false">
                    &times;
                </button>
            </div>

            <div class="p-8 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-6 gap-4 min-h-[160px]">
                <template x-for="(photo, index) in pagedPhotos" :key="(gridPage - 1) * photosPerPage + index">
                    <div class="group relative aspect-square overflow-hidden rounded-xl bg-gray-100 cursor-pointer shadow-sm border border-gray-100 transition duration-300 hover:shadow-md"
                         @click="openPhotoDetail(((gridPage - 1) * photosPerPage) + index, currentCategory, photos)">
                        <img :src="photo.src" 
                             class="w-full h-full object-cover transition duration-500 group-hover:scale-105"
                             onerror="this.src='https://placehold.co/400x400?text=Foto+Menu'">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition duration-200 flex items-center justify-center">
                            <span class="text-white text-[10px] font-bold tracking-wider uppercase bg-primary/90 px-2.5 py-1 rounded-full">Detail</span>
                        </div>
                    </div>
                </template>
            </div>

            <div class="p-4 border-t border-gray-50 bg-gray-50/50 flex items-center justify-between px-8" x-show="totalGridPages > 1">
                <span class="text-xs text-gray-500 font-mono">
                    Halaman <span x-text="gridPage" class="font-bold text-gray-800"></span> dari <span x-text="totalGridPages"></span>
                </span>
                
                <div class="flex items-center gap-3">
                    <button @click="if(gridPage > 1) gridPage--" 
                            :disabled="gridPage === 1"
                            :class="gridPage === 1 ? 'opacity-30 cursor-not-allowed bg-gray-200 text-gray-400' : 'text-white shadow-sm'"
                            class="w-9 h-9 rounded-full flex items-center justify-center transition duration-200 bg-[#F1B168] hover:bg-[#E29A4D]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path></svg>
                    </button>
                    
                    <button @click="if(gridPage < totalGridPages) gridPage++" 
                            :disabled="gridPage === totalGridPages"
                            :class="gridPage === totalGridPages ? 'opacity-30 cursor-not-allowed bg-gray-200 text-gray-400' : 'text-white shadow-sm'"
                            class="w-9 h-9 rounded-full flex items-center justify-center transition duration-200 bg-[#F1B168] hover:bg-[#E29A4D]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    
    <div x-show="openCarouselModal" 
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/95 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="openCarouselModal = false"
         x-cloak>
         
        <button class="absolute top-5 right-5 text-white text-4xl font-light hover:text-gray-300 transition z-50" @click="openCarouselModal = false">
            &times;
        </button>

        <button class="absolute left-4 md:left-8 z-50 bg-white/10 hover:bg-white text-white hover:text-black w-12 h-12 rounded-full flex items-center justify-center transition"
                @click.stop="prevPhoto()"
                x-show="photos.length > 1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5"></path></svg>
        </button>

        <div class="max-w-4xl w-full flex flex-col items-center justify-center" @click.stop>
            <div class="max-h-[60vh] flex items-center justify-center overflow-hidden">
                <img :src="photos[currentIndex]?.src" 
                     class="max-w-full max-h-[60vh] rounded-2xl shadow-2xl object-contain mx-auto transition-all duration-300">
            </div>

            <div class="mt-6 text-center text-white max-w-2xl px-4">
                <h3 class="text-xl font-bold tracking-wide" x-text="photos[currentIndex]?.title"></h3>

                <div x-show="photos[currentIndex]?.is_customer" class="mt-3 bg-white/10 p-4 rounded-2xl backdrop-blur-sm min-w-[320px]">
                    <div class="flex justify-center gap-1 mb-2">
                        <template x-for="i in 5">
                            <svg class="w-5 h-5" 
                                 :class="i <= photos[currentIndex]?.rating ? 'text-yellow-400' : 'text-gray-600'" 
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        </template>
                    </div>

                    <p class="text-gray-200 italic text-sm font-light" x-text="'&ldquo;' + photos[currentIndex]?.comment + '&rdquo;'"></p>
                    <p class="text-primary font-black uppercase text-[11px] tracking-widest mt-2" x-text="'- ' + photos[currentIndex]?.author"></p>
                </div>
                
                <div class="text-xs text-gray-400 mt-4 font-mono">
                    <span x-text="currentIndex + 1"></span> / <span x-text="photos.length"></span>
                </div>
            </div>
        </div>

        <button class="absolute right-4 md:right-8 z-50 bg-white/10 hover:bg-white text-white hover:text-black w-12 h-12 rounded-full flex items-center justify-center transition"
                @click.stop="nextPhoto()"
                x-show="photos.length > 1">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"></path></svg>
        </button>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
    [x-cloak] { display: none !important; }

    .custom-nav {
        color: #F1B168 !important; 
        background: white;
        width: 50px !important;
        height: 50px !important;
        border-radius: 50%;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .custom-nav:after {
        font-size: 20px !important;
        font-weight: bold;
    }
    .group-section:hover .custom-nav {
        opacity: 1 !important;
    }
    .swiper {
        padding-bottom: 20px;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        <?php $__currentLoopData = $groupedGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            new Swiper(".mySwiper-<?php echo e(Str::slug($category)); ?>", {
                slidesPerView: 1,
                spaceBetween: 20,
                navigation: {
                    nextEl: ".swiper-button-next",
                    prevEl: ".swiper-button-prev",
                },
                breakpoints: {
                    640: { slidesPerView: 2 },
                    768: { slidesPerView: 3 },
                    1024: { slidesPerView: 4 },
                },
            });
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/gallery.blade.php ENDPATH**/ ?>