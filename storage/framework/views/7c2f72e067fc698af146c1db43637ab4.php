 

<?php $__env->startPush('styles'); ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
        [x-cloak] { display: none !important; }

        /* Styling Swiper Review Khusus Mobile */
        .swiper-review { 
            width: 100%; 
            padding: 20px 10px 50px 10px !important;
            margin-left: auto;
            margin-right: auto;
        }
        .swiper-review .swiper-slide { 
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
            top: 35% !important;
            transition: all 0.3s ease;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            transform: scale(1.1);
            background: #fff;
        }
        .swiper-button-next::after, .swiper-button-prev::after {
            font-size: 16px !important; 
            font-weight: bold;
        }
        .rv-next { right: 0px !important; }
        .rv-prev { left: 0px !important; }
        .swiper-pagination-bullet-active { background: #EAB308 !important; }

        @media (max-width: 768px) {
            .swiper-review { padding: 15px 5px 45px 5px !important; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>


<div x-data="{ openModal: false, imgModalSrc: '' }" class="container mx-auto px-4 py-12 max-w-[95%]">
    <div class="text-center mb-12">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pengguna</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Apa Kata Mereka Tentang Dapur Bu Ayu</p>
    </div>
    
    
    <div class="md:hidden relative px-2">
        <div class="swiper swiper-review">
            <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="swiper-slide">
                        <div class="bg-white p-6 rounded-2xl shadow-xl border-b-4 border-primary font-inter flex flex-col h-full w-full justify-between">
                            <div>
                                
                                <div class="flex mb-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                        <svg class="w-5 h-5 <?php echo e($i <= (int)$review->rating ? 'text-yellow-400' : 'text-gray-200'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                        </svg>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>

                                
                                <div class="mb-4 text-left">
                                    <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-yellow-200">
                                        📦 <?php echo e($review->product->name ?? 'Paket Katering'); ?>

                                    </span>
                                </div>

                                <p class="text-gray-600 italic mb-6 text-sm text-left line-clamp-4 leading-relaxed">"<?php echo e($review->comment); ?>"</p>
                            </div>

                            <div>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->gallery->isNotEmpty()): ?>
                                    <div class="flex flex-wrap gap-2 mb-6 overflow-x-auto pb-1 justify-start">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $review->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="w-16 h-16 overflow-hidden rounded-xl border border-gray-100 shadow-sm cursor-pointer flex-shrink-0"
                                                 @click="openModal = true; imgModalSrc = '<?php echo e(asset('storage/' . $foto->image)); ?>'">
                                                <img src="<?php echo e(asset('storage/' . $foto->image)); ?>" class="w-full h-full object-cover hover:scale-110 transition duration-300" onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="border-t border-gray-50 pt-4 text-left mt-auto">
                                    <p class="font-black text-gray-900 uppercase tracking-wider text-[11px]"><?php echo e($review->name); ?></p>
                                    <p class="text-[9px] text-gray-400 mt-0.5 uppercase tracking-tighter">
                                        <?php echo e($review->created_at ? $review->created_at->translatedFormat('d F Y') : 'Baru saja'); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="swiper-slide text-center py-20 bg-white rounded-3xl w-full">
                        <p class="text-gray-400 italic">Belum ada ulasan untuk saat ini.</p>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="swiper-button-next rv-next"></div>
            <div class="swiper-button-prev rv-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    
    <div class="hidden md:grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white p-6 rounded-2xl shadow-xl border-b-4 border-primary font-inter flex flex-col h-full transition-all hover:shadow-2xl justify-between">
                <div>
                    
                    <div class="flex mb-3">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                            <svg class="w-5 h-5 <?php echo e($i <= (int)$review->rating ? 'text-yellow-400' : 'text-gray-200'); ?>" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                        <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>

                    
                    <div class="mb-4 text-left">
                        <span class="bg-yellow-100 text-yellow-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider border border-yellow-200">
                            📦 <?php echo e($review->product->name ?? 'Paket Katering'); ?>

                        </span>
                    </div>

                    <p class="text-gray-600 italic mb-6 text-sm text-left line-clamp-4 leading-relaxed">"<?php echo e($review->comment); ?>"</p>
                </div>

                <div>
                    
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->gallery->isNotEmpty()): ?>
                        <div class="flex flex-wrap gap-2 mb-6 justify-start">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $review->gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="w-20 h-20 overflow-hidden rounded-xl border border-gray-100 shadow-sm cursor-pointer"
                                     @click="openModal = true; imgModalSrc = '<?php echo e(asset('storage/' . $foto->image)); ?>'">
                                    <img src="<?php echo e(asset('storage/' . $foto->image)); ?>" class="w-full h-full object-cover hover:scale-110 transition duration-300" onerror="this.src='https://placehold.co/100x100?text=No+Image'">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                    <div class="border-t border-gray-50 pt-4 text-left mt-auto">
                        <p class="font-black text-gray-900 uppercase tracking-wider text-[11px]"><?php echo e($review->name); ?></p>
                        <p class="text-[9px] text-gray-400 mt-0.5 uppercase tracking-tighter">
                            <?php echo e($review->created_at ? $review->created_at->translatedFormat('d F Y') : 'Baru saja'); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-20 bg-white rounded-3xl">
                <p class="text-gray-400 italic">Belum ada ulasan untuk saat ini.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/80 backdrop-blur-sm" @click="openModal = false" x-cloak>
        <button class="absolute top-5 right-5 text-white text-4xl font-normal hover:text-gray-300 transition" @click="openModal = false">&times;</button>
        <div class="max-w-5xl max-h-[85vh] p-2" @click.stop>
            <img :src="imgModalSrc" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain mx-auto">
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Swiper khusus review mobile
            new Swiper('.swiper-review', {
                slidesPerView: 1, 
                spaceBetween: 20, 
                loop: false, 
                navigation: { 
                    nextEl: '.rv-next', 
                    prevEl: '.rv-prev' 
                }, 
                pagination: { 
                    el: '.swiper-review .swiper-pagination', 
                    clickable: true 
                },
                breakpoints: {
                    768: { slidesPerView: 2, spaceBetween: 20 }
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/reviews.blade.php ENDPATH**/ ?>