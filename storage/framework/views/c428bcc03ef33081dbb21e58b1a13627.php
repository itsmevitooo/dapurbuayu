<?php
    $settingsPath = storage_path('app/settings.json');
    $data = file_exists($settingsPath) ? json_decode(file_get_contents($settingsPath), true) : [];
?>

<?php $__env->startSection('content'); ?>
<div class="container mx-auto py-10 px-4">
    <div class="text-center mb-10 py-4">
        <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Lokasi Kami</h2>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">
            Kunjungi dapur utama kami.
        </p>
    </div>
    
    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-4xl mx-auto mb-20">
        <h3 class="text-2xl font-semibold text-primary mb-4 font-inter">Dapur Bu Ayu Pusat</h3>
        
        
        <p class="text-gray-700 mb-6 font-inter"><?php echo e($data['alamat_toko'] ?? 'Alamat belum diatur'); ?></p>
        
        <div class="w-full h-96 bg-gray-100 rounded-lg mb-6 overflow-hidden border border-gray-200">
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(!empty($data['google_maps_embed_url'])): ?>
                <iframe src="<?php echo e($data['google_maps_embed_url']); ?>" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            <?php else: ?>
                <div class="flex items-center justify-center h-full text-gray-400">
                    Peta tidak ditemukan. Periksa kembali link embed di admin.
                </div>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
        </div>
        
        <div class="flex justify-center">
            <a href="<?php echo e($data['google_maps_url'] ?? '#'); ?>" target="_blank" class="bg-primary hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 uppercase text-xs tracking-widest">
                Buka di Google Maps
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/location.blade.php ENDPATH**/ ?>