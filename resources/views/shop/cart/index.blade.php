@extends('karyawan.template.main')

@section('title', 'Cart')

@push('style')
    @include('karyawan.event.style')

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
    <div class="content">
        <div class="container py-3 mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Your Cart</h4>
                <!-- Select All -->
                <div>
                    <input type="checkbox" id="select-all" /> <label for="select-all">Select All</label>
                </div>
            </div>

            <form action="{{ url('checkout') }}" method="POST" id="cart-form">
                @csrf
                <!-- Iterate over cart items -->
                @foreach ($carts as $cart)
                    <div class="card mb-3">
                        <div class="d-flex align-items-center px-3 justify-content-between">
                            <div class="d-flex align-items-center">
                                <!-- Checkbox to select individual items -->
                                <input type="checkbox" name="selected_items[]" value="{{ $cart->id }}"
                                    class="select-item mr-3" />
                                <img src="{{ asset('assets') }}/fotoSO/{{ $cart->so->foto }}" class="p-1 rounded-circle"
                                    alt="" height="100" width="100" class="mr-3" />
                                <div class="card-body">
                                    <h6 class="card-title">{{ $cart->so->nama }}</h6>
                                    <p class="card-text">Price: Rp {{ number_format($cart->total) }} | discount :
                                        {{ number_format($cart->discount) }}</p>
                                    <p class="card-text">Qty : {{ $cart->qty }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </form>
        </div><!-- /.container-fluid -->

        <!-- Bottom Bar for Checkout -->
        <div class="fixed-bottom bg-light py-3 border-top">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Total Price -->
                    <h5>Total: Rp <span id="total-price">0</span></h5>
                    <!-- Checkout Button -->
                    <div class="">
                        <button type="button" id="delete-button" class=" btn btn-danger">Delete</button>
                        <button type="submit" id="checkout-button" form="cart-form" class="btn btn-primary">Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

    <script>
        document.getElementById('delete-button').addEventListener('click', function() {
            // Change the form method to DELETE
            var form = document.getElementById('cart-form');

            // Create a hidden input for the DELETE method
            var deleteInput = document.createElement('input');
            deleteInput.setAttribute('type', 'hidden');
            deleteInput.setAttribute('name', '_method');
            deleteInput.setAttribute('value', 'DELETE');

            form.appendChild(deleteInput);

            // Submit the form
            form.submit();
        });
    </script>
    <script>
        document.getElementById('checkout-button').addEventListener('click', function() {
            // Change the form method to DELETE
            var form = document.getElementById('cart-form');

            // Create a hidden input for the DELETE method
            var deleteInput = document.createElement('input');
            deleteInput.setAttribute('type', 'hidden');
            deleteInput.setAttribute('name', '_method');
            deleteInput.setAttribute('value', 'POST');

            form.appendChild(deleteInput);

            // Submit the form
            form.submit();
        });
    </script>


    @include('karyawan.event.script')

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


    <script>
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const itemCheckboxes = document.querySelectorAll('.select-item');
            const totalPriceEl = document.getElementById('total-price');

            let prices = @json($carts->pluck('total')); // Mengambil array harga dari Blade

            // Function to update total price
            function updateTotalPrice() {
                let total = 0;
                itemCheckboxes.forEach((checkbox, index) => {
                    if (checkbox.checked) {
                        total += prices[index];
                    }
                });
                totalPriceEl.innerText = total.toLocaleString(); // Format total harga
            }

            // Event listener for Select All checkbox
            selectAllCheckbox.addEventListener('change', function() {
                itemCheckboxes.forEach(checkbox => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
                updateTotalPrice();
            });

            // Event listener for individual item checkboxes
            itemCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', updateTotalPrice);
            });
        });
    </script>
@endpush
