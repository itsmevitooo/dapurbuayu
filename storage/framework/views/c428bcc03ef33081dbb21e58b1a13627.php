

<?php $__env->startSection('content'); ?>
    <div class="text-center mb-10 py-4">
        
        <h2 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Lokasi Kami</h2>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Kunjungi dapur utama kami.</p>
    </div>
    
    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-4xl mx-auto mb-20"> 
        <h3 class="text-2xl font-semibold text-primary mb-4 font-inter">Dapur Bu Ayu Pusat</h3>
        <p class="text-gray-700 mb-6 font-inter">Perumahan Bunga Pratama Sawangan Blok L-1, Bedahan, Kec. Sawangan, Kota Depok, Jawa Barat 16519</p>
        
        <div class="aspect-w-16 aspect-h-9 w-full h-96 bg-gray-200 rounded-lg mb-6 overflow-hidden border border-gray-100">
             
             <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.847123456789!2d106.7654321!3d-6.4012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwMjQnMDQuNCJTIDEwNsKwNDUnNTUuNiJF!5e0!3m2!1sid!2sid!4v1234567890" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        
        <div class="flex justify-center">
            
            <a href="https://maps.app.goo.gl/xxxxx" target="_blank" class="bg-primary hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 font-inter uppercase text-xs tracking-widest">
                Buka di Google Maps
            </a>
        </div>
    </div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
</style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/location.blade.php ENDPATH**/ ?>