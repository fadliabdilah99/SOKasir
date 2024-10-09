<div class="modal fade" id="addso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Tambahkan SO</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <!-- form start -->
                <form class="form-horizontal" id="modalFormSO" action="so" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="kode"  class="col-sm-2 col-form-label">kode</label>
                            <div class="col-sm-10">
                                <input type="Number" name="kode" class="form-control" id="kodese"
                                    placeholder="Masukan Kode">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputPassword3" class="col-sm-2 col-form-label">Kategori</label>
                            <div class="col-sm-10">
                                <select class="form-control  select2bs4 select2-hidden-accessible" name="kategori_id"
                                    id="kategoris">
                                    <option disabled selected>Pilih Kategori</option>
                                    @foreach ($kategori as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Foto Produk</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="foto" class="custom-file-input"
                                            id="fotos">
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
                                <input type="text" name="nama" class="form-control" id="namas"
                                    placeholder="nama">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deskripsi" class="col-sm-2 col-form-label">deskripsi</label>
                            <div class="col-sm-10">
                                <input type="text" name="deskripsi" class="form-control" id="deskripsis"
                                    placeholder="deskripsi">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hargamodal" class="col-sm-2 col-form-label">harga modal</label>
                            <div class="col-sm-10">
                                <input type="Number" name="hargamodal" class="form-control" id="hargamodals"
                                    placeholder="hargamodal">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="qty" class="col-sm-2 col-form-label">qty</label>
                            <div class="col-sm-10">
                                <input type="qty" name="qty" class="form-control" id="qtys"
                                    placeholder="qty">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="keterangan" class="col-sm-2 col-form-label">keterangan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="keterangan" id="keterangans"
                                    placeholder="keterangan">
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
                <h3 class="modal-title fs-5" id="exampleModalLabel">Kategori</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <!-- form start -->
                <form id="modalForm" class="form-horizontal" action="kategori" method="POST">
                    @csrf
                    <!-- Field untuk menyimpan ID untuk keperluan edit -->
                    <input type="hidden" name="_method" value="POST">
                    <input type="hidden" id="editId" name="id" value="">

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">name</label>
                            <div class="col-sm-10">
                                <input type="text" id="fade" class="form-control" name="name"
                                    placeholder="Kategori name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode" class="col-sm-2 col-form-label">Kode</label>
                            <div class="col-sm-10">
                                <input type="text" id="sese" class="form-control" name="kode"
                                    placeholder="3 huruf" maxlength="3">
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
