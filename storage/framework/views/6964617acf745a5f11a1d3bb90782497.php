<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?php echo e(config('services.midtrans.client_key')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto px-4 py-8">
    <div class="text-center mb-10">
        <h2 class="text-3xl font-black text-gray-900 tracking-tight uppercase">Halaman Pembayaran</h2>
        <div class="h-1 w-20 bg-primary mx-auto mt-2"></div>
    </div>
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 bg-white p-8 rounded-3xl shadow-xl border border-gray-100">
            <h3 class="text-2xl font-black text-gray-800 mb-6 flex items-center">
                <span class="bg-primary w-2 h-8 rounded-full mr-3"></span>
                Detail Transaksi
            </h3>
            
            <form id="payment-form" class="space-y-6">
                <?php echo csrf_field(); ?>
                <div class="bg-gray-50 p-6 rounded-2xl border border-gray-200">
                    <label for="payment_method" class="block text-sm font-black text-gray-700 uppercase tracking-widest mb-4">
                        Pilih Metode Pembayaran
                    </label>
                    <select name="payment_method" id="payment_method" required 
                            class="block w-full rounded-xl border-gray-300 shadow-sm p-4 text-lg font-bold focus:ring-primary focus:border-primary">
                        <option value="MIDTRANS">Transfer / VA / QRIS (Lunas 100%)</option>
                        <option value="COD">Cash On Delivery (DP 50% via Midtrans)</option>
                    </select>
                    
                    <div id="method-info" class="mt-4 text-sm text-gray-500 italic">
                        *Pembayaran Lunas 100% via Midtrans.
                    </div>
                </div>

                <div class="pt-6 flex justify-end space-x-4 border-t border-gray-100">
                    <button type="button" onclick="history.back()" 
                            class="px-6 py-3 text-gray-500 font-bold hover:text-gray-700 transition">
                        Batal
                    </button>
                    <button type="submit" id="pay-button" 
                            class="px-10 py-4 bg-primary hover:bg-yellow-600 text-white font-black rounded-2xl shadow-xl transition-all transform hover:-translate-y-1">
                        Konfirmasi & Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>

        <div class="bg-gray-900 text-white p-8 rounded-3xl shadow-2xl h-fit sticky top-8">
            <h3 class="text-xl font-black text-primary mb-6 uppercase tracking-widest italic">Ringkasan Pesanan</h3>
            <div class="space-y-4 mb-8">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Nama Paket:</span>
                    <span class="font-bold"><?php echo e($orderData['package_name']); ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Jumlah:</span>
                    <span class="font-bold"><?php echo e($orderData['quantity']); ?> Box</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Tgl Kirim:</span>
                    <span class="font-bold"><?php echo e(\Carbon\Carbon::parse($orderData['delivery_date'])->format('d M Y')); ?></span>
                </div>
            </div>
            <div class="pt-6 border-t border-gray-700">
                <p class="text-xs text-gray-400 uppercase font-bold mb-1">Total Pembayaran</p>
                <p class="text-4xl font-black text-primary">
                    Rp <?php echo e(number_format($orderData['total_price'], 0, ',', '.')); ?>

                </p>
            </div>
        </div>
    </div>
</div>

<script>
    const paymentForm = document.getElementById('payment-form');
    const methodSelect = document.getElementById('payment_method');
    const methodInfo = document.getElementById('method-info');

    methodSelect.addEventListener('change', function() {
        if(this.value === 'COD') {
            methodInfo.innerHTML = "<span class='text-orange-500 font-bold'>*Wajib bayar DP 50% via Midtrans, lalu konfirmasi WhatsApp ke Admin.</span>";
        } else {
            methodInfo.innerHTML = "<span class='text-blue-500 font-bold'>*Pembayaran Lunas 100% via Midtrans.</span>";
        }
    });

    paymentForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // 1. NOTIF: APAKAH ANDA YAKIN?
        Swal.fire({
            title: 'Konfirmasi Pesanan',
            text: "Pastikan data sudah benar sebelum lanjut ke pembayaran.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#EAB308',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Lanjutkan!',
            cancelButtonText: 'Cek Kembali'
        }).then((result) => {
            if (result.isConfirmed) {
                
                Swal.fire({
                    title: 'Memproses Pesanan...',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                const formData = new FormData(paymentForm);

                fetch("<?php echo e(route('order.process_payment')); ?>", {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        Swal.fire('Oops!', data.error, 'error');
                        return;
                    }

                    // 2. NOTIF: INVOICE BERHASIL DIBUAT (HARUS DICATAT)
                    Swal.fire({
                        icon: 'success',
                        title: 'Pesanan Berhasil Dibuat!',
                        html: `
                            <div class="text-center">
                                <p class="mb-4">Mohon catat nomor invoice Anda:</p>
                                <div class="bg-gray-100 border-2 border-dashed border-primary p-3 rounded-lg mb-4">
                                    <span class="text-2xl font-black text-gray-800 tracking-widest">${data.invoice_code}</span>
                                </div>
                                <p class="text-sm text-gray-500 italic">*Gunakan nomor ini untuk mengecek status pesanan.</p>
                            </div>
                        `,
                        confirmButtonText: 'Lanjut Pembayaran',
                        confirmButtonColor: '#EAB308',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // 3. MUNCULKAN MIDTRANS
                            window.snap.pay(data.snap_token, {
                                onSuccess: function(result) {
                                    if (data.method === 'COD') {
                                        window.location.href = data.redirect_url;
                                    } else {
                                        window.location.href = "<?php echo e(route('order.success')); ?>?invoice=" + data.invoice_code;
                                    }
                                },
                                onPending: function(result) {
                                    if (data.method === 'COD') {
                                        window.location.href = data.redirect_url;
                                    } else {
                                        window.location.href = "<?php echo e(route('order.success')); ?>?invoice=" + data.invoice_code;
                                    }
                                },
                                onError: function(result) {
                                    Swal.fire('Gagal!', 'Pembayaran gagal diproses.', 'error');
                                },
                                onClose: function() {
                                    if (data.method === 'COD') {
                                        Swal.fire({
                                            title: 'Pembayaran DP Belum Selesai',
                                            text: 'Anda menutup popup pembayaran. Lanjut ke WhatsApp?',
                                            icon: 'warning',
                                            showCancelButton: true,
                                            confirmButtonText: 'Ya, Lanjut WA',
                                            cancelButtonText: 'Bayar Ulang'
                                        }).then((res) => {
                                            if (res.isConfirmed) window.location.href = data.redirect_url;
                                        });
                                    } else {
                                        Swal.fire('Info', 'Halaman pembayaran ditutup.', 'info');
                                    }
                                }
                            });
                        }
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error!', 'Terjadi kesalahan sistem.', 'error');
                });
            }
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\dapurbuayu\resources\views/payment.blade.php ENDPATH**/ ?>