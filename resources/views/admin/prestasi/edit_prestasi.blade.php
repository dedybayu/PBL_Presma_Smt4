<form action="{{ url('/prestasi/' . $prestasi->prestasi_id) }}" method="POST" id="form-edit-prestasi">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Data Prestasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label>Nama Prestasi</label>
            <input type="text" name="prestasi_nama" id="prestasi_nama" class="form-control" value="{{ $prestasi->prestasi_nama }}">
            <small id="error-prestasi_nama" class="error-text form-text text-danger"></small>
        </div>

        <div class="form-group">
            <label>Lomba</label>
            <select name="lomba_id" id="prestasi_lomba" class="form-control">
                <option value="" disabled selected>- Pilih Lomba -</option>
                @foreach($lomba as $l)
                    <option value="{{ $l->lomba_id }}" {{ $prestasi->lomba_nama == $l->lomba_nama ? 'selected' : '' }}>
                        {{ $l->lomba_nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label>Mahasiswa</label>
            <select name="mahasiswa_nama" id="mahasiswa_nama" class="form-control">
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($mahasiswa_nama as $nm)
                    <option value="{{ $n->mahasiswa_nama }}" {{ $prestasi->mahasiswa_id == $nm->mahasiswa_nama ? 'selected' : '' }}>
                        {{ $nm->mahasiswa_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-mahasiswa_nama" class="text-danger"></small>
        </div>

        <div class="form-group">
            <label>Lomba</label>
            <select name="lomba_nama" id="lomba_nama" class="form-control">
                <option value="">-- Pilih Lomba --</option>
                @foreach($kota as $k)
                    <option value="{{ $k->lomba_nama }}" {{ $prestasi->lomba_nama == $k->lomba_nama ? 'selected' : '' }}>
                        {{ $k->kota_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-lomba_nama" class="text-danger"></small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>
<script>
$(document).ready(function () {
    function toggleKotaDropdown(negaraId) {
        if (negaraId == '92') {
            $('#kota_id').prop('disabled', false);
            $('#warning-kota-non-indonesia').addClass('d-none');
        } else {
            $('#kota_id').val('').prop('disabled', true);
            $('#warning-kota-non-indonesia').removeClass('d-none');
        }
    }

    toggleKotaDropdown($('#negara_id').val());
    $('#negara_id').on('change', function () {
        toggleKotaDropdown($(this).val());
    });

    $("#form-edit-prestasi").validate({
        rules: {
            prestasi_nama: { required: true, minlength: 3, maxlength: 255 },
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
                        $('#modal-prestasi').modal('hide');
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                        dataprestasi.ajax.reload();
                    } else {
                        $('.text-danger').text('');
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