@extends('user.template.main')

@section('title', 'Profile')

@push('style')
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
@endpush

@push('bodystyle')
    class="hold-transition layout-top-nav"
@endpush

@section('content')
    <section class="content container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="../../dist/img/user4-128x128.jpg"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>

                            {{-- <p class="text-muted text-center">Software Engineer</p> --}}

                            <ul class="list-group list-group-unbordered mb-3">
                                 <li class="list-group-item">
                                    <b>Pembelian</b> <a class="float-right">{{$pembelian}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{ Auth::user()->email }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>No</b> <a class="float-right">0{{$alamat->notlpn}}</a>
                                </li>
                            </ul>

                            <a href="{{ url('profile') }}" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Lainnya</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-map-marker-alt mr-1"></i> Alamat</strong>

                            <p class="text-muted">
                                {{$alamat->province->title}}, {{$alamat->city->title}}, {{$alamat->kodePos}} <br>
                                {{$alamat->alamatlengkap}}, {{$alamat->patokan}}
                            </p>

                            <hr>

                            <strong><i class="fas fa-comments mr-1"></i>Chat dengan Admin</strong>


                            <hr>

                            <strong><i class="fas fa-ticket-alt"></i> Vocher</strong>

                            <p class="text-muted">
                                50+
                            </p>

                            <hr>

                            <form action="{{ url('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block"><b>Logout</b></button>
                            </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Di
                                        Kemas</a></li>
                                <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Di Kirim</a>
                                </li>
                                <li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Selesai</a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="activity">
                                    @if ($dikemast->isEmpty())
                                        <p>Belum ada barang</p>
                                    @else
                                        @foreach ($dikemast as $order)
                                            <div class="border p-2 rounded-3 my-1">

                                                <h5>Kode Invoice: #{{ $order['kodeInvoice'] }}</h5>
                                                <div class="container">
                                                    @foreach ($order['items'] as $dikemas)
                                                        <div class="cart-item d-flex align-items-center">
                                                            <!-- Product Image -->
                                                            <img src="{{ asset('assets/fotoSO/' . $dikemas->so->foto) }}"
                                                                alt="Product Image">

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
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="timeline">
                                    @if ($sendings->isEmpty())
                                        <p>Belum ada barang</p>
                                    @else
                                        <p class="fw-bold">cek resi <a href="https://jne.co.id/tracking-package">disini</a>
                                        </p>
                                        @foreach ($sendings as $sending)
                                            <div class="border p-2 rounded-3 my-1">
                                                <h5>Kode Invoice: #{{ $sending['kodeInvoice'] }}</h5>
                                                <div class="container">
                                                    @foreach ($sending['items'] as $dikirim)
                                                        <div class="cart-item d-flex align-items-center">
                                                            <!-- Product Image -->
                                                            <img src="{{ asset('assets/fotoSO/' . $dikirim->so->foto) }}"
                                                                alt="Product Image">

                                                            <!-- Product Details -->
                                                            <div class="cart-item-details">
                                                                <div class="cart-item-title">{{ $dikirim->so->nama }}</div>
                                                                <div class="cart-item-subtitle">
                                                                    Size : {{ $dikirim->size }}
                                                                </div>
                                                            </div>

                                                            <!-- Product Quantity -->
                                                            <div class="quantity-selector mr-3">
                                                                <span class="cart-item-quantity mx-2">QTY
                                                                    {{ $dikirim->qty }}</span>
                                                            </div>

                                                            <!-- Product Price -->
                                                            <div class="cart-item-price">Rp.
                                                                {{ number_format($dikirim->total) }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <p><i class="bi bi-copy btn"
                                                        onclick="copyToClipboard('{{ $sending['items']->first()->resi }}')"></i>
                                                    {{ $sending['items']->first()->resi }}</p>
                                            </div>
                                        @endforeach

                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="settings">
                                    @if ($successt->isEmpty())
                                        <p>Belum ada barang</p>
                                    @else
                                        <p class="fw-bold">cek resi <a href="https://jne.co.id/tracking-package">disini</a>
                                        </p>
                                        @foreach ($successt as $success)
                                            <div class="border p-2 rounded-3 my-1">
                                                <h5>Kode Invoice: #{{ $success['kodeInvoice'] }}</h5>
                                                <div class="container">
                                                    @foreach ($success['items'] as $selesai)
                                                        <div class="cart-item d-flex align-items-center">
                                                            <!-- Product Image -->
                                                            <img src="{{ asset('assets/fotoSO/' . $selesai->so->foto) }}"
                                                                alt="Product Image">

                                                            <!-- Product Details -->
                                                            <div class="cart-item-details">
                                                                <div class="cart-item-title">{{ $selesai->so->nama }}</div>
                                                                <div class="cart-item-subtitle">
                                                                    Size : {{ $selesai->size }}
                                                                </div>
                                                            </div>

                                                            <!-- Product Quantity -->
                                                            <div class="quantity-selector mr-3">
                                                                <span class="cart-item-quantity mx-2">QTY
                                                                    {{ $selesai->qty }}</span>
                                                            </div>

                                                            <!-- Product Price -->
                                                            <div class="cart-item-price">Rp.
                                                                {{ number_format($selesai->total) }}</div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <p><i class="bi bi-copy btn"
                                                            onclick="copyToClipboard('{{ $success['items']->first()->resi }}')"></i>
                                                        {{ $success['items']->first()->resi }}</p>
                                                    <div class="">
                                                        <a href="{{ url('invoice/' . $success['kodeInvoice']) }}"
                                                            class="btn btn-primary">Invoice</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('script')
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>


    <script>
        function copyToClipboard(text) {
            var textArea = document.createElement("textarea");

            textArea.value = text;

            document.body.appendChild(textArea);

            textArea.select();
            textArea.setSelectionRange(0, 9999);

            document.execCommand("copy");

            document.body.removeChild(textArea);
        }
    </script>
@endpush
