@extends('layouts.app')
@section('content')
    <h2 class="text-4xl font-extrabold text-gray-900 text-center mb-10">Pilih Paket {{ $type == 'nasi-box' ? 'Nasi Box' : 'Prasmanan' }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
        @forelse($packages as $package)
        <div class="bg-white p-8 rounded-xl shadow-xl border-t-4 border-primary text-center">
            <h3 class="text-2xl font-semibold mb-2 text-gray-700">{{ $package->name }}</h3>
            <img src="{{ asset('images/Order Paket.jpg') }}" alt="Paket" class="mb-4 rounded-lg h-40 w-full object-cover">
            <p class="text-4xl font-bold text-primary mb-6">Rp. {{ number_format($package->price, 0, ',', '.') }}</p>
            <a href="{{ route('order.show_detail', $package->id) }}" class="block w-full bg-primary hover:bg-yellow-600 text-white font-bold py-3 rounded-lg transition duration-300">Pilih Paket</a>
        </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada paket tersedia untuk jenis ini.</p>
        @endforelse
    </div>
@endsection