@extends('karyawan.template.main')

@section('title', 'proses')

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
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            <div class="container">
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
                        <h3>Tambahkan Pesanan</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Id Pesanan</th>
                                    <th>kode barang</th>
                                    <th>foto</th>
                                    <th>qty</th>
                                    <th>total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $total = 0;
                                @endphp
                                @foreach ($cart as $cart)
                                @php
                                    $total += $cart->barangeven->so->hargamodal * 0.45 + $cart->barangeven->so->hargamodal * $cart->qty;
                                @endphp
                                    <tr>
                                        <td>{{ $cart->id }}</td>
                                        <td>
                                            {{ $cart->barangeven->so->kode }}
                                        </td>
                                        <td>
                                            <img src="{{ asset('assets') }}/fotoSO/{{ $cart->barangeven->so->foto }}"
                                                width="100px" alt="">
                                        </td>
                                        <td>{{ $cart->qty }}</td>
                                        <td>Rp {{ Number_format($cart->barangeven->so->hargamodal * 0.45 + $cart->barangeven->so->hargamodal * $cart->qty) }}</td>

                                        <td>
                                            <form action="{{ url("addprod/$cart->id") }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="number" name="qty" hidden value="{{ $cart->qty }}">
                                                <input type="number" name="barangeven_id" hidden value="{{ $cart->barangeven_id }}">
                                                <button class="btn bg-danger delete-data" type="submit">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                        <div class="d-flex p-2 justify-content-between" style="gap: 10px">
                            <div class="">
                                <h5>Total: Rp {{ Number_format($total)}}</h5>
                            </div>
                            <div class="">
                                <button type="button" class="btn btn-danger">Batalkan</button>
                                <button type="button" class="btn btn-success">Selesai</button>
                            </div>
                        </div>
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
                        <h2>pilih barang</h2>
                    </div>
                    <div class="card-body">
                        <table id="rex1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>id event</th>
                                    <th>Kode</th>
                                    <th>Kategori</th>
                                    <th>foto</th>
                                    <th>Nama</th>
                                    <th>Harga modal + 45%</th>
                                    <th>qty</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barangs as $sos)
                                    <tr>
                                        <td>{{ $sos->id }}</td>
                                        <td>{{ $sos->so->kode }}</td>
                                        <td>{{ $sos->so->kategori->name }}</td>
                                        <td><img src="{{ asset('assets') }}/fotoSO/{{ $sos->so->foto }}" width="100px"
                                                alt=""></td>
                                        <td>{{ $sos->so->nama }}</td>
                                        <td>{{ $sos->so->hargamodal * 0.45 + $sos->so->hargamodal }}</td>
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

    @include('karyawan.event.kasirmodal')

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

            $jumlah = tds[6].textContent.trim();

            // Mengisi input field
            document.getElementById('berangevent').value = tds[0].textContent.trim();
            document.getElementById('jumlah').max = tds[6].textContent.trim();
            document.getElementById('jumlah').placeholder = "Jumlah tersedia " + tds[6].textContent.trim();

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
                    text: `Apakah penghapusan data ${data} akan dilanjutkan?`,
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
