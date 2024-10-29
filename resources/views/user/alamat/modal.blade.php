<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-body">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <form action="address" method="POST">
                    @csrf
                    <input type="number" name="user_id" hidden value="{{Auth::user()->id}}" id="">
                    <div class="row mb-3">
                        <div class="col">
                            <input type="text" value="{{ Auth::user()->name }}" class="form-control" name="nama"
                                placeholder="Nama Lengkap">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" name="notlpn" placeholder="Nomor Telepon">
                        </div>
                    </div>

                    <div class="mb-3">
                        <select id="province" name="province_id" class="form-select">
                            <option selected disabled>Provinsi</option>
                            @foreach ($provinsi as $province)
                                <option value="{{ $province->id }}">{{ $province->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <select id="city" name="city_id" class="form-select">
                            <option selected disabled>kota/kabupaten</option>
                            <!-- Kota akan dimuat secara dinamis berdasarkan provinsi yang dipilih -->
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="number" name="kodePos" class="form-control" placeholder="KODE POS">
                    </div>

                    <div class="mb-3">
                        <textarea name="alamatlengkap" class="form-control" placeholder="Nama Jalan, Gedung, No. Rumah"></textarea>
                    </div>

                    <div class="mb-3">
                        <input type="text" name="patokan" class="form-control"
                            placeholder="Detail Lainnya (Cth: Blok / Unit No., Patokan)">
                    </div>

                    <h6>Tandai Sebagai:</h6>
                    <div class="btn-group btn-group-toggle mb-3" data-bs-toggle="buttons">
                        <input type="radio" class="btn-check" name="jenis" value="rumah" id="option1" autocomplete="off"
                            checked>
                        <label class="btn btn-outline-secondary" for="option1">Rumah</label>

                        <input type="radio" class="btn-check" name="jenis" value="kantor" id="option2" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="option2">Kantor</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="add-address-btn">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
