@extends('layouts.app') 

@section('content')
<div class="container mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center mb-10 text-gray-800">Review Pengguna</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        @foreach($reviews as $review)
            <div class="bg-white p-6 rounded-xl shadow-lg border-b-4 border-yellow-500">
                <div class="flex mb-3">
                    @for($i = 1; $i <= 5; $i++)
                        <span style="color: {{ $i <= (int)$review->rating ? '#FBBF24' : '#D1D5DB' }} !important; font-size: 1.5rem;">★</span>
                    @endfor
                </div>
                <p class="text-gray-600 italic mb-4">"{{ $review->comment }}"</p>
                <div class="border-t pt-3">
                    <p class="font-bold text-gray-800">{{ $review->name }}</p>
                    <p class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection