<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart Page</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    {{-- SweetAlert2 --}}
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <style>
        .cart-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }

        .cart-item img {
            width: 80px;
            height: auto;
            border-radius: 8px;
            margin-right: 15px;
        }

        .cart-item-details {
            flex: 1;
        }

        .cart-item-title {
            font-weight: bold;
            font-size: 1.1em;
        }

        .cart-item-subtitle {
            color: #777;
        }

        .cart-item-price,
        .cart-item-quantity {
            font-weight: bold;
            font-size: 1.2em;
        }

        .quantity-selector {
            display: flex;
            align-items: center;
        }

        .quantity-selector button {
            background: none;
            border: none;
            font-size: 1.5em;
            padding: 5px;
            cursor: pointer;
            color: #333;
        }
    </style>
</head>

<body>
    <div class=" container">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('karyawan') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ url('shop') }}">shop</a></li>
            <li class="breadcrumb-item active">Dikemas</li>
        </ol>
    </div><!-- /.col -->
    <div class="tab-pane active container pt-5" id="activity">
        @if ($dikemast->isEmpty())
            <p>Belum ada barang</p>
        @else
            @foreach ($dikemast as $order)
                <div class="border rounded p-2">
                    <h5>Kode Invoice: #{{ $order['kodeInvoice'] }}</h5>
                    <div class="container">
                        @foreach ($order['items'] as $dikemas)
                            <div class="cart-item d-flex align-items-center">
                                <!-- Product Image -->
                                <img src="{{ asset('assets/fotoSO/' . $dikemas->so->foto) }}" alt="Product Image">

                                <!-- Product Details -->
                                <div class="cart-item-details">
                                    <div class="cart-item-title">{{ $dikemas->so->nama }}</div>
                                    <div class="cart-item-subtitle">
                                        Size : {{ $dikemas->size }}
                                    </div>
                                </div>

                                <!-- Product Quantity -->
                                <div class="quantity-selector mr-3">
                                    <span class="cart-item-quantity mx-2">QTY
                                        {{ $dikemas->qty }}</span>
                                </div>

                                <!-- Product Price -->
                                <div class="cart-item-price">Rp.
                                    {{ number_format($dikemas->total) }}</div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-success m-1" data-bs-toggle="modal"
                            data-bs-target="#exampleModal{{ $order['kodeInvoice'] }}">
                            selesai
                        </button>
                        <a href="print-paket/{{ $order['kodeInvoice'] }}" class="btn btn-primary m-1">Print</a>
                        <button class="btn btn-danger m-1">Tolak</button>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{ $order['kodeInvoice'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Masukan Resi JNE</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="dikirim/{{ $order['kodeInvoice'] }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <div class="col-sm-12">
                                                <input type="text" name="resi" class="form-control" id="kodese"
                                                    placeholder="Masukan Kode">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-footer -->
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Button trigger modal -->





    <!-- Bootstrap JS and dependencies (Popper.js and jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                title: "Berhasil!",
                text: "{{ $message }}",
                icon: "success"
            });
        </script>
    @endif
    @if ($message = Session::get('error'))
        <script>
            Swal.fire({
                title: "gagal!",
                text: "{{ $message }}",
                icon: "error"
            });
        </script>
    @endif

    @if ($message = Session::get($errors->any()))
        <script>
            Swal.fire({
                title: "Errors!",
                text: "{{ $message }}",
                icon: "error"
            });
        </script>
    @endif
</body>

</html>
