@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-4">
    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pengguna</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Apa Kata Mereka Tentang Dapur Bu Ayu</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($reviews as $review)
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-primary font-inter flex flex-col h-full">
                {{-- Bintang --}}
                <div class="flex mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= (int)$review->rating ? '#EAB308' : '#D1D5DB' }} !important; font-size: 1.5rem;">★</span>
                    @endfor
                </div>

                {{-- Komentar --}}
                <p class="text-gray-600 italic mb-4 text-sm leading-relaxed flex-grow">"{{ $review->comment }}"</p>

                {{-- GRID FOTO KECIL --}}
                @if($review->image)
                    <div class="flex flex-wrap gap-2 mb-4">
                        @php
                            $images = [];
                            // Cek apakah datanya sudah format Array (karena Casts) 
                            // atau String JSON (ada kurung siku) atau String Biasa (data lama)
                            if (is_array($review->image)) {
                                $images = $review->image;
                            } elseif (str_starts_with($review->image, '[')) {
                                $images = json_decode($review->image, true);
                            } else {
                                $images = [$review->image]; // Bungkus string biasa jadi array agar bisa di-foreach
                            }
                        @endphp
                        
                        @foreach($images as $img)
                            @if($img)
                                <div class="w-20 h-20 overflow-hidden rounded-lg border border-gray-100 shadow-sm bg-gray-50">
                                    <img src="{{ asset('storage/' . $img) }}" 
                                         class="w-full h-full object-cover hover:scale-110 transition-transform cursor-pointer"
                                         onerror="this.onerror=null;this.src='https://placehold.co/100x100?text=No+Image'"
                                         alt="Review Item">
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif

                {{-- Footer Card --}}
                <div class="border-t pt-3 mt-auto">
                    <p class="font-bold text-gray-800 uppercase tracking-widest text-xs">{{ $review->name }}</p>
                    <p class="text-[10px] text-gray-400 mt-1 font-bold">{{ $review->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&display=swap');
</style>
@endsection