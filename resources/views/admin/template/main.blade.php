<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    {{-- bootstrap icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    @stack('style')



</head>

<body class="hold-transition sidebar-mini ">
    <div class="wrapper">
        <!-- Navbar -->
        @include('admin.template.header')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper px-3">
            <!-- Content Header -->
            @yield('content')
            <!-- /.content -->
        </div>

        @include('admin.template.footer')

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/adminlte.min.js"></script>
        @stack('script')

        @if ($message = Session::get('success'))
            <script>
                Swal.fire({
                    title: "Berhasil!",
                    text: "{{ $message }}",
                    icon: "success"
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
