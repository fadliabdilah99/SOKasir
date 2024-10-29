<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Saya</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    @include('karyawan.event.style')

    <style>
        .address-card {
            border: 1px solid #e0e0e0;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .address-card .name {
            font-weight: bold;
            font-size: 18px;
        }

        .address-card .phone {
            color: #6c757d;
        }

        .address-tag {
            border: 1px solid #ff5722;
            padding: 3px 7px;
            color: #ff5722;
            border-radius: 3px;
            font-size: 12px;
            margin-top: 5px;
            display: inline-block;
        }

        .btn-main-address {
            background-color: #ff5722;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
        }

        .btn-main-address:hover {
            background-color: #e64a19;
        }

        .address-actions {
            text-align: right;
        }

        .address-actions a {
            margin-right: 10px;
            color: #007bff;
        }

        .add-address-btn {
            background-color: #ff5722;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            float: right;
            text-decoration: none;
            border: none;
        }

        .add-address-btn:hover {
            background-color: #b9b2b2;
            color: white;
            border: none;
        }

        .form-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }

        .form-container .btn-group-toggle {
            margin-bottom: 15px;
        }

        .btn-group-toggle .btn {
            margin-right: 10px;
        }

        .btn-orange {
            background-color: #ff5722;
            border-color: #ff5722;
            color: #fff;
        }

        .btn-orange:hover {
            background-color: #e64a19;
            border-color: #e64a19;
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
                        <li class="breadcrumb-item"><a href="{{url('carts')}}">cart</a></li>
                        <li class="breadcrumb-item"><a href="{{url('payment')}}">checkout</a></li>
                        <li class="breadcrumb-item active">alamat</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Alamat Saya</h4>
        </div>
        @foreach ($alamats as $alamat)
            <div class="address-card @if ($alamat->status == 'primary') border-primary @endif">
                <div class="row">
                    <div class="col-md-8">
                        <div class="name">{{ $alamat->nama }}</div>
                        <div class="phone">{{ $alamat->notlpn }}</div>
                        <div class="address">
                            {{ $alamat->alamatlengkap }}<br>
                            {{ $alamat->patokan }}<br>
                            {{ $alamat->province->title }}, {{ $alamat->city->title }}, {{ $alamat->kodePos }}
                        </div>
                        <span class="address-tag">{{ $alamat->jenis }}</span>
                    </div>
                    <div class="col-md-4 address-actions">
                        <a href="#">Ubah</a>
                        <a href="#" class="text-danger">Hapus</a>
                        @if ($alamat->status != 'primary')
                            <a href="alamatUtama/{{ $alamat->id }}" class="text-success">Pilih</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
        <button class="add-address-btn" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">+ Tambah
            Alamat Baru</button>
    </div>

    @include('user.alamat.modal')

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    @include('karyawan.event.script')



    <script type="text/javascript">
        $(document).ready(function() {
            $('#province').change(function() {
                var provinceCode = $(this).val();
                if (provinceCode) {
                    $.ajax({
                        url: '/alamat/cities',
                        type: 'GET',
                        data: {
                            province_code: provinceCode
                        },
                        dataType: 'json',
                        success: function(data) {
                            $('#city').empty();
                            $('#city').append(
                                '<option selected disabled>kota/kabupaten</option>');
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id +
                                    '">' + value.title + '</option>');
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(
                                error); // Tambahkan ini untuk melihat error di console
                        }
                    });
                } else {
                    $('#city').empty();
                    $('#city').append('<option selected disabled>kota/kabupaten</option>');
                }
            });
        });
    </script>



</body>

</html>
