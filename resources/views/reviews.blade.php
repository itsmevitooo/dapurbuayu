@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h1 class="text-6xl font-bold text-primary font-[Qwitcher_Grypen]">Review Pengguna</h1>
        <p class="text-gray-500 font-inter uppercase tracking-[0.3em] text-[10px] mt-2 font-bold">Apa Kata Mereka Tentang Dapur Bu Ayu</p>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @forelse($reviews as $review)
            <div class="bg-white p-6 rounded-2xl shadow-xl border-b-4 border-primary font-inter flex flex-col h-full transition-all hover:shadow-2xl">
                <div class="flex mb-4">
                    @for($i = 1; $i <= 5; $i++)
                        <svg class="w-6 h-6 {{ $i <= (int)$review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                        </svg>
                    @endfor
                </div>

                <p class="text-gray-600 italic mb-6 text-sm flex-grow">"{{ $review->comment }}"</p>

                @if($review->image)
                    @php
                        $images = is_array($review->image) ? $review->image : json_decode($review->image, true);
                    @endphp
                    @if(!empty($images))
                    <div class="flex flex-wrap gap-2 mb-6">
                        @foreach($images as $img)
                            @if($img)
                            <div class="w-20 h-20 overflow-hidden rounded-xl border border-gray-100 shadow-sm">
                                <img src="{{ asset('storage/' . ltrim($img, '/')) }}" class="w-full h-full object-cover">
                            </div>
                            @endif
                        @endforeach
                    </div>
                    @endif
                @endif

                <div class="border-t border-gray-50 pt-4 mt-auto">
                    <p class="font-black text-gray-900 uppercase tracking-wider text-[11px]">{{ $review->name }}</p>
                    <p class="text-[9px] text-gray-400 mt-0.5 uppercase tracking-tighter">
                        {{ $review->created_at ? $review->created_at->translatedFormat('d F Y') : 'Baru saja' }}
                    </p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-20">
                <p class="text-gray-400 italic">Belum ada ulasan untuk saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection