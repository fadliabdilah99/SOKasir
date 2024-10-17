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
                            <label for="name" class="col-sm-2 col-form-label">Foto Produk</label>
                            <div class="col-sm-10">
                                <input type="file" name="foto[]" class="form-control"
                                   multiple>
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
