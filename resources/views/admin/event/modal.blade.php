<div class="modal fade" id="addevent" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Tambahkan SO</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <!-- form start -->
                <form class="form-horizontal" id="modalFormEvent" action="event" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="kode"  class="col-sm-2 col-form-label">Nama Event</label>
                            <div class="col-sm-10">
                                <input type="text" name="nama" class="form-control" id="kodese"
                                    placeholder="Nama event yang diselenggarakan">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode"  class="col-sm-2 col-form-label">Dari</label>
                            <div class="col-sm-10">
                                <input type="date" name="lamaevent" min="{{date('Y-m-d')}}" class="form-control" id="kodese"
                                    placeholder="Masukan Kode">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode"  class="col-sm-2 col-form-label">Sampai</label>
                            <div class="col-sm-10">
                                <input type="date" name="sampai" min="{{date('Y-m-d')}}" class="form-control" id="kodese"
                                    placeholder="Masukan Kode">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kode"  class="col-sm-2 col-form-label">lokasi</label>
                            <div class="col-sm-10">
                                <input type="text" name="lokasi" class="form-control" id="kodese"
                                    placeholder="Lokasi event">
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
