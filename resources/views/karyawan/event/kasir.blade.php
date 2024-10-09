@extends('karyawan.template.main')

@section('title', 'Kasir')

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
                <a href="{{ url('event-karyawan') }}">event</a>
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
                        <form action="{{url('addPesanan')}}" method="POST">
                            @csrf
                            <input type="number" name="event_id" hidden value="{{ $eventId }}">
                            <button type="submit" class="btn btn-primary mb-2"><i class="fas fa-plus"></i></button>
                        </form>
                        <table id="example1" class="table table-bordered table-striped text-center">
                            <thead>
                                <tr>
                                    <th>Id Pesanan</th>
                                    <th>Total Barang</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pesanan as $pesanans)
                                    <tr>
                                        <td>{{ $pesanans->id }}</td>
                                        <td>{{ $pesanans->prosesco->count() }}</td>
                                        <td>
                                            <a href="{{ url('proses/' . $pesanans->id) }}" class="btn btn-primary">proses</a>
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

    {{-- @include('karyawan.event.kasirmodal') --}}

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
