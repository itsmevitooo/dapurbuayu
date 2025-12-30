<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dapur Bu Ayu - Catering Service</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- Import Fonts: Qwitcher Grypen & Inter --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Qwitcher+Grypen:wght@400;700&display=swap" rel="stylesheet">

    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        .bg-primary { background-color: #f0ad4e; }
        .text-primary { color: #f0ad4e; }
        .border-primary { border-color: #f0ad4e; }
        [x-cloak] { display: none !important; }
        .animate-fade-in { animation: fadeIn 0.5s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* CSS Khusus untuk Font Inter di Navbar */
        .font-inter { font-family: 'Inter', sans-serif !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">

    {{-- NAVBAR --}}
    <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 top-0 start-0 border-b border-gray-100 shadow-sm">
        <div class="max-w-[95%] flex flex-wrap items-center justify-between mx-auto p-4">
            
            <a href="{{ route('home') }}" class="flex items-center space-x-3 transition hover:scale-105 duration-300">
                <span class="self-center text-5xl font-bold whitespace-nowrap text-primary font-[Qwitcher_Grypen]">
                    Dapur Bu Ayu
                </span>
            </a>
            
            <div class="flex md:order-2">
                <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-orange-200">
                    <span class="sr-only">Open main menu</span>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
            </div>
    
            <div class="hidden w-full md:flex md:items-center md:justify-end md:flex-1" id="navbar-default">
                <ul class="font-inter font-bold uppercase text-[12px] tracking-widest flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-2xl bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-transparent">
                    <li>
                        <a href="{{ route('home') }}" 
                           class="block py-2 px-3 transition duration-300 md:p-0 {{ request()->routeIs('home') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-primary' }}">
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('paket.index') }}" 
                           class="block py-2 px-3 transition duration-300 md:p-0 {{ request()->routeIs('paket.*') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-primary' }}">
                            Paket
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('check_order.index') }}" 
                           class="block py-2 px-3 transition duration-300 md:p-0 {{ request()->routeIs('check_order.*') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-primary' }}">
                            Cek Order
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reviews.index') }}" 
                           class="block py-2 px-3 transition duration-300 md:p-0 {{ request()->routeIs('reviews.*') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-primary' }}">
                            Review
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('gallery.index') }}" 
                           class="block py-2 px-3 transition duration-300 md:p-0 {{ request()->routeIs('gallery.*') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-primary' }}">
                            Gallery
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('location') }}" 
                           class="block py-2 px-3 transition duration-300 md:p-0 {{ request()->routeIs('location') ? 'text-primary border-b-2 border-primary' : 'text-gray-500 hover:text-primary' }}">
                            Lokasi
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Spacer --}}
    <div class="h-24"></div>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <footer class="bg-gray-900 text-white mt-12 py-12 border-t-4 border-primary">
        <div class="max-w-7xl mx-auto px-6">
            
            {{-- AREA GRID (Kolom-kolom) --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12 text-left">
                
                {{-- KOLOM 1: BRAND --}}
                <div class="flex flex-col">
                    <div class="text-5xl font-bold text-primary font-[Qwitcher_Grypen]">Dapur Bu Ayu</div>
                    <p class="text-gray-400 text-sm italic mt-2">"Hidangan sempurna, membawa bahagia."</p>
                </div>
    
                {{-- KOLOM 2: FOLLOW US --}}
                <div class="flex flex-col space-y-4">
                    <h3 class="text-lg font-bold uppercase tracking-widest border-b border-gray-700 pb-2">Follow Us</h3>
                    <div class="flex space-x-5">
                        <a href="https://instagram.com/itsmevitooo" target="_blank" class="text-gray-400 hover:text-primary transition"><i data-lucide="instagram"></i></a>
                        <a href="https://facebook.com/..." target="_blank" class="text-gray-400 hover:text-primary transition"><i data-lucide="facebook"></i></a>
                    </div>
                </div>
    
                {{-- KOLOM 3: ADMIN --}}
                <div class="flex flex-col space-y-4">
                    <h3 class="text-lg font-bold uppercase tracking-widest border-b border-gray-700 pb-2">Admin</h3>
                    <div class="flex items-center space-x-3 group">
                        <a href="https://wa.me/6285711398972" target="_blank" class="text-gray-400 group-hover:text-primary transition">
                            <i data-lucide="message-circle"></i>
                        </a>
                        <a href="https://wa.me/6285711398972" target="_blank" class="text-sm font-bold text-gray-400 hover:text-white transition">0857-1139-8972</a>
                    </div>
                </div>
    
                {{-- KOLOM 4: LOKASI --}}
                <div class="flex flex-col space-y-4">
                    <h3 class="text-lg font-bold uppercase tracking-widest border-b border-gray-700 pb-2">Lokasi</h3>
                    <a href="https://maps.app.goo.gl/AlamatAsliMas" target="_blank" class="flex items-start space-x-3 group text-left">
                        <div class="text-gray-400 group-hover:text-primary transition shrink-0">
                            <i data-lucide="map-pin"></i>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed group-hover:text-white transition">
                            Perumahan Bunga Pratama Sawangan <br>
                            Blok L-1, Bedahan, Kec. Sawangan, <br>
                            Kota Depok, Jawa Barat 16519
                        </p>
                    </a>
                </div>
            </div>
    
            {{-- PEMBATAS & COPYRIGHT --}}
            <div class="mt-10 border-t border-gray-800 pt-8 text-center text-xs text-gray-600 uppercase tracking-widest">
                &copy; 2025 Dapur Bu Ayu. All Rights Reserved.
            </div>
    
        </div>
    </footer>

    @stack('scripts')

    <script>
        lucide.createIcons();
    </script>

</body>
</html>