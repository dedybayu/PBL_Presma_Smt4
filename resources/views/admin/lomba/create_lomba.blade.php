<form action="{{ url('/lomba') }}" method="POST" id="form-tambah-lomba">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Tambah Data lomba</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label for="lomba_kode">Kode Lomba</label>
            <input type="text" name="lomba_kode" id="lomba_kode" class="form-control">
            <small id="error-lomba_kode" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="lomb_nama">Nama Lomba</label>
            <input type="text" name="lomba_nama" id="lomba_nama" class="form-control">
            <small id="error-lomba_nama" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="tingkat_lomba_id">Tingkat Lomba</label>
            <select name="tingkat_lomba_id" id="tingkat_lomba_id" class="form-control">
                <option value="">- Pilih tingkat -</option>
                @foreach($tingkat as $k)
                    <option value="{{ $k->tingkat_lomba_id }}">{{ $k->tingkat_lomba_nama }}</option>
                @endforeach
            </select>
            <small id="error-tingkat_lomba_id" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="bidang_keahlian_id">Bidang</label>
            <select name="bidang_keahlian_id" id="bidang_keahlian_id" class="form-control">
                <option value="">- Pilih Keahlian -</option>
                @foreach($bidang as $n)
                    <option value="{{ $n->bidang_keahlian_id }}">{{ $n->bidang_keahlian_nama }}</option>
                @endforeach
            </select>
            <small id="error-bidang_keahlian_id" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="penyelenggara_id">Penyelenggara</label>
            <select name="penyelenggara_id" id="penyelenggara_id" class="form-control">
                <option value="">- Pilih penyelenggara -</option>
                @foreach($penyelenggara as $n)
                    <option value="{{ $n->penyelenggara_id }}">{{ $n->penyelenggara_nama }}</option>
                @endforeach
            </select>
            <small id="error-penyelenggara_id" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="tanggal_mulai">tanggal mulai</label>
            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
            <small id="error-tanggal-mulai" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="tanggal_selesai">tanggal_selesai</label>
            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control">
            <small id="error-tanggal_selesai" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="status_verifikasi">status</label>
            <input type="number" name="status_verifikasi" id="status_verifikasi" class="form-control">
            <small id="error-status_verifikasi" class="text-danger"></small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah-lomba").validate({
            rules: {
                lomba_kode: { required: true, minlength: 3, maxlength: 255 },
                lomba_nama: { required: true, minlength: 3, maxlength: 255 },
                tingkat_lomba_id: { required: true },
                bidang_keahlian_id: { required: true },
                penyelenggara_id: { required: true },
                tanggal_mulai: { required: true },
                tanggal_selesai: { required: true },
                status_verifikasi: { required: true },
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#modal-lomba').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            });
                            dataLomba.ajax.reload();
                        } else {
                            $('.text-danger').text('');
                            $.each(response.msgField, function (key, val) {
                                $('#error-' + key).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            }
        });
    });
</script>