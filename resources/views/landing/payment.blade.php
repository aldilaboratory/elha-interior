@extends('layout.landing')
@section('css')
<style>
    /* Background dengan gradient yang menarik */
    .payment-container {
        /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        min-height: 100vh;
        padding: 2rem 0;
        position: relative;
        overflow: hidden;
    }

    .payment-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        pointer-events: none;
    }

    /* Card dengan efek glassmorphism */
    .payment-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 24px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
    }

    .payment-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.15);
    }

    /* Header dengan gradient orange */
    .payment-header {
        border-bottom: 1px solid rgb(218, 218, 218);
        padding: 2rem;
        position: relative;
        overflow: hidden;
    }

    .payment-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0%, 100% { transform: rotate(0deg); }
        50% { transform: rotate(180deg); }
    }

    .payment-header h4 {
        position: relative;
        z-index: 2;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    /* Icon dengan animasi yang lebih smooth */
    .payment-icon {
        position: relative;
        margin-bottom: 2rem;
    }

    .payment-icon i {
        animation: float 3s ease-in-out infinite;
        filter: drop-shadow(0 4px 8px rgba(255, 107, 53, 0.3));
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-10px) rotate(5deg); }
    }

    /* Total amount dengan styling yang lebih menarik */
    .total-amount {
        /* background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); */
        border-radius: 16px;
        padding: 2rem;
        margin: 2rem 0;
        border: 1px solid rgba(255, 107, 53, 0.1);
        position: relative;
        overflow: hidden;
    }

    .total-amount::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        /* background: linear-gradient(90deg, transparent, rgba(255, 107, 53, 0.1), transparent); */
        /* animation: slide 2s infinite; */
    }

    @keyframes slide {
        0% { left: -100%; }
        100% { left: 100%; }
    }

    .total-amount h2 {
        font-size: 3rem;
        font-weight: 800;
        background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin: 0;
        position: relative;
        z-index: 2;
    }

    /* Button dengan efek yang lebih menarik */
    .btn-payment {
        background: #ff6b35;
        border: none;
        border-radius: 16px;
        padding: 1.2rem 2rem;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        /* transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); */
        position: relative;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(255, 107, 53, 0.3);
    }

    .btn-payment::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        /* background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent); */
        transition: left 0.5s;
    }

    .btn-payment:hover::before {
        left: 100%;
    }

    .btn-payment:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 35px rgba(255, 107, 53, 0.4);
        background: linear-gradient(135deg, #e55a2b 0%, #e8851a 100%);
    }

    .btn-payment:active {
        transform: translateY(0);
    }

    /* Security info dengan styling yang lebih baik */
    .security-info {
        background: rgba(255, 107, 53, 0.1);
        border: 1px solid rgba(255, 107, 53, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin: 1.5rem 0;
    }

    /* Payment methods dengan layout yang lebih baik */
    .payment-methods {
        background: rgba(248, 249, 250, 0.8);
        border-radius: 0 0 24px 24px;
        padding: 1.5rem;
        border-top: 1px solid rgba(0, 0, 0, 0.1);
    }

    .payment-methods .method-icon {
        display: inline-block;
        margin: 0 8px;
        padding: 8px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .payment-methods .method-icon:hover {
        transform: translateY(-2px);
    }

    /* Success modal dengan styling yang lebih menarik */
    .success-modal .modal-content {
        border-radius: 24px;
        border: none;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
    }

    .success-icon i {
        animation: successPulse 1s ease-in-out;
        filter: drop-shadow(0 4px 12px rgba(255, 107, 53, 0.3));
    }

    @keyframes successPulse {
        0% { transform: scale(0) rotate(-180deg); opacity: 0; }
        50% { transform: scale(1.2) rotate(0deg); opacity: 1; }
        100% { transform: scale(1) rotate(0deg); opacity: 1; }
    }

    /* Responsive design yang lebih baik */
    @media (max-width: 992px) {
        .payment-container {
            padding: 1.5rem 0;
        }
        
        .payment-card {
            margin: 0 1rem;
        }
        
        .total-amount h2 {
            font-size: 2.5rem;
        }
    }

    @media (max-width: 768px) {
        .payment-container {
            padding: 1rem 0;
            /* background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); */
        }
        
        .payment-card {
            margin: 0.5rem;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
        }

        .payment-header {
            padding: 1.5rem 1rem;
        }

        .payment-header h4 {
            font-size: 1.3rem;
        }

        .total-amount {
            padding: 1.5rem;
            margin: 1.5rem 0;
        }
        
        .total-amount h2 {
            font-size: 2.2rem;
        }

        .btn-payment {
            padding: 1rem 1.5rem;
            font-size: 1rem;
            border-radius: 12px;
        }

        .payment-icon i {
            font-size: 3rem !important;
        }

        .order-details .col-6 > div {
            padding: 1rem !important;
            font-size: 0.9rem;
        }

        .security-info {
            padding: 0.8rem;
            font-size: 0.85rem;
        }

        .payment-methods {
            padding: 1rem;
        }

        .method-icon {
            margin: 0 4px !important;
            padding: 6px !important;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 576px) {
        .payment-container {
            padding: 0.5rem 0;
        }
        
        .payment-card {
            margin: 0.25rem;
            border-radius: 16px;
        }

        .payment-header {
            padding: 1rem;
        }

        .payment-header h4 {
            font-size: 1.1rem;
        }

        .total-amount {
            padding: 1rem;
            margin: 1rem 0;
        }
        
        .total-amount h2 {
            font-size: 1.8rem;
            line-height: 1.2;
        }

        .total-amount h5 {
            font-size: 0.9rem;
        }

        .btn-payment {
            padding: 0.9rem 1.2rem;
            font-size: 0.95rem;
            border-radius: 10px;
        }
        
        .payment-icon {
            margin-bottom: 1rem;
        }
        
        .payment-icon i {
            font-size: 2.5rem !important;
        }

        .order-details .row {
            gap: 0.5rem;
        }

        .order-details .col-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }

        .order-details .col-6 > div {
            padding: 0.8rem !important;
            text-align: center;
        }

        .security-info {
            padding: 0.7rem;
            font-size: 0.8rem;
            margin: 1rem 0;
        }

        .payment-methods {
            padding: 0.8rem;
        }

        .payment-methods small {
            font-size: 0.8rem;
        }

        .method-icon {
            margin: 0 2px !important;
            padding: 4px !important;
            font-size: 0.8rem;
        }

        /* Modal responsivitas */
        .success-modal .modal-dialog {
            margin: 1rem;
        }

        .success-modal .modal-content {
            border-radius: 16px;
        }

        .success-modal .modal-body {
            padding: 2rem 1.5rem !important;
        }

        .success-modal h3 {
            font-size: 1.3rem;
        }

        .success-modal .alert {
            font-size: 0.85rem;
            padding: 0.7rem;
        }

        .success-modal .btn {
            padding: 0.8rem 1.2rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 400px) {
        .payment-card {
            margin: 0.1rem;
        }

        .payment-header {
            padding: 0.8rem;
        }

        .payment-header h4 {
            font-size: 1rem;
        }

        .total-amount h2 {
            font-size: 1.6rem;
        }

        .btn-payment {
            padding: 0.8rem 1rem;
            font-size: 0.9rem;
        }

        .payment-icon i {
            font-size: 2rem !important;
        }

        .method-icon {
            margin: 0 1px !important;
            padding: 3px !important;
            font-size: 0.7rem;
        }
    }

    /* Landscape orientation untuk mobile */
    @media (max-height: 600px) and (orientation: landscape) {
        .payment-container {
            padding: 0.5rem 0;
        }

        .payment-card {
            margin: 0.25rem;
        }

        .payment-header {
            padding: 0.8rem;
        }

        .total-amount {
            padding: 0.8rem;
            margin: 0.8rem 0;
        }

        .total-amount h2 {
            font-size: 1.5rem;
        }

        .payment-icon {
            margin-bottom: 0.5rem;
        }

        .payment-icon i {
            font-size: 2rem !important;
        }

        .btn-payment {
            padding: 0.7rem 1rem;
        }

        .security-info {
            margin: 0.5rem 0;
            padding: 0.5rem;
        }

        .payment-methods {
            padding: 0.5rem;
        }
    }
</style>
@endsection
@section('content')
<div class="payment-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="payment-card">
                    <div class="payment-header text-center text-white">
                        <h4 class="mb-0">Pembayaran</h4>
                    </div>
                    
                    <div class="p-4">
                        <div class="text-center payment-icon">
                            <i class="fas fa-money-bill-wave" style="font-size: 3rem; color: #ff6b35;"></i>
                        </div>

                        <div class="total-amount text-center">
                            <h5 class="text-muted mb-2">Total Pembayaran</h5>
                            <h2>Rp {{ number_format($total, 0, ',', '.') }}</h2>
                        </div>

                        {{-- <div class="security-info text-center mb-4">
                            <i class="fas fa-shield-alt me-2" style="color: #ff6b35;"></i>
                            <small>Pembayaran aman dengan Midtrans</small>
                        </div> --}}

                        <div class="text-center">
                            <button id="pay-button" class="btn btn-payment w-100 text-white">
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
                    
                    {{-- <div class="payment-methods text-center">
                        <small class="text-muted d-block mb-3">Metode Pembayaran Tersedia:</small>
                        <div>
                            <img src="http://elhainterior.test/assets/images/metode_pembayaran.svg"
                                alt="Midtrans" height="20" class="method-icon me-2">
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade success-modal" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-5">
                <div class="success-icon mb-4">
                    <div class="position-relative d-inline-block">
                        <i class="fas fa-check-circle fa-5x" style="color: #ff6b35;"></i>
                        <div class="position-absolute top-0 start-0 w-100 h-100 rounded-circle" 
                             style="background: radial-gradient(circle, rgba(255,107,53,0.2) 0%, transparent 70%); animation: pulse 2s infinite;"></div>
                    </div>
                </div>
                
                <h3 class="mb-3" style="color: #ff6b35; font-weight: 700;">🎉 Pembayaran Berhasil!</h3>
                
                <div class="alert alert-success border-0 mb-4" style="background: rgba(255,107,53,0.1); color: #333;">
                    <i class="fas fa-info-circle me-2" style="color: #ff6b35;"></i>
                    Terima kasih! Pembayaran Anda telah berhasil diproses.
                    <br>Kami akan segera memproses pesanan Anda.
                </div>
                
                <div class="d-grid gap-3">
                    <a href="{{ route('landing.pesanan') }}" class="btn btn-payment text-white">
                        <i class="fas fa-list me-2"></i>
                        Lihat Pesanan Saya
                    </a>
                    <a href="{{ route('landing.index') }}" class="btn btn-outline-secondary rounded-3">
                        <i class="fas fa-home me-2"></i>
                        Kembali ke Beranda
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    // Animasi entrance untuk card
    document.addEventListener('DOMContentLoaded', function() {
        const paymentCard = document.querySelector('.payment-card');
        paymentCard.style.opacity = '0';
        paymentCard.style.transform = 'translateY(50px)';
        
        setTimeout(() => {
            paymentCard.style.transition = 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)';
            paymentCard.style.opacity = '1';
            paymentCard.style.transform = 'translateY(0)';
        }, 100);

        // Animasi untuk method icons
        const methodIcons = document.querySelectorAll('.method-icon');
        methodIcons.forEach((icon, index) => {
            icon.style.opacity = '0';
            icon.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                icon.style.transition = 'all 0.5s ease';
                icon.style.opacity = '1';
                icon.style.transform = 'translateY(0)';
            }, 1000 + (index * 100));
        });
    });

    document.getElementById('pay-button').addEventListener('click', function() {
        const payButton = this;
        const loadingSpinner = document.getElementById('loading-spinner');

        // Animasi button loading yang lebih menarik
        payButton.disabled = true;
        payButton.style.transform = 'scale(0.95)';
        
        // Efek ripple
        const ripple = document.createElement('span');
        ripple.style.position = 'absolute';
        ripple.style.borderRadius = '50%';
        ripple.style.background = 'rgba(255, 255, 255, 0.6)';
        ripple.style.transform = 'scale(0)';
        ripple.style.animation = 'ripple 0.6s linear';
        ripple.style.left = '50%';
        ripple.style.top = '50%';
        ripple.style.width = '20px';
        ripple.style.height = '20px';
        ripple.style.marginLeft = '-10px';
        ripple.style.marginTop = '-10px';
        
        payButton.appendChild(ripple);
        
        setTimeout(() => {
            payButton.removeChild(ripple);
        }, 600);

        // Loading state dengan animasi
        setTimeout(() => {
            loadingSpinner.classList.remove('d-none');
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memproses Pembayaran...';
            payButton.style.background = 'linear-gradient(135deg, #6c757d 0%, #495057 100%)';
        }, 200);

        // Simulate payment processing dengan delay yang realistis
        setTimeout(function() {
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

                            showSuccessAnimation();
                            setTimeout(() => {
                                // Show success modal
                                const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                successModal.show();
                            }, 500);

                            // Optional: Redirect after showing modal
                            setTimeout(() => {
                                window.location.href = '{{ route("shop") ?? "/" }}';
                            }, 3000);
                        })
                        .catch(error => {
                            console.error('Error sending payment status:', error);
                            showNotification('Pembayaran berhasil, namun terjadi kesalahan saat memperbarui status. Silakan hubungi customer service.', 'error');
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
                            showNotification('Pembayaran sedang diproses. Kami akan menginformasikan status pembayaran Anda segera.', 'warning');
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

                    showNotification('Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.', 'error');
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
        }, 1500);

        function resetButton() {
            payButton.disabled = false;
            payButton.style.transform = 'scale(1)';
            payButton.style.background = 'linear-gradient(135deg, #ff6b35 0%, #f7931e 100%)';
            loadingSpinner.classList.add('d-none');
            payButton.innerHTML = '<i class="fas fa-lock me-2"></i>Bayar Sekarang';
        }

        function showSuccessAnimation() {
            // Animasi konfetti sederhana
            const paymentCard = document.querySelector('.payment-card');
            paymentCard.style.animation = 'successBounce 0.6s ease-in-out';
            
            setTimeout(() => {
                paymentCard.style.animation = '';
            }, 600);
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `alert alert-${type === 'error' ? 'danger' : 'warning'} position-fixed`;
            notification.style.top = '20px';
            notification.style.right = '20px';
            notification.style.zIndex = '9999';
            notification.style.minWidth = '300px';
            notification.style.borderRadius = '12px';
            notification.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
            notification.innerHTML = `
                <i class="fas fa-${type === 'error' ? 'exclamation-triangle' : 'clock'} me-2"></i>
                ${message}
                <button type="button" class="btn-close float-end" onclick="this.parentElement.remove()"></button>
            `;
            
            document.body.appendChild(notification);
            
            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }

        // CSS untuk animasi tambahan
        const style = document.createElement('style');
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
            
            @keyframes successBounce {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.05); }
            }
        `;
        document.head.appendChild(style);
    });
</script>
@endsection