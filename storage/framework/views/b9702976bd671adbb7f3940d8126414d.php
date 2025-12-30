

<?php $__env->startSection('content'); ?>
<div class="py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-xl p-8 md:p-12 border border-gray-50">
        
        
        <div class="text-center mb-12">
            <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Cek Pesanan Anda</h2>
            <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-4 font-bold">Pantau Status Hidangan Spesial Dapur Bu Ayu</p>
        </div>

        
        <div class="mb-12">
            <form action="<?php echo e(route('check_order.search')); ?>" method="GET" class="flex flex-col md:flex-row gap-3">
                <div class="relative flex-grow">
                    <input type="text" 
                           name="invoice_code" 
                           placeholder="Masukkan kode invoice (Contoh: INV-XXXX)..." 
                           class="w-full px-8 py-5 rounded-2xl border-none bg-gray-50 focus:bg-white focus:ring-2 focus:ring-primary outline-none transition text-lg font-medium placeholder:text-gray-400 shadow-inner" 
                           value="<?php echo e(request('invoice_code')); ?>"
                           required>
                </div>
                <button type="submit" class="bg-gray-900 hover:bg-primary text-white px-12 py-5 rounded-2xl font-bold uppercase text-xs tracking-[0.2em] transition-all duration-300 shadow-lg active:scale-95">
                    Cek Sekarang
                </button>
            </form>
        </div>

        <div class="relative flex py-5 items-center">
            <div class="flex-grow border-t border-gray-100"></div>
            <span class="flex-shrink mx-4 text-gray-400 text-[10px] font-bold uppercase tracking-widest">Hasil Pencarian</span>
            <div class="flex-grow border-t border-gray-100"></div>
        </div>

        
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(isset($order)): ?>
            <div class="animate-fade-in mt-8">
                <div class="bg-white rounded-[2rem] p-6 md:p-10 border border-gray-100 shadow-sm relative overflow-hidden">
                     
                    <div class="absolute top-0 right-0 w-32 h-32 bg-primary/5 rounded-full -mr-16 -mt-16"></div>
                    
                    <div class="flex flex-col md:flex-row justify-between items-start gap-6 mb-8 relative z-10">
                        <div>
                            <span class="inline-block px-3 py-1 bg-primary/10 text-primary text-[10px] font-black uppercase tracking-widest rounded-full mb-3">Invoice Resmi</span>
                            <h2 class="text-3xl font-bold text-gray-800 font-inter"><?php echo e($order->invoice_code); ?></h2>
                            <p class="text-sm text-gray-500 mt-2 flex items-center">
                                <span class="mr-2">📅</span> Tanggal Kirim: <strong class="ml-1 text-gray-700"><?php echo e(\Carbon\Carbon::parse($order->delivery_date)->translatedFormat('d F Y')); ?></strong>
                            </p>
                        </div>
                        <div class="flex flex-wrap md:flex-col gap-3">
                            <span class="px-6 py-2 rounded-xl text-[10px] font-black tracking-widest text-center shadow-sm <?php echo e($order->payment_status == 'PAID' ? 'bg-green-500 text-white' : 'bg-orange-400 text-white'); ?>">
                                <?php echo e($order->payment_status); ?>

                            </span>
                            <span class="px-6 py-2 rounded-xl text-[10px] font-black tracking-widest text-center bg-gray-100 text-gray-600 shadow-sm border border-gray-200">
                                <?php echo e($order->order_status); ?>

                            </span>
                        </div>
                    </div>

                    <div class="border-t border-dashed border-gray-200 pt-8">
                        <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-6">Rincian Pesanan</h4>
                        <div class="space-y-4">
                            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__currentLoopData = $order->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="group bg-gray-50/50 hover:bg-white p-5 rounded-2xl border border-transparent hover:border-gray-100 flex justify-between items-center transition-all duration-300">
                                    <div>
                                        <p class="font-bold text-gray-800 text-lg group-hover:text-primary transition-colors"><?php echo e($item->item_name); ?></p>
                                        <p class="text-xs text-gray-400 italic mt-1 font-medium">Pilihan Lauk: <?php echo e($item->side_dish); ?></p>
                                    </div>
                                    <div class="text-right">
                                        <span class="text-lg font-black text-gray-900"><?php echo e($item->quantity); ?></span>
                                        <span class="text-[10px] font-bold text-gray-400 uppercase ml-1">Box</span>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        </div>
                        
                        <div class="mt-10 p-8 bg-gray-900 rounded-[2rem] text-white flex flex-col md:flex-row justify-between items-center gap-4">
                            <div>
                                <p class="text-gray-400 text-[10px] font-bold uppercase tracking-widest mb-1">Total Pembayaran</p>
                                <p class="text-3xl font-bold text-primary italic font-inter">Rp <?php echo e(number_format($order->total_price, 0, ',', '.')); ?></p>
                            </div>
                            <button onclick="window.print()" class="bg-white/10 hover:bg-white/20 text-white text-[10px] font-bold py-3 px-6 rounded-xl uppercase tracking-widest transition">
                                Cetak Bukti
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        <?php elseif(session('error')): ?>
            <div class="text-center p-10 bg-red-50 rounded-[2rem] border border-red-100 mt-8">
                <div class="text-red-400 mb-4 text-4xl">⚠️</div>
                <h3 class="text-red-600 font-bold text-lg">Invoice Tidak Ditemukan</h3>
                <p class="text-red-400 text-sm mt-1 uppercase tracking-tighter font-bold">Pastikan kode yang Anda masukkan sudah benar.</p>
            </div>
        <?php else: ?>
            <div class="text-center py-16 opacity-40">
                <div class="flex justify-center mb-4">
                    <svg class="w-16 h-16 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <p class="text-gray-700 font-medium italic">Silakan masukkan kode invoice di atas...</p>
            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
    
    .animate-fade-in {
        animation: fadeIn 0.6s ease-out forwards;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/check_order.blade.php ENDPATH**/ ?>