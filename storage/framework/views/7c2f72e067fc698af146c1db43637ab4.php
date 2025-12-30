 

<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-4">
    
    <div class="text-center mb-12">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pengguna</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Apa Kata Mereka Tentang Dapur Bu Ayu</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-primary font-inter flex flex-col h-full">
                
                <div class="flex mb-3">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php for($i = 1; $i <= 5; $i++): ?>
                        <span style="color: <?php echo e($i <= (int)$review->rating ? '#EAB308' : '#D1D5DB'); ?> !important; font-size: 1.5rem;">★</span>
                    <?php endfor; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>

                
                <p class="text-gray-600 italic mb-4 text-sm leading-relaxed flex-grow">"<?php echo e($review->comment); ?>"</p>

                
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($review->image): ?>
                    <div class="flex flex-wrap gap-2 mb-4">
                        <?php
                            $images = [];
                            // Cek apakah datanya sudah format Array (karena Casts) 
                            // atau String JSON (ada kurung siku) atau String Biasa (data lama)
                            if (is_array($review->image)) {
                                $images = $review->image;
                            } elseif (str_starts_with($review->image, '[')) {
                                $images = json_decode($review->image, true);
                            } else {
                                $images = [$review->image]; // Bungkus string biasa jadi array agar bisa di-foreach
                            }
                        ?>
                        
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($img): ?>
                                <div class="w-20 h-20 overflow-hidden rounded-lg border border-gray-100 shadow-sm bg-gray-50">
                                    <img src="<?php echo e(asset('storage/' . $img)); ?>" 
                                         class="w-full h-full object-cover hover:scale-110 transition-transform cursor-pointer"
                                         onerror="this.onerror=null;this.src='https://placehold.co/100x100?text=No+Image'"
                                         alt="Review Item">
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </div>
                <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                
                <div class="border-t pt-3 mt-auto">
                    <p class="font-bold text-gray-800 uppercase tracking-widest text-xs"><?php echo e($review->name); ?></p>
                    <p class="text-[10px] text-gray-400 mt-1 font-bold"><?php echo e($review->created_at->format('d M Y')); ?></p>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/reviews.blade.php ENDPATH**/ ?>