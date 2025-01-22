@extends('karyawan.template.main')

@section('title', 'product')

@push('style')
    @include('karyawan.event.style')
@endpush

@push('bodystyle')
    class="hold-transition layout-top-nav"
@endpush

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <a href="{{ url('karyawan') }}">home</a>
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $payment }}</h3>
                                <p>Perlu Dikirim</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="{{ 'dikemas' }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-4 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $sending }}</h3>

                                <p>Dalam Pengiriman</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="{{ url('dikirim') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-4 col-12">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $selesai }}</h3>

                                <p>Selesai</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="{{ url('selesai') }}" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->

                    <!-- ./col -->
                </div>

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <h3>Tambahkan Produk Ke Market</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Kode Barang</th>
                                    <th>Nama</th>
                                    <th>QTY</th>
                                    <th>size</th>
                                    <th>Discount(%)</th>
                                    <th>Foto</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $barang)
                                    <tr>
                                        <td>{{ $barang->id }}</td>
                                        <td>{{ $barang->so->kode }}</td>
                                        <td>{{ $barang->so->nama }}</td>
                                        <td>{{ $barang->qty }}</td>
                                        <td>
                                            @foreach ($barang->size as $sizes)
                                                <form action="{{ url('deletesize/' . $sizes->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn delete-data btn-primary mb-1">
                                                        {{ $sizes->size }} : {{ $sizes->qty }}
                                                    </button><br>
                                                </form>
                                            @endforeach
                                        </td>
                                        <td>{{ $barang->discount }}</td>
                                        <td class="bg-dark">
                                            <div id="carouselExample{{ $loop->index }}" class="carousel"
                                                data-bs-ride="carousel">
                                                <div class="carousel-inner">
                                                    @foreach ($barang->foto as $index => $foto)
                                                        <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                                            <img src="assets/asset/{{ $foto->fotos }}" width="100px"
                                                                alt="">
                                                        </div>
                                                    @endforeach
                                                </div>
                                                <button class="carousel-control-prev" type="button"
                                                    data-bs-target="#carouselExample{{ $loop->index }}"
                                                    data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button"
                                                    data-bs-target="#carouselExample{{ $loop->index }}"
                                                    data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="d-flex justify-content-center align-items-center" style="gap: 10px">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addprod" onclick="onEdits(this, {{ $barang->id }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#size"
                                                onclick="sizeform(this, {{ $barang->size->sum('qty') }})">
                                                <i class="bi bi-rulers"></i>
                                            </button>
                                            <form action="{{ url("deleteShop/$barang->id") }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn bg-danger delete-data" type="submit">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

                <div class="card">
                    <div class="card-header">
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <h2>Tambah Barang</h2>
                    </div>
                    <div class="card-body">
                        <table id="rex1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>katId</th>
                                    <th>Kode</th>
                                    <th>Kategori</th>
                                    <th>foto</th>
                                    <th>Nama</th>
                                    <th>H Modal</th>
                                    <th>qty</th>
                                    <th>Tambahkan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($so as $sos)
                                    <tr>
                                        <td>{{ $sos->id }}</td>
                                        <td>{{ $sos->kategori->id }}</td>
                                        <td>{{ $sos->kode }}</td>
                                        <td>{{ $sos->kategori->name }}</td>
                                        <td><img src="{{ asset('assets') }}/fotoSO/{{ $sos->foto }}" width="100px"
                                                alt=""></td>
                                        <td>{{ $sos->nama }}</td>
                                        <td>{{ $sos->hargamodal }}</td>
                                        <td>{{ $sos->qty }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addprod" onclick="onEdit(this, {{ $sos->id }})"><i
                                                    class="fas fa-plus"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
    </footer>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    @include('karyawan.shop.modal')

@endSection

@push('script')
    @include('karyawan.event.script')

    <script>
        function onEdit(btn, historyId) {
            const tr = btn.closest('tr');
            const tds = tr.querySelectorAll('td');

            // Logging untuk debugging
            console.log("Editing ID:", historyId);
            tds.forEach((td, index) => {
                console.log(`td[${index}]:`, td.textContent.trim());
            });

            // Mengisi input field
            document.getElementById('soId').value = tds[0].textContent.trim(); // name
            document.getElementById('kategori_id').value = tds[1].textContent.trim(); // name
            document.getElementById('qty').max = tds[7].textContent.trim(); // kode
            document.getElementById('qty').placeholder = "Jumlah tersedia " + tds[7].textContent.trim();
        }
    </script>
    <script>
        function onEdits(btn, historyId) {
            const tr = btn.closest('tr');
            const tds = tr.querySelectorAll('td');

            // Logging untuk debugging
            console.log("Editing ID:", historyId);
            tds.forEach((td, index) => {
                console.log(`td[${index}]:`, td.textContent.trim());
            });

            // Mengisi input field
            document.getElementById('soId').value = tds[0].textContent.trim();
            document.getElementById('kode').value = tds[1].textContent.trim();
            document.getElementById('qty').value = tds[3].textContent.trim();
            document.getElementById('discount').value = tds[5].textContent.trim();

            // Set action URL untuk update
            document.getElementById('modaledit').action = `updateshop/${historyId}`; // URL untuk mengupdate
            console.log("Form action set to:", document.getElementById('modaledit').action);
        }
    </script>

    <script>
        function sizeform(btn, qty) {
            const tr = btn.closest('tr');
            const tds = tr.querySelectorAll('td');

            // Mengisi input field
            let max = (parseInt(tds[3].textContent.trim(), 10) - qty);
            document.getElementById('sosizeId').value = tds[0].textContent.trim();
            document.getElementById('qtysize').max = max;
            document.getElementById('qtysize').placeholder = "Jumlah tersedia " + max;

        }
    </script>

    <!-- Page specific script -->
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
        $(function() {
            $("#rex1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#rex1_wrapper .col-md-6:eq(0)');
            $('#rex2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        // script delete start
        $('.delete-data').click(function(e) {
            e.preventDefault()
            const data = $(this).closest('tr').find('td:eq(1)').text()
            Swal.fire({
                    title: 'Semua Data Terkait Akan Hilang',
                    text: `Apakah penghapusan data akan dilanjutkan?`,
                    icon: 'warning',
                    showDenyButton: true,
                    confirmButtonText: 'Ya',
                    denyButtonText: 'Tidak',
                    focusConfirm: false
                })
                .then((result) => {
                    if (result.isConfirmed) $(e.target).closest('form').submit()
                    else swal.close()
                })
        });
    </script>
@endpush
