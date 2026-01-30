

<?php $__env->startSection('content'); ?>
<div class="max-w-[95%] mx-auto px-4 py-4">
    
    <div class="text-center mb-10">
        <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Menu Paket Kami</h2>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Pilih Kategori Hidangan Spesial Dapur Bu Ayu</p>
    </div>

    
    <div class="flex flex-wrap justify-center gap-3 mb-10">
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
               class="px-8 py-3 rounded-full border-2 transition-all duration-500 font-bold uppercase text-[11px] tracking-widest font-inter
               <?php echo e($category == $key 
                  ? 'bg-primary border-primary text-white shadow-md scale-105' 
                  : 'border-gray-100 text-gray-400 hover:border-primary/50 hover:text-primary bg-white'); ?>">
                <?php echo e($label); ?>

            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $pakets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-xl shadow-xl overflow-hidden border-t-8 border-primary flex flex-col w-full h-full transition-transform hover:scale-[1.02] duration-300">
                
                <img src="<?php echo e(asset('storage/' . $p->image)); ?>" class="w-full h-48 object-cover" alt="<?php echo e($p->name); ?>">
                
                <div class="p-6 flex flex-col flex-grow font-inter">
                    
                    <h3 class="text-2xl font-bold mb-3 text-gray-800 uppercase italic"><?php echo e($p->name); ?></h3>
                    
                    
                    <div class="flex-grow">
                        <ul class="text-sm text-gray-600 mb-6 space-y-1">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(is_array($p->items)): ?>
                                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $p->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoryItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($categoryItem['menus'])): ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $categoryItem['menus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                            <li>• <?php echo e($menu['name']); ?></li> 
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </ul>
                    </div>

                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        <p class="text-2xl font-extrabold text-primary mb-4 text-center">Rp <?php echo e(number_format($p->price, 0, ',', '.')); ?></p>
                        <a href="<?php echo e(route('paket.detail', $p->id)); ?>" class="block w-full bg-primary text-white font-bold py-3 rounded-full text-center uppercase text-[10px] tracking-widest shadow-md hover:bg-yellow-600 transition-colors">
                            Pilih Paket
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-span-full text-center py-20 bg-white rounded-xl border-2 border-dashed border-gray-100">
                <h3 class="text-xl font-bold text-gray-400 font-inter tracking-widest uppercase">Belum Ada Paket</h3>
                <p class="text-gray-300 text-sm mt-1">Kami sedang menyiapkan menu terbaik untuk kategori ini.</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/paket.blade.php ENDPATH**/ ?>