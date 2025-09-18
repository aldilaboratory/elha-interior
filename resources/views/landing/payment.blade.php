@extends('layout.landing')
@section('css')
<style>
    .card {
        transition: all 0.3s ease;
    }

    .card:hover {
        transform: translateY(-2px);
    }

    .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-success:hover {
        background: linear-gradient(135deg, #218838 0%, #1ea885 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    }

    .payment-icon {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.1);
        }

        100% {
            transform: scale(1);
        }
    }

    .total-amount h2 {
        font-size: 2.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
    }

    .success-icon i {
        animation: bounceIn 0.8s ease;
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }

        50% {
            transform: scale(1.05);
        }

        70% {
            transform: scale(0.9);
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }

    .payment-methods i {
        font-size: 1.2rem;
        margin: 0 2px;
    }

    @media (max-width: 768px) {
        .total-amount h2 {
            font-size: 2rem;
        }

        .card-body {
            padding: 2rem 1.5rem;
        }
    }
</style>
@endsection
@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 rounded-3">
                <div class="card-header bg-primary text-white text-center py-4">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>
                        Pembayaran
                    </h4>
                </div>

                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="payment-icon mb-3">
                            <i class="fas fa-money-bill-wave text-success" style="font-size: 3rem;"></i>
                        </div>

                        <div class="total-amount mb-3">
                            <p class="text-muted mb-1">Total Pembayaran</p>
                            <h2 class="text-primary fw-bold mb-0">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </h2>
                        </div>

                        <div class="payment-info bg-light rounded p-3 mb-4">
                            <small class="text-muted">
                                <i class="fas fa-shield-alt me-1"></i>
                                Pembayaran aman dengan Midtrans
                            </small>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button id="pay-button" class="btn btn-success btn-lg rounded-3 py-3">
                            <i class="fas fa-lock me-2"></i>
                            Bayar Sekarang
                            <div class="spinner-border spinner-border-sm ms-2 d-none" id="loading-spinner" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <small class="text-muted">
                            Dengan melanjutkan, Anda menyetujui syarat dan ketentuan kami
                        </small>
                    </div>
                </div>

                <div class="card-footer bg-light text-center py-3">
                    <div class="payment-methods">
                        <small class="text-muted me-3">Metode Pembayaran:</small>
                        <img src="https://cdn.jsdelivr.net/gh/midtrans/midtrans-nodejs/examples/public/assets/midtrans-logo.png"
                            alt="Midtrans" height="20" class="me-2">
                        <i class="fab fa-cc-visa text-primary me-1" title="Visa"></i>
                        <i class="fab fa-cc-mastercard text-warning me-1" title="Mastercard"></i>
                        <i class="fas fa-university text-info me-1" title="Bank Transfer"></i>
                        <i class="fas fa-wallet text-success" title="E-Wallet"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-body text-center p-5">
                <div class="success-icon mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                </div>
                <h4 class="text-success mb-3">Pembayaran Berhasil!</h4>
                <p class="text-muted mb-4">Terima kasih, pembayaran Anda telah diproses dengan sukses.</p>
                <button type="button" class="btn btn-success px-4" data-bs-dismiss="modal">
                    <i class="fas fa-home me-2"></i>Kembali
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    document.getElementById('pay-button').addEventListener('click', function() {
        const payButton = this;
        const loadingSpinner = document.getElementById('loading-spinner');

        // Show loading state
        payButton.disabled = true;
        loadingSpinner.classList.remove('d-none');
        payButton.innerHTML = '<i class="fas fa-lock me-2"></i>Memproses... <div class="spinner-border spinner-border-sm ms-2" role="status"><span class="visually-hidden">Loading...</span></div>';

        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result) {
                console.log('Payment Success:', result);

                // Send payment status to server
                fetch('{{ route("landing.payment.changestatus") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: result.order_id,
                            transaction_status: result.transaction_status,
                            payment_type: result.payment_type,
                            transaction_id: result.transaction_id,
                            status_code: result.status_code,
                            gross_amount: result.gross_amount,
                            signature_key: result.signature_key,
                            payment_status: 'success',
                            transaksi_id: '{{$transaksi_id}}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Server Response:', data);

                        // Show success modal
                        const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        successModal.show();

                        // Optional: Redirect after showing modal
                        setTimeout(() => {
                            window.location.href = '{{ route("shop") ?? "/" }}';
                        }, 3000);
                    })
                    .catch(error => {
                        console.error('Error sending payment status:', error);
                        alert('Pembayaran berhasil, namun terjadi kesalahan saat memperbarui status. Silakan hubungi customer service.');
                    })
                    .finally(() => {
                        // Reset button state
                        resetButton();
                    });
            },

            onPending: function(result) {
                console.log('Payment Pending:', result);

                // Send pending status to server
                fetch('{{ route("landing.payment.changestatus") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: result.order_id,
                            transaction_status: result.transaction_status,
                            payment_type: result.payment_type,
                            transaction_id: result.transaction_id,
                            status_code: result.status_code,
                            gross_amount: result.gross_amount,
                            signature_key: result.signature_key,
                            payment_status: 'pending',
                            transaksi_id: '{{$transaksi_id}}'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Server Response:', data);
                        alert('Pembayaran sedang diproses. Kami akan menginformasikan status pembayaran Anda segera.');
                    })
                    .catch(error => {
                        console.error('Error sending payment status:', error);
                    })
                    .finally(() => {
                        resetButton();
                    });
            },

            onError: function(result) {
                console.log('Payment Error:', result);

                // Send error status to server
                fetch('{{ route("landing.payment.changestatus") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            order_id: result.order_id || 'unknown',
                            transaction_status: 'failed',
                            payment_status: 'failed',
                            error_message: result.status_message || 'Payment failed'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Server Response:', data);
                    })
                    .catch(error => {
                        console.error('Error sending payment status:', error);
                    })
                    .finally(() => {
                        resetButton();
                    });

                alert('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
            },

            onClose: function() {
                console.log('Payment popup closed');
                resetButton();

                // Show confirmation dialog
                if (confirm('Anda menutup halaman pembayaran. Apakah Anda yakin ingin membatalkan pembayaran?')) {
                    // Optional: Send cancellation status to server
                    fetch('{{ route("landing.payment.changestatus") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                payment_status: 'cancelled',
                                order_id: '{{ $snapToken ?? "unknown" }}'
                            })
                        })
                        .catch(error => {
                            console.error('Error sending cancellation status:', error);
                        });
                }
            }
        });

        function resetButton() {
            payButton.disabled = false;
            loadingSpinner.classList.add('d-none');
            payButton.innerHTML = '<i class="fas fa-lock me-2"></i>Bayar Sekarang';
        }
    });
</script>
@endsection