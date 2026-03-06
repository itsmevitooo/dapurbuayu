

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

<div class="py-12 px-4 max-w-7xl mx-auto">
    
    <div class="text-center mb-16">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Galeri Kami</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Koleksi Foto Hidangan dan Momen Spesial</p>
    </div>

    <?php
        $groupedGalleries = $galleries->groupBy('category');
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $groupedGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="mb-20 relative group-section">
            
            <h2 class="text-2xl font-black text-gray-800 uppercase tracking-wider mb-8 flex items-center">
                <?php echo e($category == 'customer' ? 'Review Pelanggan' : $category); ?>

                <span class="flex-1 h-px bg-gray-200 ml-6"></span>
            </h2>
            
            <div class="swiper mySwiper-<?php echo e(Str::slug($category)); ?> overflow-visible">
                <div class="swiper-wrapper">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <div class="group relative overflow-hidden rounded-[2rem] shadow-sm bg-white transform transition duration-500 hover:-translate-y-2 hover:shadow-2xl h-full">
                                <?php
                                    $path = $item->image;
                                    if (!Str::contains($path, '/')) {
                                        $path = ($category == 'customer') ? 'reviews/' . $path : 'pakets/' . $path;
                                    }
                                ?>

                                <div class="aspect-square overflow-hidden">
                                    <img src="<?php echo e(asset('storage/' . $path)); ?>" 
                                         class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                         onerror="this.src='https://placehold.co/600x600?text=Foto+Menu'">
                                </div>
                                
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/20 to-transparent p-6 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end">
                                    <h3 class="text-white font-bold text-lg leading-tight"><?php echo e($item->title); ?></h3>
                                    <p class="text-primary text-[10px] font-black uppercase mt-1 tracking-widest"><?php echo e($category); ?></p>
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
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');

    /* Custom Styling Tombol Swiper */
    .custom-nav {
        color: #B45309 !important; /* Warna Primary Dapur Bu Ayu */
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
    
    /* Agar tombol tidak samar saat kursor di atas section */
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