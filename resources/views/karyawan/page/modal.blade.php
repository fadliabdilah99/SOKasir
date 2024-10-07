<div class="modal fade" id="addso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Tambahkan SO</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <!-- form start -->
                <form class="form-horizontal">

                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="kode" class="col-sm-2 col-form-label">kode</label>
                            <div class="col-sm-10">
                                <input type="kode" class="form-control" id="kode" placeholder="kode">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <select class="form-control select2bs4 select2-hidden-accessible" name="role"
                                    id="">
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->kode }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Foto Produk</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile">
                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="nama" class="col-sm-2 col-form-label">nama</label>
                            <div class="col-sm-10">
                                <input type="nama" class="form-control" id="nama" placeholder="nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deskripsi" class="col-sm-2 col-form-label">deskripsi</label>
                            <div class="col-sm-10">
                                <input type="deskripsi" class="form-control" id="deskripsi" placeholder="deskripsi">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hargamodal" class="col-sm-2 col-form-label">harga modal</label>
                            <div class="col-sm-10">
                                <input type="hargamodal" class="form-control" id="hargamodal" placeholder="hargamodal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qty" class="col-sm-2 col-form-label">qty</label>
                            <div class="col-sm-10">
                                <input type="qty" class="form-control" id="qty" placeholder="qty">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-2 col-form-label">keterangan</label>
                            <div class="col-sm-10">
                                <input type="keterangan" class="form-control" id="keterangan" placeholder="keterangan">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Tambahkan</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
</div>

{{-- kateogir --}}
<div class="modal fade" id="addkategori" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Tambahkan Kategori</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <!-- form start -->
                <form class="form-horizontal" action="kategori" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name" id="inputEmail3"
                                    placeholder="Kategori name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">kode</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="kode" id="inputEmail3"
                                    placeholder="3 huruf" max="3">
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Tambahkan</button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
        </div>
    </div>
</div>
