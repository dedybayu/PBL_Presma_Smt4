<form action="{{ url('/lomba/' . $lomba->lomba_id) }}" method="POST" id="form-edit-lomba">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Data lomba</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label>Kode Lomba</label>
            <input type="text" name="lomba_kode" id="lomba_kode" class="form-control"
                value="{{ $lomba->lomba_kode }}" required>
            <small id="error-lomba_kode" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>Nama Lomba</label>
            <input type="text" name="lomba_nama" id="lomba_nama" class="form-control"
                value="{{ $lomba->lomba_nama }}" required>
            <small id="error-lomba_nama" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>Tingkat</label>
            <select name="tingkat_lomba_id" id="tingkat_lomba_id" class="form-control" required>
                <option value="">-- Pilih tingkat --</option>
                @foreach ($tingkat as $k)
                    <option value="{{ $k->tingkat_lomba_id }}"
                        {{ $lomba->tingkat_lomba_id == $k->tingkat_lomba_id ? 'selected' : '' }}>
                        {{ $k->tingkat_lomba_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-tingkat_lomba__id" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>Bidang</label>
            <select name="bidang_keahlian_id" id="bidang_keahlian_id" class="form-control" required>
                <option value="">-- Pilih bidang --</option>
                @foreach ($bidang as $n)
                    <option value="{{ $n->bidang_keahlian_id }}"
                        {{ $lomba->bidang_keahlian_id == $n->bidang_keahlian_id ? 'selected' : '' }}>
                        {{ $n->bidang_keahlian_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-bidang_keahlian_id" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>Penyelenggara</label>
            <select name="penyelenggara_id" id="penyelenggara_id" class="form-control" required>
                <option value="">-- Pilih penyelenggara --</option>
                @foreach ($penyelenggara as $n)
                    <option value="{{ $n->penyelenggara_id }}"
                        {{ $lomba->penyelenggara_id == $n->penyelenggara_id ? 'selected' : '' }}>
                        {{ $n->penyelenggara_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-penyelenggara_id" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>tanggal mulai</label>
            <input type="text" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                value="{{ $lomba->tanggal_mulai }}" required>
            <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>tanggal selesai</label>
            <input type="text" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                value="{{ $lomba->tanggal_selesai }}" required>
            <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-edit-lomba").validate({
            rules: {
                lomba_kode: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                lomba_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                tingkat_lomba_id: {
                    required: true
                },
                bidang_keahlian_id: {
                    required: true
                },
                penyelenggara_id: {
                    required: true
                },
                tanggal_mulai: {
                    required: true
                },
                tanggal_selesai: {
                    required: true
                },
                status_verifikasi: {
                    required: true
                },
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#modal-lomba').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataLomba.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-' + prefix).text(val[0]);
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                            });
                        }
                    }
                });
                return false;
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
