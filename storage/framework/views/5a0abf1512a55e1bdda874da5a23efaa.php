

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Detail Order</h2>
        <div class="h-1 w-20 bg-primary mx-auto mt-2"></div>
    </div>
    
    <div class="bg-white shadow-2xl rounded-3xl overflow-hidden lg:flex min-h-[600px] border border-gray-100">
        
        
        <div class="lg:w-1/3 p-8 bg-gray-50 border-r border-gray-100 flex flex-col">
            <div class="sticky top-8">
                <h3 class="text-4xl font-black mb-6 text-gray-800 italic uppercase tracking-tighter">
                    <?php echo e($package->name); ?>

                </h3>
                
                <div class="w-full h-64 overflow-hidden rounded-lg bg-gray-100 mb-6">
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->image): ?>
                        <img src="<?php echo e(asset('storage/' . $package->image)); ?>" alt="<?php echo e($package->name); ?>" class="w-full h-full object-cover">
                    <?php else: ?>
                        <div class="flex flex-col items-center justify-center h-full text-gray-400">
                             <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                             <span class="text-xs mt-2 uppercase">Gambar belum tersedia</span>
                        </div>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                </div>
        
                <div class="space-y-4">
                    <div class="bg-primary p-6 rounded-3xl text-white shadow-lg shadow-yellow-200">
                        <p class="text-xs uppercase font-black tracking-widest opacity-80 mb-1">Harga Satuan</p>
                        <p class="text-4xl font-black">Rp. <?php echo e(number_format($package->price, 0, ',', '.')); ?></p>
                    </div>
                    <a href="<?php echo e(route('home')); ?>" class="flex items-center justify-center text-gray-500 hover:text-primary font-bold text-sm transition">← Kembali ke Beranda</a>
                </div>
            </div>
        </div>

        
        <div class="lg:w-2/3 p-8 lg:p-12">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($errors->any()): ?>
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-xl">
                    <ul class="list-disc list-inside text-sm text-red-600 font-bold">
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <li><?php echo e($error); ?></li> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    </ul>
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

            <form action="<?php echo e(route('order.process_detail')); ?>" method="POST" class="space-y-10">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="package_id" value="<?php echo e($package->id); ?>">

                
                <div class="space-y-6">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-wider italic">Isi Menu Paket</h3>
                    
                    <div class="bg-white border-2 border-dashed border-gray-200 rounded-3xl p-6">
                        <div class="space-y-6">
                            <?php
                                // Pisahkan menu berdasarkan is_selectable
                                $fixedMenus = $package->details->where('is_selectable', false);
                                $optionalMenus = $package->details->where('is_selectable', true);
                            ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($fixedMenus->count() > 0): ?>
                                <div>
                                    <p class="text-xs font-black text-gray-400 uppercase mb-3 tracking-widest">Menu Utama (Tetap)</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $fixedMenus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="flex items-center p-3 bg-gray-50 rounded-2xl border border-gray-100">
                                                <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                                <span class="font-bold text-gray-700 text-sm"><?php echo e($detail->name); ?></span>
                                                <input type="hidden" name="selections[]" value="<?php echo e($detail->name); ?>">
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($optionalMenus->count() > 0): ?>
                                <div class="pt-4 border-t border-gray-100">
                                    <p class="text-xs font-black text-primary uppercase mb-3 tracking-widest">Pilih Lauk Tambahan / Opsional</p>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $optionalMenus->groupBy('category'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="col-span-full">
                                                <label class="text-sm font-bold text-gray-600 mb-2 block"><?php echo e($category); ?></label>
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <label class="relative flex items-center p-4 bg-white rounded-2xl border-2 border-gray-100 cursor-pointer hover:border-primary transition-all group">
                                                            <input type="checkbox" name="selections[]" value="<?php echo e($item->name); ?>" class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-primary">
                                                            <span class="ml-3 font-bold text-gray-700 group-hover:text-primary transition-colors text-sm">
                                                                <?php echo e($item->name); ?>

                                                            </span>
                                                        </label>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($package->details->count() == 0): ?>
                                <div class="text-center py-4">
                                    <p class="text-gray-400 italic">Menu belum diinput di database.</p>
                                </div>
                            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                    </div>
                </div>

                <hr class="border-gray-100">

                
                <div class="space-y-6">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-wider italic">Informasi Pengiriman</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div><label class="block text-sm font-bold text-gray-700 mb-2">Nama Penerima</label><input type="text" name="full_name" required class="w-full rounded-2xl border-gray-200 p-4" placeholder="Nama lengkap"></div>
                        <div><label class="block text-sm font-bold text-gray-700 mb-2">No. WhatsApp</label><input type="tel" name="phone_number" required class="w-full rounded-2xl border-gray-200 p-4" placeholder="0812xxxx"></div>
                    </div>
                    <div><label class="block text-sm font-bold text-gray-700 mb-2">Alamat Lengkap</label><textarea name="address" rows="3" required class="w-full rounded-2xl border-gray-200 p-4" placeholder="Alamat detail..."></textarea></div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Pengiriman</label>
                        <input type="date" name="delivery_date" required min="<?php echo e(\Carbon\Carbon::now()->addDays(2)->format('Y-m-d')); ?>" class="w-full rounded-2xl border-gray-200 p-4">
                    </div>
                </div>

                
                <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <label class="block text-xl font-black text-gray-800 mb-1">Kuantitas Pesanan</label>
                            <p class="text-xs text-gray-500 font-bold">Minimal: <?php echo e($package->min_order ?? 1); ?> Porsi.</p>
                        </div>
                        <div class="flex items-center bg-white p-2 rounded-2xl shadow-inner border border-gray-200">
                            <input type="number" name="quantity" min="<?php echo e($package->min_order ?? 1); ?>" value="<?php echo e($package->min_order ?? 1); ?>" required class="w-32 bg-transparent border-none text-center text-2xl font-black text-primary">
                            <span class="pr-4 text-gray-400 font-bold"> Porsi </span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white font-black py-6 rounded-3xl shadow-2xl transition-all hover:-translate-y-1">
                    Lanjutkan ke Pembayaran
                </button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/orderdetail.blade.php ENDPATH**/ ?>