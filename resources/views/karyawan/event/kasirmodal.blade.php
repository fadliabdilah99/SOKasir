<div class="modal fade" id="addprod" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-l">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">barang</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <!-- form start -->
                <form id="modalForm" class="form-horizontal" action="{{ url('addprod') }}" method="POST">
                    @csrf
                    <!-- Field untuk menyimpan ID untuk keperluan edit -->
                    <input type="hidden" name="_method" value="POST">
                    <input type="number" name="pesanan_id" hidden value="{{ $pesananId }}">
                    <input type="number" name="barangeven_id" value="" hidden id="berangevent">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-2 col-form-label">jumlah</label>
                            <div class="col-sm-10">
                                <input type="number" required id="jumlah" class="form-control" name="qty"
                                    placeholder="Jumlah">
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


<div class="modal fade" id="selesai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Selesaikan Pesanan</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="card card-info">
                <div class="d-flex justify-content-center align-items-center">
                    <img src="{{ asset('dist') }}/img/credit/visa.png" width="500px" alt="">
                </div>
                <!-- form start -->
                <form id="modalForm" class="form-horizontal" action="{{ url('selesaikan') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <input type="text" name="jenis" value="event" hidden>
                    <input type="number" name="pesananId" value="{{ $pesananId }}" hidden>
                    <input type="number" name="eventId" hidden value="{{ $eventId }}" id="barangeven">


                    <div class="card-body">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Bukti pembayaran (opsional)</label>
                            <div class="col-sm-8">
                                <input type="file" id="jumlah" class="form-control" name="bukti"
                                    placeholder="Jumlah">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-info">Selesaikan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
