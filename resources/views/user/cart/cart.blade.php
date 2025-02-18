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
        /* Custom CSS for Cart Page */
        .cart-header {
            background-color: #343a40;
            color: #fff;
            padding: 10px 0;
        }

        .cart-item {
            border-bottom: 1px solid #dee2e6;
            padding: 15px 0;
        }

        .cart-total {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .cart-buttons {
            margin-top: 20px;
        }

        .cart-empty {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>

<body>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="/">Home</a></li>
                        <li class="breadcrumb-item active">cart</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container mt-5">
        <!-- Cart Header -->
        <div class="row cart-header text-center d-none d-md-flex">
            <div class="col-md-2">Product Image</div>
            <div class="col-md-4">Product Name</div>
            <div class="col-md-1">Size</div>
            <div class="col-md-2">Price</div>
            <div class="col-md-1">Quantity</div>
            <div class="col-md-1">Subtotal</div>
            <div class="col-md-1">Delete</div>
        </div>



        <!-- Cart Item -->
        @foreach ($carts as $cart)
            <div class="row cart-item align-items-center text-center">
                <div class="col-md-2">
                    <img src="{{ asset('assets/fotoSO/' . $cart->so->foto) }}" alt="Product" width="100">
                </div>
                <div class="col-md-4">{{ $cart->so->nama }}</div>
                <div class="col-md-1">{{ $cart->size }}</div>
                <div class="col-md-2">Rp {{ number_format($cart->total / $cart->qty) }}</div>
                <div class="col-md-1">
                    <input type="number" class="form-control text-center" value="{{ $cart->qty }}" min="1"
                        readonly>
                </div>
                <div class="col-md-1">Rp {{ number_format($cart->total) }}</div>
                <div class="col-md-1">
                    <form action="{{ url('cartcancle/' . $cart->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-danger delete-data"><i class="bi bi-trash"></i></button>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- Another Cart Item -->


        <!-- Cart Summary -->
        <div class="row mt-4">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                @if ($carts->count() > 0)
                    <div class="cart-total">Hemat: Rp {{ number_format($carts->sum('discount')) }}</div>
                    <div class="cart-total">Total: Rp {{ number_format($carts->sum('total')) }}</div>
                @endif
            </div>
        </div>

        <!-- Buttons for Checkout and Continue Shopping -->
        <div class="row cart-buttons">
            <div class="col-md-6">
                <a href="/" class="btn btn-outline-secondary w-100"
                    onclick="event.preventDefault(); window.history.back();">
                    Continue Shopping
                </a>
            </div>
            <div class="col-md-6">
                <a href="{{ url('payment') }}" class="btn btn-primary w-100">Proceed to Checkout</a>
            </div>
        </div>

        <!-- Empty Cart State -->
        <div class="row cart-empty d-none">
            <div class="col-md-12">
                <h3>Your cart is empty</h3>
                <a href="#" class="btn btn-outline-primary mt-3">Go Shopping</a>
            </div>
        </div>
    </div>

    <div class="position-fixed end-0  bottom-0 p-5">
        <div class="d-flex flex-column align-items-end gap-3">
            <!-- Wishlist Button -->
            <a href="{{ url('wishlist') }}"
                class="btn btn-danger btn-lg rounded-circle shadow d-flex align-items-center justify-content-center"
                style="width: 60px; height: 60px;">
                <i class="bi bi-heart text-white fs-4"></i>
            </a>
        </div>
    </div>


    <!-- Bootstrap JS and dependencies (Popper.js and jQuery) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('.delete-data').click(function(e) {
            e.preventDefault();
            const data = $(this).closest('.cart-item').find('.col-md-4').text();
            Swal.fire({
                title: 'Data Ini akan hilang',
                text: `Apakah penghapusan data ${data} akan dilanjutkan?`,
                icon: 'warning',
                showDenyButton: true,
                confirmButtonText: 'Ya',
                denyButtonText: 'Tidak',
                focusConfirm: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $(e.target).closest('form').submit();
                } else {
                    Swal.close();
                }
            });
        });
    </script>
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
