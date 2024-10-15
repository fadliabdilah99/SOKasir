@extends('karyawan.template.main')

@section('title', 'karyawan')

@push('style')
    {{-- SweetAlert2 --}}
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
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
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Halaman karyawan</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Layout</a></li>
                            <li class="breadcrumb-item active">Top Navigation</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
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
                        <h2>SO Barang</h2>
                        <button class="btn btn-success mb-2" type="button" data-toggle="modal" data-target="#addso">Tambah
                            SO</button>
                    </div>
                    <div class="card-body">
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Kode</th>
                                    <th>Kategori</th>
                                    <th>foto</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th>H Modal</th>
                                    <th>qty</th>
                                    <th>aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($so as $sos)
                                    <tr>
                                        <td>{{ $sos->id }}</td>
                                        <td>{{ $sos->kode }}</td>
                                        <td>{{ $sos->kategori->name }}</td>
                                        <td><img src="assets/fotoSO/{{ $sos->foto }}" width="100px" alt=""></td>
                                        <td>{{ $sos->nama }}</td>
                                        <td>{{ $sos->deskripsi }}</td>
                                        <td>{{ $sos->hargamodal }}</td>
                                        <td>{{ $sos->qty }}</td>

                                        <td>
                                            <button type="button" class="btn btn-info" data-bs-toggle="modal"
                                                data-bs-target="#checkout" onclick="checkouts(this, {{ $sos->id }})">
                                                <i class="fas fa-shopping-cart"></i>
                                            </button>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addso" onclick="onEdits(this, {{ $sos->id }})">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ url("so/$sos->id") }}" method="POST" style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn bg-danger delete-data" type="button">
                                                    <i class="fas fa-trash"></i>
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
                        <h2>Kategori</h2>
                        <button class="btn btn-success mb-2" type="button" data-toggle="modal"
                            data-target="#addkategori">Tambah Kategori</button>
                    </div>
                    <div class="card-body">
                        <table id="rex1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Kode</th>
                                    <th>Produk Terkait</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategori as $kat)
                                    <tr>
                                        <td>{{ $kat->name }}</td>
                                        <td>{{ $kat->kode }}</td>
                                        <td>{{ $kat->so->count() }}</td>
                                        <td>
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#addkategori" onclick="onEdit(this, {{ $kat->id }})">
                                                Edit
                                            </button>
                                            <form action="{{ url("kategori/$kat->id") }}" method="POST"
                                                style="display: inline">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn bg-danger delete-data" type="button">
                                                    <i class="fas fa-trash-alt"></i> Delete
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
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    </div>

    <div style="position: fixed; right: 20px; bottom: 60px;">
        <a href="{{ url('cart') }}" class="btn-floating btn-large bg-success p-3 rounded-circle m-5 red">
            <i class="fas fa-cart-plus"></i>
        </a>
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

    @include('karyawan.page.modal')

@endSection

@push('script')



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
            document.getElementById('fade').value = tds[0].textContent.trim(); // name
            document.getElementById('sese').value = tds[1].textContent.trim(); // kode

            // Set action URL untuk update
            document.getElementById('modalForm').action = `updatekat/${historyId}`; // URL untuk mengupdate
            console.log("Form action set to:", document.getElementById('modalForm').action);
        }
    </script>

    {{-- edit SO --}}
    <script>
        function onEdits(btn, historyId) {
            const tr = btn.closest('tr');
            const tds = tr.querySelectorAll('td');

            

            // Mengisi input field
            document.getElementById('namas').value = tds[2].textContent.trim(); // nama
            document.getElementById('deskripsis').value = tds[5].textContent.trim(); // deskripsi
            document.getElementById('hargamodals').value = tds[6].textContent.trim(); // harga modal
            document.getElementById('qtys').value = tds[7].textContent.trim(); // qty
            document.getElementById('keterangans').placeholder = "Kosongkan jika tidak di ubah";
            document.getElementById('kodese').placeholder = "kosongkan jika tidak di ubah";

            // Set action URL untuk update
            document.getElementById('modalFormSO').action = `updateSO/${historyId}`; // URL untuk mengupdate
            console.log("Form action set to:", document.getElementById('modalFormSO').action);
        }
    </script>

    <script>
        function checkouts(btn, soId) {
            console.log('hello');
            const tr = btn.closest('tr');
            const tds = tr.querySelectorAll('td');

            // Logging untuk debugging
            console.log("Editing ID:", soId);
            tds.forEach((td, index) => {
                console.log(`td[${index}]:`, td.textContent.trim());
            });

            // Mengisi input field
            document.getElementById('SoId').value = tds[0].textContent.trim(); 
            document.getElementById('SOmodal').value = tds[6].textContent.trim(); 
            document.getElementById('SOmodals').value = tds[6].textContent.trim(); 
            document.getElementById('SoQTY').placeholder = "Maximal " + tds[7].textContent.trim();
            document.getElementById('SoQTY').max = tds[7].textContent.trim();


            // Set action URL untuk update
            document.getElementById('checkoutform').action = `kasir2/${soId}`; // URL untuk mengupdate
            console.log("Form action set to:", document.getElementById('modalFormSO').action);
        }
    </script>



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

    @if ($message = Session::get($errors->any()))
        <script>
            Swal.fire({
                title: "Errors!",
                text: "{{ $message }}",
                icon: "error"
            });
        </script>
    @endif

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
            const data = $(this).closest('tr').find('td:eq(0)').text()
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
