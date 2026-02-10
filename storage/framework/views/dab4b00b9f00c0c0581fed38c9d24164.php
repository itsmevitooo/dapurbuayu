<?php $__env->startPush('styles'); ?>
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

        .package-slider .swiper-slide { height: auto !important; display: flex; }
        .custom-scrollbar::-webkit-scrollbar { width: 3px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #EAB308; border-radius: 10px; }

        @media (max-width: 768px) {
            .swiper { padding: 15px 15px 45px 15px !important; }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div x-data="{ openReview: false }">
        
        
        <section class="relative h-120 bg-cover bg-center rounded-lg shadow-xl mb-12" style="background-image: url('<?php echo e(asset('storage/banner.png')); ?>');">
            <div class="absolute inset-0 bg-black opacity-40 rounded-lg"></div>
            <div class="relative flex flex-col items-center justify-center h-full text-center">
                <h1 class="text-6xl md:text-8xl font-bold font-[Qwitcher_Grypen] mb-2 text-primary">Selamat Datang</h1>
                <p class="text-xs md:text-sm font-bold uppercase tracking-[0.3em] mb-8 font-inter text-white">Pesan katering terbaik untuk acara Anda.</p>
                <a href="#packages" class="bg-primary hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow-lg transition duration-300 uppercase text-xs tracking-widest">Order Sekarang</a>
            </div>
        </section>

        
        <section class="mb-20 px-4 py-16 bg-primary rounded-3xl shadow-inner relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-white/20 rounded-full"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 bg-black/5 rounded-full"></div>

            <div class="relative z-10">
                <div class="text-center mb-12">
                    <h2 class="text-5xl font-bold text-white font-[Qwitcher_Grypen]">Kenapa Memilih Kami?</h2>
                    <div class="h-1.5 w-24 bg-white mx-auto mt-2 rounded-full"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    <div class="text-center p-8 bg-white rounded-3xl shadow-xl">
                        <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-800 uppercase tracking-tight">Bahan Berkualitas</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Kami hanya menggunakan bahan baku segar dan premium untuk setiap hidangan Anda.</p>
                    </div>
                    <div class="text-center p-8 bg-white rounded-3xl shadow-xl">
                        <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-800 uppercase tracking-tight">Tepat Waktu</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Pengiriman dijamin tepat waktu sesuai jadwal acara yang Anda tentukan.</p>
                    </div>
                    <div class="text-center p-8 bg-white rounded-3xl shadow-xl">
                        <div class="w-16 h-16 bg-yellow-100 rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                        <h3 class="text-xl font-black mb-3 text-gray-800 uppercase tracking-tight">Harga Terbaik</h3>
                        <p class="text-gray-500 text-sm leading-relaxed">Paket katering hemat dengan porsi melimpah dan rasa yang tak terlupakan.</p>
                    </div>
                </div>
            </div>
        </section>

        
        <section id="packages" class="mb-12 py-10 bg-yellow-50 rounded-xl shadow-inner border border-yellow-100">
            <div class="text-center mb-4">
                <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Menu Terlaris</h2>
                <p class="text-[10px] font-bold text-gray-400 uppercase tracking-[0.3em]">Pilihan paket yang paling banyak dipesan pelanggan kami</p>
            </div>

            <div class="relative px-2 md:px-4">
                <div class="swiper package-slider">
                    <div class="swiper-wrapper">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="swiper-slide h-auto">
                            <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col h-full relative group w-full">
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($index < 3): ?>
                                <div class="ribbon-wrapper"><div class="ribbon">Best Seller</div></div>
                                <div class="rank-badge">RANK #<?php echo e($index + 1); ?></div>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <div class="h-48 overflow-hidden">
                                    <img src="<?php echo e(asset('storage/' . $package->image)); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                </div>
                                <div class="p-6 flex flex-col flex-grow font-inter bg-white">
                                    <h3 class="text-xl font-bold mb-3 text-gray-800 uppercase tracking-tight h-14 line-clamp-2"><?php echo e($package->name); ?></h3>
                                    <div class="flex-grow">
                                        <ul class="text-sm text-gray-600 mb-6 space-y-1 h-32 overflow-y-auto custom-scrollbar italic text-left">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($package->items)): ?>
                                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $package->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($category['menus'])): ?>
                                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $category['menus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li>• <?php echo e($menu['name']); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </ul>
                                    </div>
                                    <div class="mt-auto pt-4 border-t border-gray-100 font-inter text-center">
                                        <p class="text-2xl font-black text-primary mb-4 italic">Rp <?php echo e(number_format($package->price, 0, ',', '.')); ?></p>
                                        <a href="<?php echo e(route('paket.detail', $package->id)); ?>" class="block w-full bg-primary text-white font-bold py-3 rounded-full uppercase text-[10px] tracking-widest hover:bg-yellow-600 shadow-md">Pilih Paket</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-center w-full py-10 italic">Belum ada paket.</p>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="swiper-button-next p-next"></div>
                    <div class="swiper-button-prev p-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        
        <section class="mb-12 px-4">
            <div class="flex flex-col md:flex-row justify-between items-end border-b-4 border-primary pb-4 mb-8 gap-4">
                <h2 class="text-5xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pelanggan</h2>
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <a href="<?php echo e(url('/reviews')); ?>" class="flex-1 md:flex-none text-center bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest transition border border-gray-200">Lihat Semua</a>
                    <button @click="openReview = true" class="flex-[2] md:flex-none bg-orange-500 hover:bg-orange-600 text-white font-bold py-2.5 px-6 rounded-full text-[10px] uppercase tracking-widest shadow-md transition">+ Tambah Review</button>
                </div>
            </div>
            
            <div class="relative px-2 md:px-4">
                <div class="swiper review-slider">
                    <div class="swiper-wrapper">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="swiper-slide h-auto">
                            <div class="bg-white p-6 rounded-2xl shadow-lg border-t-4 border-primary flex flex-col h-full w-full font-inter">
                                <div class="flex text-yellow-400 mb-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                                        <span class="text-lg"><?php echo e($i <= $review->rating ? '★' : '☆'); ?></span>
                                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                                <p class="italic text-gray-700 mb-4 flex-grow text-sm leading-relaxed">"<?php echo e(Str::limit($review->comment, 100)); ?>"</p>
                                
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->image): ?>
                                    <?php
                                        $imgs = is_array($review->image) ? $review->image : json_decode($review->image, true);
                                    ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($imgs)): ?>
                                        <div class="flex gap-2 mb-4 overflow-x-auto pb-1">
                                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = array_slice((array)$imgs, 0, 3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <img src="<?php echo e(asset('storage/' . ltrim($img, '/'))); ?>" 
                                                     class="w-12 h-12 object-cover rounded-lg border border-gray-100 shadow-sm flex-shrink-0"
                                                     onerror="this.src='https://placehold.co/100x100?text=Error'">
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                        </div>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                                <div class="flex items-center gap-2 pt-4 border-t border-gray-50 mt-auto">
                                    <div class="w-2 h-2 rounded-full bg-primary"></div>
                                    <small class="font-bold text-gray-600 uppercase tracking-widest text-[9px]"><?php echo e($review->name); ?></small>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="w-full py-10 text-center italic text-gray-400">Belum ada review.</div>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                    <div class="swiper-button-next r-next"></div>
                    <div class="swiper-button-prev r-prev"></div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>

        
        <div x-show="openReview" x-cloak class="fixed inset-0 z-[9999] flex items-center justify-center">
            <div @click="openReview = false" class="fixed inset-0 bg-black bg-opacity-80 transition-opacity"></div>
            <div class="relative bg-white rounded-3xl shadow-2xl max-w-lg w-full p-8 overflow-hidden transform transition-all" x-show="openReview" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <button @click="openReview = false" class="absolute top-6 right-6 text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>

                <form action="<?php echo e(route('reviews.store')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <h3 class="text-3xl font-extrabold text-orange-400 font-inter uppercase tracking-tight">Kirim Ulasan</h3>
                    <div class="space-y-5 text-left font-inter">
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required class="w-full border-gray-200 rounded-xl p-3 focus:ring-orange-400 focus:border-orange-400">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase mb-2">Rating</label>
                            <select name="rating" required class="w-full border-gray-200 rounded-xl p-3 text-orange-400 font-bold focus:ring-orange-400">
                                <option value="5">★★★★★ (Sempurna)</option>
                                <option value="4">★★★★ (Bagus)</option>
                                <option value="3">★★★ (Cukup)</option>
                                <option value="2">★★ (Kurang)</option>
                                <option value="1">★ (Buruk)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase mb-2">Ulasan Anda</label>
                            <textarea name="comment" rows="4" required class="w-full border-gray-200 rounded-xl p-3" placeholder="Ceritakan pengalaman Anda..."></textarea>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-800 uppercase mb-2">Foto Masakan (Opsional)</label>
                            <input type="file" name="image[]" multiple class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-6 file:rounded-full file:border-0 file:bg-orange-50 file:text-orange-400 file:font-bold hover:file:bg-orange-100 cursor-pointer">
                        </div>
                    </div>
                    <div class="flex items-center justify-end gap-6 pt-4">
                        <button @click="openReview = false" type="button" class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600">Batal</button>
                        <button type="submit" class="bg-orange-400 hover:bg-orange-500 text-white font-bold py-3 px-10 rounded-full text-xs uppercase tracking-widest shadow-lg transform transition active:scale-95">
                            Kirim Review
                        </button>
                    </div>
                </form>
            </div>
        </div>
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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/welcome.blade.php ENDPATH**/ ?>