

<?php $__env->startSection('title', 'Syarat & Ketentuan - Dapur Bu Ayu'); ?>

<?php $__env->startPush('styles'); ?>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&family=Inter:wght@400;700&display=swap');
        .font-qwitcher { font-family: 'Qwitcher Grypen', cursive; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        /* CSS Khusus untuk konten RichEditor */
        .prose-custom h4 { 
            color: #1f2937; 
            font-weight: bold; 
            margin-top: 2rem; 
            margin-bottom: 1rem; 
            border-left: 4px solid #f0ad4e; 
            padding-left: 1rem; 
            text-transform: uppercase; 
            font-style: italic; 
        }
        .prose-custom h1, .prose-custom h2, .prose-custom h3 { color: #1f2937; font-weight: bold; margin-top: 1.5rem; margin-bottom: 0.5rem; }
        .prose-custom ul { list-style-type: disc; padding-left: 1.5rem; color: #4b5563; margin-bottom: 1rem; }
        .prose-custom ol { list-style-type: decimal; padding-left: 1.5rem; color: #4b5563; margin-bottom: 1rem; }
        .prose-custom p { margin-bottom: 1rem; line-height: 1.6; color: #4b5563; }
        .prose-custom strong { color: #1f2937; }
        .prose-custom a { color: #f0ad4e; text-decoration: underline; }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-[80%] mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h2 class="text-6xl font-bold text-primary font-qwitcher">Syarat & Ketentuan</h2>
        <div class="h-1.5 w-24 bg-primary mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-8 md:p-12 font-inter prose-custom max-w-none">
        <?php echo $content; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/legal/terms.blade.php ENDPATH**/ ?>