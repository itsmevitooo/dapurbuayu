@extends('layouts.app')

@section('content')
    <div class="text-center mb-10">
        <h2 class="text-4xl font-extrabold text-gray-900">LOKASI KAMI</h2>
        <p class="text-lg text-gray-600 mt-2">Kunjungi dapur utama kami.</p>
    </div>
    
    <div class="bg-white p-8 rounded-xl shadow-2xl max-w-4xl mx-auto">
        <h3 class="text-2xl font-semibold text-primary mb-4">Dapur Bu Ayu Pusat</h3>
        <p class="text-gray-700 mb-6">Perumahan Bunga Pratama Sawangan Blok L-1, Bedahan, Kec. Sawangan, Kota Depok, Jawa Barat 16519</p>
        
        <div class="aspect-w-16 aspect-h-9 w-full h-96 bg-gray-200 rounded-lg mb-6 overflow-hidden border border-gray-100">
             {{-- Google Maps Embed Manual (Gratis & Tanpa API Key) --}}
             <iframe 
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1982.3846750072453!2d106.77063532650654!3d-6.423673930255887!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e9673fd4e811%3A0xe8720038d197b21e!2sCatering%20Dapur%20Bu%20Ayu!5e0!3m2!1sid!2sid!4v1766808066496!5m2!1sid!2sid" 
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
        
        <div class="flex justify-center">
            {{-- Link Direct ke Google Maps --}}
            <a href="https://maps.app.goo.gl/qE45uQMKqsB7mQ4u6" target="_blank" class="bg-primary hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300">
                Buka di Google Maps
            </a>
        </div>
    </div>
@endsection