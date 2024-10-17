@extends('admin.template.main')

@push('style')
    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
@endpush

@push('bodystyle')
@endpush

@section('content')
    <div class="row pt-3">
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalprod }}</h3>
                    <p>total produk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-bag"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3><sup style="font-size: 20px">Rp </sup>{{ Number_format($valuasi, 0, ',', '.') }}</h3>
                    <p>Valuasi nilai modal produk</p>
                </div>
                <div class="icon">
                    <i class="ion ion-stats-bars"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ 'Rp ' . Number_format($pemasukanonline, 0, ',', '.') }}</h3>

                    <p>Penjualan online</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ 'Rp ' . Number_format($pemasukanoffline, 0, ',', '.') }}</h3>

                    <p>Penjualan offline</p>
                </div>
                <div class="icon">
                    <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- AREA CHART -->
    <div class="card card-dark">
        <div class="card-header">
            <h3 class="card-title">Area Chart</h3> <br>
            <button class="btn btn-primary" type="button"></button> penjualan Offline <br>
            <button class="btn btn-secondary" type="button"></button> penjualan Online

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="chart">
                <canvas id="areaChart"
                    style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
            </div>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="row">
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header border-transparent">
                    <h3 class="card-title">Order</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table m-0 text-center">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>qty</th>
                                    <th>pemasukan bersih</th>
                                    <th>jenis transaksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesanan as $pendapatans)
                                    <tr>

                                        <td>
                                            @if (isset($pendapatans->so) && isset(json_decode($pendapatans->so)->nama))
                                                {{ json_decode($pendapatans->so)->nama }}
                                            @else
                                                barang ter hapus
                                            @endif
                                        </td>
                                        <td>
                                            {{ $pendapatans->qty }}
                                        </td>
                                        <td>
                                            {{ Number_format($pendapatans->total) }}
                                        </td>
                                        <td>
                                            {{ $pendapatans->jenis }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Atur Margin</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="products-list product-list-in-card pl-2 pr-2">
                        @foreach ($margin as $margins)
                            <li class="item">
                                <div class="product-img">
                                    <button type="button" class="btn btn-default" data-toggle="modal"
                                        data-target="#modal-default{{ $margins->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                                <div class="product-info">
                                    <a href="javascript:void(0)" class="text-dark product-title">{{ $margins->jenis }}
                                        <span class=" btn btn-success float-right">{{ $margins->margin }}%</span></a>

                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
                <!-- /.card-footer -->
            </div>
        </div>
    </div>
    @include('admin.home.modal')
@endsection

@push('script')





    {{-- sweetalert2 --}}
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="plugins/jszip/jszip.min.js"></script>
    <script src="plugins/pdfmake/pdfmake.min.js"></script>
    <script src="plugins/pdfmake/vfs_fonts.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

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






    <script src="{{ asset('plugins') }}/chart.js/Chart.min.js"></script>


    <script>
        var areaChartCanvas = $('#areaChart').get(0).getContext('2d')

        var areaChartData = {
            labels: @json($bulan), // Labels dinamis sesuai 6 bulan terakhir
            datasets: [{
                    label: 'offline',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: @json($offline) // Data penjualan sesuai dengan bulan
                },
                {
                    label: 'Online',
                    backgroundColor: 'rgba(210, 214, 222, 1)',
                    borderColor: 'rgba(210, 214, 222, 1)',
                    pointRadius: false,
                    pointColor: 'rgba(210, 214, 222, 1)',
                    pointStrokeColor: '#c1c7d1',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(220,220,220,1)',
                    data: @json($online) // Data penjualan sesuai dengan bulan
                },
            ]
        }

        var areaChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
                display: false
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                    }
                }],
                yAxes: [{
                    gridLines: {
                        display: false,
                    }
                }]
            }
        }

        new Chart(areaChartCanvas, {
            type: 'line',
            data: areaChartData,
            options: areaChartOptions
        })
    </script>
@endpush
