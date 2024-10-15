@foreach ($margin as $items)
    <div class="modal fade" id="modal-default{{ $items->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Tambahkan SO</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="card card-info">
                    <form class="form-horizontal" id="modalFormEvent" action="margin/{{$items->id}}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="kode" class="col-sm-2 col-form-label">Margin</label>
                                <div class="col-sm-10">
                                    <input type="number" value="{{$items->margin}}" name="margin" class="form-control" id="kodese"
                                        placeholder="Presentase keuntungan">
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
@endforeach
