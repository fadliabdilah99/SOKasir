<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alamat Saya</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        }

        .add-address-btn:hover {
            background-color: #000000;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container mt-5">
        <div class="d-flex justify-content-between">
            <h4>Alamat Saya</h4>
        </div>
        <div class="address-card">
            <div class="row">
                <div class="col-md-8">
                    <div class="name">Reach Store Indonesia</div>
                    <div class="phone">(+62) 896 1271 9698</div>
                    <div class="address">
                        Komplek Puri Kartika RW.008 RT.001, Blok A1/20, Kelurahan Tajur,<br>
                        Kecamatan Ciledug (Pinggir Kali, ada mobil jeep rongsok)<br>
                        CILEDUG, KOTA TANGERANG, BANTEN, ID, 15151
                    </div>
                    <span class="address-tag">Alamat Toko</span>
                </div>
                <div class="col-md-4 address-actions">
                    <a href="#">Ubah</a>
                    <a href="#" class="text-danger">Hapus</a>
                </div>
            </div>
        </div>
        <a href="#" class="add-address-btn">+ Tambah Alamat Baru</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
