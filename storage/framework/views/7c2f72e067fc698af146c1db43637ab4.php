 

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-12">
    
    <div class="text-center mb-12">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pengguna</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Apa Kata Mereka Tentang Dapur Bu Ayu</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white p-6 rounded-2xl shadow-xl border-b-4 border-primary font-inter flex flex-col h-full transition-all hover:shadow-2xl">
                
                <div class="flex mb-4">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                        <svg class="w-6 h-6 <?php echo e($i <= (int)$review->rating ? 'text-yellow-400' : 'text-gray-200'); ?>" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <p class="text-gray-600 italic mb-6 text-sm leading-relaxed flex-grow">
                    "<?php echo e($review->comment); ?>"
                </p>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->image): ?>
                    <?php
                        // Logika tangguh untuk menangani berbagai format data gambar di database
                        $images = [];
                        if (is_array($review->image)) {
                            $images = $review->image;
                        } else {
                            $decoded = json_decode($review->image, true);
                            $images = is_array($decoded) ? $decoded : [$review->image];
                        }
                    ?>
                    
                    <div class="flex flex-wrap gap-2 mb-6">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                                <div class="group relative w-20 h-20 overflow-hidden rounded-xl border border-gray-100 shadow-sm bg-gray-50">
                                    <img src="<?php echo e(asset('storage/' . ltrim($img, '/'))); ?>" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300 cursor-zoom-in"
                                         onerror="this.onerror=null;this.src='https://placehold.co/100x100?text=No+Photo'"
                                         alt="Review dari <?php echo e($review->name); ?>">
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="border-t border-gray-50 pt-4 mt-auto flex items-center justify-between">
                    <div>
                        <p class="font-black text-gray-900 uppercase tracking-wider text-[11px]"><?php echo e($review->name); ?></p>
                        <p class="text-[9px] text-gray-400 mt-0.5 font-bold uppercase tracking-tighter">
                            <?php echo e($review->created_at ? $review->created_at->translatedFormat('d F Y') : 'Baru saja'); ?>

                        </p>
                    </div>
                    <div class="bg-primary/10 px-2 py-1 rounded text-[9px] font-bold text-primary uppercase">
                        Verified
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-20">
                <p class="text-gray-400 font-inter italic">Belum ada ulasan untuk saat ini.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
    
    /* Memastikan font inter tersedia jika tidak ada di app.blade */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/reviews.blade.php ENDPATH**/ ?>