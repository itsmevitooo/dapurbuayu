

<?php $__env->startSection('content'); ?>
<div class="py-4 px-4 max-w-7xl mx-auto">
    
    <div class="text-center mb-16">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Galeri Kami</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Koleksi Foto Hidangan dan Momen Spesial</p>
    </div>

    <?php
        // Ambil kategori unik
        $categories = $galleries->pluck('category')->unique();
    ?>

    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="mb-20">
            
            <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-wider mb-8 flex items-center">
                <?php echo e($category == 'customer' ? 'Review Pengguna' : $category); ?>

                <span class="flex-1 h-px bg-gray-200 ml-4"></span>
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $galleries->where('category', $category); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg bg-white transform transition duration-500 hover:-translate-y-2">
                        <?php
                            $path = $item->image;
                            if (!Str::contains($path, '/')) {
                                if ($category == 'customer') {
                                    $path = 'reviews/' . $path;
                                } else {
                                    $path = 'pakets/' . $path;
                                }
                            }
                        ?>

                        <img src="<?php echo e(asset('storage/' . $path)); ?>" 
                             class="w-full h-64 object-cover"
                             onerror="this.src='https://placehold.co/600x400?text=File+Belum+Dipindah'">
                        
                        
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 p-6 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end">
                            <h3 class="text-white font-bold"><?php echo e($item->title); ?></h3>
                            <p class="text-gray-300 text-xs italic"><?php echo e($category); ?></p>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-center py-20 text-gray-400 italic text-lg">Belum ada koleksi foto.</p>
    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/gallery.blade.php ENDPATH**/ ?>