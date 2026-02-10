

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
                <input type="hidden" name="package_price" value="<?php echo e($package->price); ?>">

                
                <div class="space-y-8">
                    <h3 class="text-xl font-black text-gray-800 uppercase tracking-wider italic">Sesuaikan Menu</h3>
                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($package->items)): ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $package->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="animate-fade-in">
                                <h4 class="text-sm font-black text-gray-400 uppercase tracking-[0.2em] mb-4 flex items-center">
                                    <span class="bg-primary w-2 h-2 rounded-full mr-3"></span>
                                    <?php echo e($category['category_name']); ?>

                                </h4>
                                <div class="flex flex-wrap gap-3">
                                    <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $category['menus']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($category['is_selectable']): ?>
                                            <label class="relative group cursor-pointer">
                                                <input type="radio" name="selections[<?php echo e($category['category_name']); ?>]" value="<?php echo e($menu['name']); ?>" required class="peer hidden">
                                                <div class="px-6 py-3 bg-white border-2 border-gray-200 rounded-2xl text-sm font-bold text-gray-600 peer-checked:bg-primary peer-checked:border-primary peer-checked:text-white transition-all duration-300">
                                                    <?php echo e($menu['name']); ?>

                                                </div>
                                            </label>
                                        <?php else: ?>
                                            <div class="px-6 py-3 bg-gray-100 border-2 border-gray-200 rounded-2xl text-sm font-black text-gray-400 cursor-not-allowed">
                                                <?php echo e($menu['name']); ?>

                                            </div>
                                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                    <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
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
                        <input type="date" id="delivery_date_input" name="delivery_date" required min="<?php echo e(\Carbon\Carbon::now()->addDays(2)->format('Y-m-d')); ?>" class="w-full rounded-2xl border-gray-200 p-4" onchange="updateDeadlineInfo(this.value)">
                        <div id="deadline_warning" class="hidden mt-3 p-4 bg-orange-50 border-l-4 border-orange-400 rounded-r-xl">
                            <p class="text-xs text-orange-700"><strong>Penting:</strong> Bayar sebelum <span id="deadline_date" class="font-black underline"></span>.</p>
                        </div>
                    </div>
                </div>

                
                <div class="bg-gray-50 p-8 rounded-3xl border border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div>
                            <label class="block text-xl font-black text-gray-800 mb-1">Kuantitas Pesanan</label>
                            <p class="text-xs text-gray-500 font-bold">Minimal: <?php echo e($package->min_order ?? 1); ?> Porsi/Box.</p>
                        </div>
                        <div class="flex items-center bg-white p-2 rounded-2xl shadow-inner border border-gray-200">
                            <input 
                                type="number" 
                                name="quantity" 
                                min="<?php echo e($package->min_order ?? 1); ?>" 
                                value="<?php echo e($package->min_order ?? 1); ?>" 
                                required 
                                class="w-32 bg-transparent border-none text-center text-2xl font-black text-primary"
                            >
                            <span class="pr-4 text-gray-400 font-bold">Box</span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="w-full bg-primary text-white font-black py-6 rounded-3xl shadow-2xl transition-all hover:-translate-y-1">
                    <span class="flex items-center justify-center text-xl">Lanjutkan ke Pembayaran</span>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function updateDeadlineInfo(dateString) {
        const warningBox = document.getElementById('deadline_warning');
        const deadlineSpan = document.getElementById('deadline_date');
        if (dateString) {
            let deliveryDate = new Date(dateString);
            deliveryDate.setDate(deliveryDate.getDate() - 2);
            const formattedDate = deliveryDate.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            deadlineSpan.innerText = formattedDate + " pukul 23:59 WIB";
            warningBox.classList.remove('hidden');
        } else {
            warningBox.classList.add('hidden');
        }
    }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/orderdetail.blade.php ENDPATH**/ ?>