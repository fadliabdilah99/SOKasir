<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Layout Responsive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .product-section,
        .address-section {
            border: 1px solid #ddd;
            padding: 20px;
            margin-bottom: 20px;
            background-color: #f8f9fa;
        }

        .product-info {
            font-size: 14px;
        }

        .badge-danger {
            color: white;
        }

        .protection-section,
        .total-section {
            margin-top: 15px;
            background-color: #fff;
        }

        .total-section {
            font-size: 18px;
        }

        .total-section .total-price {
            color: #e74c3c;
            font-weight: bold;
            font-size: 24px;
        }

        .product-image {
            max-width: 100px;
            max-height: 100px;
            margin-right: 20px;
        }
    </style>
</head>

<body>

    <div class="container my-5">

        <!-- Address Section -->
        <div class="address-section mb-4">
            <h5 class="mb-3">Alamat Pengiriman</h5>
            <div class="d-flex align-items-center">
                <div class="me-3">
                    <span class="badge bg-success">Toko Pilihan</span>
                </div>
                <div>
                    <p><strong>Estation</strong></p>
                    <p class="mb-0">Jl. Mawar No. 123, Jakarta, Indonesia</p>
                    <a href="{{ url('alamat') }}" class="text-decoration-none">Ubah Alamat</a>
                </div>
            </div>
        </div>

        <!-- Product Section -->
        <div class="product-section">
            <h5 class="mb-4">Produk Dipesan</h5>
            <!-- Proteksi Kerusakan -->


            <!-- Second Product -->
            @php
                $totalbarang = 0;
                $totalharga = 0;
                $discountbarang = 0;
            @endphp
            @foreach ($barangs as $barang)
                <div class="row align-items-center mt-3">
                    <div class="col-md-6 d-flex">
                        <img src="{{ asset('assets/fotoSO/' . $barang->so->foto) }}" class="product-image"
                            alt="Product Image">
                        <div class="product-info">
                            <p><strong>{{ $barang->so->nama }} | {{ $barang->so->kategori->name }}</strong></p>
                            <p>Variasi: {{ $barang->size }}</p>
                            <span class="badge bg-danger">Bebas Pengembalian</span>
                        </div>
                    </div>
                    <div class="col-md-2 text-end">
                        <p>Rp {{ number_format($harga = ($barang->total + $barang->discount) / $barang->qty) }} </p>
                    </div>
                    <div class="col-md-2 text-center">
                        <p>{{ $barang->qty }}</p>
                    </div>
                    <div class="col-md-2 text-end">
                        <p>Rp {{ number_format($total = $harga * $barang->qty) }}</p>
                    </div>
                </div>
                @php
                    $totalbarang += $barang->qty;
                    $totalharga += $total;
                    $discountbarang += $barang->discount;
                @endphp
            @endforeach

        </div>

        <!-- Pesan Section -->
        <div class="row my-3">
            <div class="col-md-6">
                <label for="message" class="form-label">Pesan (Opsional)</label>
                <input type="text" class="form-control" id="message" placeholder="Tinggalkan pesan ke penjual">
            </div>
        </div>

        <!-- Voucher and Delivery Options -->
        <div class="row voucher-section">
            <div class="col-md-6">
                <p><strong>Voucher Toko</strong> <a href="#" class="edit-link">Pilih Voucher</a></p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Pengiriman:</strong> JNE</p>
                <p>-</p>
            </div>
        </div>

        <!-- Total Section -->
        <div class="total-section text-end">
            <p>Total Pesanan ({{ $totalbarang }} Produk): <span class="total-price">Rp
                    {{ number_format($totalharga) }}</span></p>
            <p>discount barang : - {{ $discountbarang > 0 ? 'Rp ' . number_format($discountbarang) : '' }}</p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
