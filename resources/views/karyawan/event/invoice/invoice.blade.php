<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>V&P by Florina invoice</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins') }}/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist') }}/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->

        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="p-5">
            <a href="javascript:window.history.back()" class="btn btn-primary mb-3">Kembali</a>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Main content -->
                        <div class="invoice p-3 mb-3">
                            <!-- title row -->
                            <div class="row">
                                <div class="col-12">
                                    <h4>
                                        <img src="{{ asset('assets') }}/asset/logo.png" width="50" alt="">
                                        V&P invoice
                                        <small class="float-right">Date: {{ $penjualan->created_at }}</small>
                                    </h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- info row -->
                            <div class="row invoice-info">
                                <div class="col-sm-4 invoice-col">
                                    From
                                    <address>
                                        <strong>{{ $user->role }}|{{ $user->name }}.</strong><br>
                                        {{ $user->email }}<br>
                                        Id user = {{ $user->id }}<br>
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    To
                                    <address>
                                        <strong>Pembeli</strong><br>
                                        {{ $penjualan->jenis }}
                                    </address>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-4 invoice-col">
                                    <b>Invoice #{{ $id }}</b><br>
                                    <br>
                                    <b>Order ID:</b> {{ $penjualan->id }}<br>
                                    <b>Tanggal Transaksi: {{ $penjualan->created_at }}</b> <br>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- Table row -->
                            <div class="row">
                                <div class="col-12 table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Qty</th>
                                                <th>Product</th>
                                                <th>Serial #</th>
                                                <th>Description</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        @php
                                            $total = 0;
                                            $dis = 0;
                                        @endphp
                                        <tbody>
                                            @foreach ($invoice as $item)
                                                @php
                                                    $dis += $item->discount;
                                                    $total += $item->total;
                                                @endphp
                                                <tr>
                                                    <td>{{ $item->qty }}</td>
                                                    <td>{{ $item->so->nama }}</td>
                                                    <td>{{ $item->so->kategori->name }}</td>
                                                    <td>{{ $item->so->deskripsi }}</td>
                                                    <td>Rp {{ number_format($item->total + $item->discount) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <div class="row">
                                <!-- accepted payments column -->
                                <div class="col-6">
                                    <p class="lead">Payment Methods:</p>

                                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning
                                        heekya handango imeem
                                        plugg
                                        dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                                    </p>
                                    <h1 class="text-success well well-sm text-center shadow-none"
                                        style="margin-top: 10px; border: 1px solid #4cae4c;">
                                        <strong>LUNAS</strong>
                                    </h1>
                                    @if ($user->role != 'user')
                                        <p>penanggung jawab : {{ $user->name }}</p>
                                    @endif

                                </div>
                                <!-- /.col -->
                                <div class="col-6">
                                    <p class="lead">Amount Due 2/22/2014</p>

                                    <div class="table-responsive">
                                        <table class="table">
                                            <tr>
                                                <th>Total:</th>
                                                <td>Rp {{ number_format($total + $dis) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount:</th>
                                                <td>Rp - {{ number_format($dis) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Total:</th>
                                                <td>Rp {{ number_format($total) }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->

                            <!-- this row will not appear when printing -->
                            <div class="row no-print">
                                <div class="col-12">
                                    <a href="{{ url('print/' . $id) }}" rel="noopener" target="_blank"
                                        class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                                </div>
                            </div>
                        </div>
                        <!-- /.invoice -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section>
        </div><!-- /.container-fluid -->
        <!-- /.content -->
    </div>


    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins') }}/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins') }}/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist') }}/js/adminlte.min.js"></script>

</body>

</html>
