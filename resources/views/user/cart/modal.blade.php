<div class="offcanvas offcanvas-bottom" tabindex="-1" id="offcanvasBottom" aria-labelledby="offcanvasBottomLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasBottomLabel">Checkout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body small">
        <form id="checkoutForm" action="{{ url('addcart') }}" method="POST">
            @csrf
            <input type="number" name="user_id" hidden value="{{ Auth::check() ? Auth::user()->id : 0 }}">
            <input type="number" name="so_id" hidden value="{{ $shop->so->id }}">
            <input type="text" name="margin" hidden value="{{ $margins->jenis }}">
            <input type="number" name="shopId" hidden value="{{ $shop->id }}">
            <input type="number" name="total" hidden value="{{ $shop->discount >= 0 ? $disharga : $harga }}">
            <div class="row">
                <!-- Product Image -->
                <div class="col-4">
                    <img src="{{ asset('assets/fotoSO/' . $shop->so->foto) }}" class="img-fluid" alt="Product Image"
                        id="productImage">
                </div>

                <div class="col-8">
                    <!-- Product Name -->
                    <div class="mb-3">
                        <label for="productName" class="form-label">Product Name</label>
                        <input type="text" class="form-control" id="productName" value="{{ $shop->so->nama }}"
                            readonly>
                    </div>

                    <!-- Size Selection -->
                    <div class="mb-3">
                        <label for="sizeSelect" class="form-label">Size</label>
                        <select class="form-select" id="sizeSelect" name="size">
                            @foreach ($shop->size as $select)
                                <option value="{{ $select->id }}">{{ $select->size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Quantity Input -->
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" class="form-control" id="quantity" value="1" min="1"
                            onchange="updateTotal()" name="qty">
                    </div>

                    <!-- Price Info -->
                    <div class="mb-3">
                        <label for="price" class="form-label">Price (per item)</label>
                        <input type="text" class="form-control"
                            value="{{ number_format($shop->discount >= 0 ? $disharga : $harga) }}" readonly>
                    </div>

                    <!-- Checkout Button -->
                    @if (Auth::check())
                        <button type="submit" class="btn btn-primary w-100">Add Cart</button>
                    @else
                        <button type="button" onclick="showAlertNoLogin()" class="btn btn-primary w-100">Add
                            Cart</button>
                    @endif
                </div>
            </div>
        </form>
    </div>
</div>
