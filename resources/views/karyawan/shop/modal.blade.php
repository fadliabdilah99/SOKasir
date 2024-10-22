<div class="modal fade" id="addprod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Tambah Product ke Market</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <form action="{{ url('shop') }}" method="POST" id="modaledit" enctype="multipart/form-data">
                    @csrf
                    <input type="number" name="so_id" id="soId" hidden>
                    <input type="number" name="kategori_id" id="kategori_id" hidden>
                    <input type="text" name="kode" id="kode" hidden>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">QTY</label>
                            <div class="col-sm-10">
                                <input type="number" id="qty" class="form-control" name="qty"
                                    placeholder="Kategori name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">disc(opsional)</label>
                            <div class="col-sm-10">
                                <input type="number" maxlength="2" name="discount" id="discount" class="form-control"
                                    placeholder="presentase discount">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Detail Produk</label>
                            <div class="col-sm-10">
                                <textarea type="text" name="detail" id="detail" class="form-control"
                                    placeholder="deskripsi lengkap, ketentuan, dan detail lainnya"></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Deskripsi</label>
                            <div class="col-sm-10">
                                <input type="text" name="deskripsi" id="deskripsi" class="form-control"
                                    placeholder="Deskripsi singkat">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">Foto Produk</label>
                            <div class="col-sm-10">
                                <input type="file" name="foto[]" class="form-control" multiple>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="size" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">cart</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <form id="sizeform" class="form-horizontal" action="addsize" method="POST">
                    @csrf
                    <input type="text" name="shop_id" id="sosizeId" hidden>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">jenis</label>
                            <div class="col-sm-10">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;"
                                    data-select2-id="1" tabindex="-1" aria-hidden="true" name="size">
                                    <option value="S">S</option>
                                    <option value="M">M</option>
                                    <option value="L">L</option>
                                    <option value="XL">XL</option>
                                    <option value="XXL">XXL</option>
                                    <option value="allsize">all size</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">QTY</label>
                            <div class="col-sm-10">
                                <input type="number" min="1" id="qtysize" class="form-control" name="qty">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Tambahkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
