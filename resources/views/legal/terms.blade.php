@extends('layouts.app')

@section('title', 'Syarat & Ketentuan - Dapur Bu Ayu')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Qwitcher_Grypen:wght@400;700&family=Inter:wght@400;700&display=swap');
        .font-qwitcher { font-family: 'Qwitcher Grypen', cursive; }
        .font-inter { font-family: 'Inter', sans-serif; }
        
        /* CSS yang mencakup h2, h3, dan h4 */
        .prose-custom h2, .prose-custom h3, .prose-custom h4 { 
            color: #1f2937 !important; 
            font-weight: bold !important; 
            margin-top: 2rem !important; 
            margin-bottom: 1rem !important; 
            border-left: 4px solid #f0ad4e !important; 
            padding-left: 1rem !important; 
            text-transform: uppercase !important; 
            font-style: italic !important; 
        }
        .prose-custom ul { list-style-type: disc !important; padding-left: 1.5rem !important; color: #4b5563 !important; margin-bottom: 1rem !important; }
        .prose-custom p { margin-bottom: 1rem !important; line-height: 1.6 !important; color: #4b5563 !important; }
    </style>
@endpush

@section('content')
<div class="max-w-[80%] mx-auto px-4 py-12">
    <div class="text-center mb-12">
        <h2 class="text-6xl font-bold text-primary font-qwitcher">Syarat & Ketentuan</h2>
        <div class="h-1.5 w-24 bg-primary mx-auto mt-4 rounded-full"></div>
    </div>

    <div class="bg-white rounded-xl shadow-xl border border-gray-100 p-8 md:p-12 font-inter prose-custom max-w-none">
        {!! $content !!}
    </div>
</div>
@endsection