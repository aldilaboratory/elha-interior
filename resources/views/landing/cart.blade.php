@extends('layout.landing')
@section('css')
@endsection

@section('content')
<div class="container my-5">
    <h3>Keranjang Belanja</h3>

    {{-- Flash Messages --}}
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    {{-- Form Checkout --}}
    <form id="cart-form" action="{{ route('landing.checkout') }}" method="GET">
        <div class="table-responsive mt-4">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cartItems as $item)
                    <tr data-item-id="{{ $item->id }}" data-price="{{ $item->produk_harga }}">
                        <td>{{ $item->produk_nama }}</td>
                        <td>Rp {{ number_format($item->produk_harga) }}</td>
                        <td>
                            <div class="input-group input-group-sm" style="width: 120px;">
                                <button type="button" class="btn btn-outline-secondary btn-sm qty-btn" data-action="decrease">-</button>
                                <input type="number" name="qty[{{ $item->id }}]" class="form-control form-control-sm text-center qty-input" value="{{ $item->jumlah }}" min="1" max="99" data-original-qty="{{ $item->jumlah }}">
                                <button type="button" class="btn btn-outline-secondary btn-sm qty-btn" data-action="increase">+</button>
                            </div>
                        </td>
                        <td class="item-total">Rp {{ number_format($item->produk_harga * $item->jumlah) }}</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm delete-item-btn" data-item-id="{{ $item->id }}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Keranjang kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(count($cartItems) > 0)
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Ringkasan Belanja</h6>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Harga:</span>
                            <span id="grand-total">Rp {{ number_format($cartItems->sum(function($item) { return $item->produk_harga * $item->jumlah; })) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 text-end">
                <button type="submit" class="btn btn-success btn-lg">Lanjut ke Checkout</button>
            </div>
        </div>
        @endif
    </form>
</div>

{{-- Hidden form untuk hapus item --}}
<form id="delete-form" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Submit delete form
        document.querySelectorAll('.delete-item-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) return;

                const form = document.getElementById('delete-form');
                form.action = "{{ route('landing.cart.delete', ['id' => '__ID__']) }}".replace('__ID__', this.dataset.itemId);
                form.submit();
            });
        });

        // Update total
        function updateGrandTotal() {
            const rows = document.querySelectorAll('tbody tr[data-item-id]');
            let grandTotal = 0;
            rows.forEach(row => {
                const price = parseFloat(row.dataset.price);
                const qty = parseInt(row.querySelector('.qty-input').value);
                grandTotal += price * qty;
            });
            const grandTotalElement = document.getElementById('grand-total');
            if (grandTotalElement) {
                grandTotalElement.textContent = 'Rp ' + numberFormat(grandTotal);
            }
        }

        // Format angka
        function numberFormat(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Qty +/-
        const qtyBtns = document.querySelectorAll('.qty-btn');
        const qtyInputs = document.querySelectorAll('.qty-input');

        qtyBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const action = this.dataset.action;
                const input = this.parentNode.querySelector('.qty-input');
                let currentQty = parseInt(input.value);

                if (action === 'increase') {
                    currentQty = Math.min(currentQty + 1, 99);
                } else if (action === 'decrease') {
                    currentQty = Math.max(currentQty - 1, 1);
                }

                input.value = currentQty;
                updateItemTotal(input);
                updateGrandTotal();
            });
        });

        function updateItemTotal(input) {
            const row = input.closest('tr');
            const price = parseFloat(row.dataset.price);
            const qty = parseInt(input.value);
            const total = price * qty;
            const totalCell = row.querySelector('.item-total');
            totalCell.textContent = 'Rp ' + numberFormat(total);
        }

        qtyInputs.forEach(input => {
            input.addEventListener('change', function() {
                let value = parseInt(this.value);
                const min = parseInt(this.min);
                const max = parseInt(this.max);

                if (value < min) value = min;
                if (value > max) value = max;

                this.value = value;
                updateItemTotal(this);
                updateGrandTotal();
            });
        });
    });
</script>
@endsection