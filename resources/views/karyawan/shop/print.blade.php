<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Label Pengiriman Paket JNE</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styling khusus untuk cetak */
        @media print {
            .container {
                width: 100%;
                margin: 0;
            }
        }

        .label-section {
            border: 1px solid #333;
            padding: 20px;
            margin-bottom: 20px;
        }

        .label-header {
            font-size: 24px;
            font-weight: bold;
            color: #d9534f;
        }

        .info-section {
            font-size: 14px;
        }
    </style>
</head>

<body onload="window.print()">

    <div class="container my-4">
        <!-- Bagian Label Pengiriman -->
        <div class="label-section">
            <div class="text-center label-header">JNE Express</div>
            <hr>

            <!-- Informasi Pengirim -->
            <div class="info-section mb-3">
                <h5 class="font-weight-bold">Pengirim</h5>
                <p>
                    Nama: Flora Vania Indonesia<br>
                    Alamat: City square, Kalideres, Kalideres, Jakarta Barat<br>
                    Telepon: 081319412433
                </p>
            </div>

            <!-- Informasi Penerima -->
            <div class="info-section mb-3 d-flex justify-content-end">
                <div class="">
                    <h5 class="font-weight-bold">Penerima</h5>
                    <p>
                        Nama: {{$user->name}}<br>
                        Alamat: {{$alamat->province->title}}, {{$alamat->city->title}}, {{$alamat->alamatlengkap}}, {{$alamat->patokan}} {{$alamat->kodePos}}<br>
                        Telepon: 0{{$alamat->notlpn}}
                    </p>
                </div>
            </div>

            <!-- Informasi Paket -->
            <div class="info-section">
                <h5 class="font-weight-bold">Informasi Paket</h5>
                <p>
                    No. Resi: <br>
                    Berat: {{$berat}} gram<br>
                    Jenis Layanan: Reguler<br>
                    Tanggal Pengiriman: {{ date('d-m-Y', strtotime(now())) }}
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS, Popper.js, and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
