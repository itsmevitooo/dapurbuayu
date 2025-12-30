@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-4">
    {{-- Header Judul Selaras --}}
    <div class="text-center mb-12">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pengguna</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Apa Kata Mereka Tentang Dapur Bu Ayu</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($reviews as $review)
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-primary font-inter">
                <div class="flex mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= (int)$review->rating ? '#EAB308' : '#D1D5DB' }} !important; font-size: 1.5rem;">★</span>
                    @endfor
                </div>
                <p class="text-gray-600 italic mb-4 text-sm leading-relaxed">"{{ $review->comment }}"</p>
                <div class="border-t pt-3">
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