@extends('layouts.app')

@push('scripts')
{{-- SweetAlert2 untuk notifikasi yang lebih cantik --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- Midtrans Snap JS --}}
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
@endpush

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Halaman Pembayaran</h2>
        <div class="h-1 w-20 bg-primary mx-auto mt-2"></div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Sisi Kiri: Pilihan Pembayaran --}}
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
            <h3 class="text-2xl font-black text-gray-800 mb-6 flex items-center">
                <span class="bg-primary w-2 h-8 rounded-full mr-3"></span>
                Detail Transaksi
            </h3>
            
            <form id="payment-form" class="space-y-6">
                @csrf
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                    <label for="payment_method" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-4">
                        Pilih Metode Pembayaran
                    </label>
                    <select name="payment_method" id="payment_method" required 
                            class="block w-full rounded-xl border-gray-300 shadow-sm p-4 text-lg font-bold focus:ring-primary focus:border-primary">
                        <option value="MIDTRANS">Transfer / VA / QRIS / E-Wallet (Otomatis)</option>
                        <option value="COD">Cash On Delivery (Konfirmasi WA Admin)</option>
                    </select>
                    
                    <div id="method-info" class="mt-4 text-sm text-gray-500 italic">
                        *Metode Transfer akan diverifikasi otomatis oleh sistem.
                    </div>
                </div>

                <div class="pt-6 flex justify-end space-x-4 border-t border-gray-100">
                    <button type="button" onclick="history.back()" 
                            class="px-6 py-3 text-gray-500 font-bold hover:text-gray-700 transition">
                        Batal
                    </button>
                    <button type="submit" id="pay-button" 
                            class="px-10 py-4 bg-primary hover:bg-yellow-600 text-white font-black rounded-2xl shadow-xl shadow-yellow-100 transition-all transform hover:-translate-y-1">
                        Konfirmasi & Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>

        {{-- Sisi Kanan: Ringkasan --}}
        <div class="bg-gray-900 text-white p-8 rounded-3xl shadow-2xl h-fit sticky top-8">
            <h3 class="text-xl font-black text-primary mb-6 uppercase tracking-widest italic">Ringkasan Pesanan</h3>
            
            <div class="space-y-4 mb-8">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Nama Paket:</span>
                    <span class="font-bold">{{ $orderData['package_name'] }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Jumlah:</span>
                    <span class="font-bold">{{ $orderData['quantity'] }} Box</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Tgl Kirim:</span>
                    <span class="font-bold">{{ \Carbon\Carbon::parse($orderData['delivery_date'])->format('d M Y') }}</span>
                </div>
            </div>

            <div class="pt-6 border-t border-gray-700">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Total Pembayaran</p>
                <p class="text-4xl font-black text-primary">
                    Rp {{ number_format($orderData['total_price'], 0, ',', '.') }}
                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const paymentForm = document.getElementById('payment-form');
    const payButton = document.getElementById('pay-button');
    const methodSelect = document.getElementById('payment_method');
    const methodInfo = document.getElementById('method-info');

    // Update info teks saat pilihan berubah
    methodSelect.addEventListener('change', function() {
        if(this.value === 'COD') {
            methodInfo.innerHTML = "<span class='text-orange-500 font-bold'>*Anda akan diarahkan ke WhatsApp Admin untuk konfirmasi pesanan COD.</span>";
        } else {
            methodInfo.innerHTML = "<span class='text-blue-500 font-bold'>*Selesaikan pembayaran melalui popup Midtrans yang akan muncul.</span>";
        }
    });

    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Tampilkan loading
        Swal.fire({
            title: 'Memproses Pesanan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        const formData = new FormData(this);

        fetch("{{ route('order.process_payment') }}", {
            method: "POST",
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                Swal.fire('Oops!', data.error, 'error');
                return;
            }

            if (data.method === 'COD') {
            // ALUR COD: Alert sukses dengan nomor Invoice
            Swal.fire({
                icon: 'success',
                title: 'Pesanan Dicatat!',
                // Bagian di bawah ini ditambahkan template literal untuk invoice
                html: `Pesanan Anda berhasil dibuat dengan nomor invoice:<br><br>` +
                    `<span class="text-xl font-black text-primary p-2 bg-gray-100 rounded border border-dashed border-gray-400">` + 
                    `${data.invoice_code}</span><br><br>` +
                    `Silakan catat nomor invoice dan konfirmasi ke WhatsApp Admin agar segera diproses.`,
                confirmButtonText: 'Lanjut ke WhatsApp',
                confirmButtonColor: '#EAB308', // Warna kuning primary
            }).then(() => {
                window.location.href = data.redirect_url;
            });
        }
            else if (data.method === 'MIDTRANS') {
                // ALUR TRANSFER: Munculkan Snap Popup
                Swal.close();
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        window.location.href = "{{ route('order.success') }}?invoice=" + data.invoice_code;
                    },
                    onPending: function(result) {
                        window.location.href = "{{ route('order.success') }}?invoice=" + data.invoice_code;
                    },
                    onError: function(result) {
                        Swal.fire('Gagal!', 'Pembayaran gagal diproses.', 'error');
                    },
                    onClose: function() {
                        Swal.fire('Info', 'Anda menutup halaman pembayaran sebelum selesai.', 'info');
                    }
                });
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
        });
    });
</script>
@endsection