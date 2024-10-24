<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .wishlist-item {
            border: 1px solid #000;
            padding: 10px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .wishlist-item img {
            width: 100px;
            height: 100px;
            background-color: #ccc;
        }

        .wishlist-details {
            flex: 1;
            padding-left: 10px;
        }

        .wishlist-price {
            font-weight: bold;
        }

        .wishlist-remove {
            background-color: #ff3b3b;
            color: white;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .wishlist-remove i {
            font-size: 24px;
        }

        .wishlist-remove:hover {
            background-color: #e60000;
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
                        <li class="breadcrumb-item active">Wishlist</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <div class="container">
        <h2 class="text-center my-5">WISHLIST</h2>
        @if ($wishlists->count() == 0)
            <div class="d-flex justify-content-center">
                <div class="alert alert-danger col-2 text-center" role="alert">
                    <p class="mb-0">Belum ada wishlist <a href="{{ url('shop') }}" class="alert-link">kembali</a>
                    </p>
                </div>
            </div>
        @endif
        @foreach ($wishlists as $wishlist)
            <div class="d-flex justify-content-center">
                <div class="wishlist-item row rounded-4 col-9">
                    <div class="col-2">
                        <img src="{{ asset('assets/fotoSO/' . $wishlist->shop->so->foto) }}" alt="Foto Produk">
                    </div>
                    <div class="wishlist-details col-8">
                        <h5>{{ $wishlist->shop->so->nama }} | {{ $wishlist->shop->so->kategori->name }}</h5>
                        <hr>
                        <p class="wishlist-price">
                            @if ($wishlist->shop->discount > 0)
                                <span style="text-decoration: line-through; font-size: 10px; color: red;">
                                    Rp
                                    {{ number_format($harga = ($wishlist->shop->so->hargamodal * $margins->margin) / 100 + $wishlist->shop->so->hargamodal) }}
                                </span>
                                <span>
                                    Rp
                                    {{ number_format($disharga = $harga - ($totaldiscount = ($harga * $wishlist->shop->discount) / 100)) }}
                                </span>
                            @else
                                Rp
                                {{ number_format(($wishlist->shop->so->hargamodal * $margins->margin) / 100 + $wishlist->shop->so->hargamodal) }}
                            @endif
                        </p>

                    </div>
                    <div class="wishlist-remove col-2">
                        <form action="{{ url('addwishlist/') }}" method="POST">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ Auth::check() ? Auth::user()->id : 0 }}">
                            <input type="hidden" name="shop_id" value="{{ $wishlist->shop->id }}">
                            <button class=" btn btn-default btn-lg btn-flat"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
