<!-- resources/views/shipping/index.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengecekan Ongkir</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Pengecekan Ongkir</h1>
    <form id="ongkirForm">
        @csrf
        <label for="origin">Kota Asal:</label>
        <input type="text" name="origin" id="origin" required>

        <label for="destination">Kota Tujuan:</label>
        <input type="text" name="destination" id="destination" required>

        <label for="weight">Berat (gram):</label>
        <input type="number" name="weight" id="weight" required>

        <label for="courier">Kurir:</label>
        <input type="text" name="courier" id="courier" required>

        <button type="submit">Cek Ongkir</button>
    </form>

    <div id="result"></div>

    <script>
        $('#ongkirForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '/check-ongkir',
                data: $(this).serialize(),
                success: function(response) {
                    $('#result').html(JSON.stringify(response));
                },
                error: function(xhr) {
                    $('#result').html(xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>