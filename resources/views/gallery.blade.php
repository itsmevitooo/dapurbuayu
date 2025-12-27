@extends('layouts.app')

@section('content')
<div class="py-12 px-4 max-w-7xl mx-auto">
    {{-- Header --}}
    <div class="text-center mb-16">
        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-800 uppercase italic mb-4">Galeri Kami</h1>
        <div class="h-1.5 w-24 bg-primary mx-auto rounded-full"></div>
    </div>

    @php
        // Ambil kategori unik (Otomatis buat section baru jika ada kategori baru)
        $categories = $galleries->pluck('category')->unique();
    @endphp

    @forelse($categories as $category)
        <div class="mb-20">
            {{-- Nama Section Otomatis --}}
            <h2 class="text-2xl font-bold text-gray-800 uppercase tracking-wider mb-8 flex items-center">
                {{ $category == 'customer' ? 'Review Pengguna' : $category }}
                <span class="flex-1 h-px bg-gray-200 ml-4"></span>
            </h2>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($galleries->where('category', $category) as $item)
                    <div class="group relative overflow-hidden rounded-2xl shadow-lg bg-white transform transition duration-500 hover:-translate-y-2">
                        @php
                            $path = $item->image;

                            // LOGIC OTOMATIS: 
                            // Jika di database tidak ada '/' (berarti file admin yang nyasar ke root public)
                            if (!Str::contains($path, '/')) {
                                // Jika kategori 'customer', cari di reviews/
                                if ($category == 'customer') {
                                    $path = 'reviews/' . $path;
                                } else {
                                    // Jika kategori lain (Menu, PAKET A, dll), cari di pakets/
                                    $path = 'pakets/' . $path;
                                }
                            }
                        @endphp

                        <img src="{{ asset('storage/' . $path) }}" 
                             class="w-full h-64 object-cover"
                             onerror="this.src='https://placehold.co/600x400?text=File+Belum+Dipindah'">
                        
                        {{-- Info Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 p-6 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col justify-end">
                            <h3 class="text-white font-bold">{{ $item->title }}</h3>
                            <p class="text-gray-300 text-xs italic">{{ $category }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @empty
        <p class="text-center py-20 text-gray-400 italic text-lg">Belum ada koleksi foto.</p>
    @endforelse
</div>
@endsection