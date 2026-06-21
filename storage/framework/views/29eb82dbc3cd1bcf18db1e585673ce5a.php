<?php $__env->startPush('styles'); ?>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
        
        /* Konsistensi Animasi Hover */
        .btn-hover-anim {
            transition: all 0.3s ease !important;
        }
        .btn-hover-anim:hover {
            transform: scale(1.05);
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
        .pk-next { right: 0px !important; }
        .pk-prev { left: 0px !important; }
        .swiper-pagination-bullet-active { background: #EAB308 !important; }

        @media (max-width: 768px) {
            .swiper-paket { padding: 15px 5px 45px 5px !important; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[95%] mx-auto px-4 py-12">
    
    <div class="text-center mb-12">
        <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Menu Paket Kami</h2>
        <div class="h-1.5 w-24 bg-primary mx-auto mt-4 rounded-full"></div>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-6 font-bold">Pilih Kategori Hidangan Spesial Dapur Bu Ayu</p>
    </div>

    
    <div class="flex flex-wrap justify-center gap-3 mb-16">
        <?php
            $categories = [
                'nasi_box' => 'Nasi Box',
                'prasmanan' => 'Prasmanan',
                'tumpeng' => 'Tumpeng',
                'akikah' => 'Akikah'
            ];
        ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('paket.index', ['category' => $key])); ?>" 
               class="px-8 py-3 rounded-full border-2 transition-all duration-300 font-bold uppercase text-[11px] tracking-widest font-inter btn-hover-anim
               <?php echo e($category == $key 
                  ? 'bg-primary border-primary text-white shadow-lg' 
                  : 'border-gray-200 text-gray-400 hover:border-primary hover:text-primary bg-white'); ?>">
                <?php echo e($label); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="md:hidden relative px-4">
        <div class="swiper swiper-paket">
            <div class="swiper-wrapper">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="swiper-slide">
                        <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col w-full h-full">
                            <div class="h-48 overflow-hidden">
                                <img src="<?php echo e(asset('storage/' . $p->image)); ?>" class="w-full h-full object-cover" alt="<?php echo e($p->name); ?>">
                            </div>
                            <div class="p-6 flex flex-col flex-grow font-inter">
                                <h3 class="text-2xl font-bold mb-4 text-gray-800 uppercase italic line-clamp-2"><?php echo e($p->name); ?></h3>
                                <div class="flex-grow">
                                    <ul class="text-sm text-gray-600 mb-6 space-y-1.5 h-32 overflow-y-auto custom-scrollbar italic text-left">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_2 = true; $__currentLoopData = $p->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                            <li class="flex items-start">
                                                <span class="mr-2 text-primary">•</span>
                                                <span>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($detail->name)): ?>
                                                        <?php echo e(implode(', ', $detail->name)); ?>

                                                    <?php else: ?>
                                                        <?php echo e($detail->name); ?>

                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </span>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                            <li class="text-gray-400 italic text-xs">Menu belum diinput</li>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </ul>
                                </div>
                                <div class="mt-auto pt-6 border-t border-gray-100">
                                    <p class="text-2xl font-black text-primary mb-4 text-center italic">Rp <?php echo e(number_format($p->price, 0, ',', '.')); ?></p>
                                    <a href="<?php echo e(route('paket.detail', $p->id)); ?>" class="block w-full bg-slate-800 text-white font-bold py-3 rounded-full text-center uppercase text-[10px] tracking-widest shadow-md hover:bg-slate-900 transition-colors btn-hover-anim">
                                        Pilih Paket
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="swiper-slide w-full py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200 text-center">
                        <div>
                            <h3 class="text-xl font-bold text-gray-400 font-inter tracking-widest uppercase">Belum Ada Paket</h3>
                            <p class="text-gray-300 text-sm mt-2">Kami sedang menyiapkan menu terbaik.</p>
                        </div>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
            <div class="swiper-button-next pk-next"></div>
            <div class="swiper-button-prev pk-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    
    <div class="hidden md:grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col w-full h-full group">
                <div class="h-48 overflow-hidden">
                    <img src="<?php echo e(asset('storage/' . $p->image)); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" alt="<?php echo e($p->name); ?>">
                </div>
                
                <div class="p-6 flex flex-col flex-grow font-inter">
                    <h3 class="text-2xl font-bold mb-4 text-gray-800 uppercase italic line-clamp-2"><?php echo e($p->name); ?></h3>
                    
                    <div class="flex-grow">
                        <ul class="text-sm text-gray-600 mb-6 space-y-1.5 h-32 overflow-y-auto custom-scrollbar italic text-left">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_2 = true; $__currentLoopData = $p->details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <li class="flex items-start">
                                    <span class="mr-2 text-primary">•</span>
                                    <span>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($detail->name)): ?>
                                            <?php echo e(implode(', ', $detail->name)); ?>

                                        <?php else: ?>
                                            <?php echo e($detail->name); ?>

                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </span>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <li class="text-gray-400 italic text-xs">Menu belum diinput</li>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    </div>

                    
                    <div class="mt-auto pt-6 border-t border-gray-100">
                        <p class="text-2xl font-black text-primary mb-4 text-center italic">Rp <?php echo e(number_format($p->price, 0, ',', '.')); ?></p>
                        <a href="<?php echo e(route('paket.detail', $p->id)); ?>" class="block w-full bg-slate-800 text-white font-bold py-3 rounded-full text-center uppercase text-[10px] tracking-widest shadow-md hover:bg-slate-900 transition-colors btn-hover-anim">
                            Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-20 bg-white rounded-3xl border-2 border-dashed border-gray-200">
                <h3 class="text-xl font-bold text-gray-400 font-inter tracking-widest uppercase">Belum Ada Paket</h3>
                <p class="text-gray-300 text-sm mt-2">Kami sedang menyiapkan menu terbaik untuk kategori ini.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/paket.blade.php ENDPATH**/ ?>