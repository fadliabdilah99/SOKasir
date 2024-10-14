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
                        <h3>Tambahkan Produk Ke Event</h3>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Produk</th>
                                    <th>QTY</th>
                                    <th>Discount(%)</th>
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
                                        <td>{{ $barang->discount }}</td>
                                        <td class="d-flex justify-content-center align-items-center" style="gap: 10px">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addprod" onclick="onEdits(this, {{ $barang->id }})"><i
                                                    class="fas fa-plus"></i></button>
                                            <form action="{{ url("deleteProd/$barang->id") }}" method="post">
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

    @include('karyawan.event.modal')

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
            document.getElementById('soId').value = tds[0].textContent.trim();
            document.getElementById('barangeventId').value = {{ $eventId }};
            document.getElementById('jumlah').max = tds[6].textContent.trim();
            document.getElementById('jumlah').placeholder = "Jumlah tersedia " + tds[6].textContent.trim();
        }

        function onEdits(btn, historyId) {
            const tr = btn.closest('tr');
            const tds = tr.querySelectorAll('td');

            // Logging untuk debugging
            console.log("Editing ID:", historyId);
            tds.forEach((td, index) => {
                console.log(`td[${index}]:`, td.textContent.trim());
            });



            // Mengisi input field
            document.getElementById('barangeventId').value = tds[0].textContent.trim();
            document.getElementById('soId').value = tds[1].textContent.trim();
            document.getElementById('jumlah').value = tds[3].textContent.trim();
            document.getElementById('sese').value = tds[4].textContent.trim();

            // Set action URL untuk update
            document.getElementById('modalForm').action = `update/${historyId}`; // URL untuk mengupdate
            console.log("Form action set to:", document.getElementById('modalForm').action);

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
