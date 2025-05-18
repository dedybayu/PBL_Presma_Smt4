<form action="{{ url('/penyelenggara/' . $penyelenggara->penyelenggara_id) }}" method="POST" id="form-edit-penyelenggara">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Data Penyelenggara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label>Nama Penyelenggara</label>
            <input type="text" name="penyelenggara_nama" id="penyelenggara_nama" class="form-control" value="{{ $penyelenggara->penyelenggara_nama }}" required>
            <small id="error-penyelenggara_nama" class="error-text form-text text-danger"></small>
        </div>

        <div class="form-group">
            <label>Lokasi (Kota)</label>
            <select name="kota_id" id="kota_id" class="form-control" required>
                <option value="">-- Pilih Kota --</option>
                @foreach($kota as $k)
                    <option value="{{ $k->kota_id }}" {{ $penyelenggara->kota_id == $k->kota_id ? 'selected' : '' }}>
                        {{ $k->kota_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-kota_id" class="error-text form-text text-danger"></small>
        </div>

        <div class="form-group">
            <label>Negara</label>
            <select name="negara_id" id="negara_id" class="form-control" required>
                <option value="">-- Pilih Negara --</option>
                @foreach($negara as $n)
                    <option value="{{ $n->negara_id }}" {{ $penyelenggara->negara_id == $n->negara_id ? 'selected' : '' }}>
                        {{ $n->negara_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-negara_id" class="error-text form-text text-danger"></small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
$(document).ready(function () {
    $("#form-edit-penyelenggara").validate({
        rules: {
            penyelenggara_nama: { required: true, minlength: 3, maxlength: 255 },
            kota_id: { required: true },
            negara_id: { required: true }
        },
        submitHandler: function (form) {
            $.ajax({
                url: form.action,
                type: form.method,
                data: $(form).serialize(),
                success: function (response) {
                    if (response.status) {
                        $('#modal-penyelenggara').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                        dataPenyelenggara.ajax.reload();
                    } else {
                        $('.error-text').text('');
                        $.each(response.msgField, function (prefix, val) {
                            $('#error-' + prefix).text(val[0]);
                        });
                        Swal.fire({ icon: 'error', title: 'Terjadi Kesalahan', text: response.message });
                    }
                }
            });
            return false;
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
        },
        highlight: function (element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }
    });
});
</script>