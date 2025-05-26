<form action="{{ url('/lomba') }}" method="POST" id="form-tambah-lomba">
    @csrf
    <div class="modal-header" style="max-height: 70vh; overflow-y: auto;">
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
            <label for="lomba_nama">Nama Lomba</label>
            <input type="text" name="lomba_nama" id="lomba_nama" class="form-control">
            <small id="error-lomba_nama" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="lomba_deskripsi">deskripsi lomba</label>
            <input type="text" name="lomba_deskripsi" id="lomba_deskripsi" class="form-control">
            <small id="error-lomba_deskripsi" class="text-danger"></small>
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
            <label>Bidang</label>
            <select class="form-select" id="bidang_keahlian_id_create" name="bidang_keahlian_id" style="width: 100%">
                <option value="" disabled selected>- Pilih bidang -</option>
                @foreach($bidang as $item)
                    <option value="{{ $item->bidang_keahlian_id }}">
                        {{ $item->bidang_keahlian_nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Penyelenggara</label>
            <select class="form-select" id="penyelenggara_id" name="penyelenggara_id" style="width: 100%">
                <option value="" disabled selected>- Pilih penyelenggara -</option>
                @foreach($penyelenggara as $item)
                    <option value="{{ $item->penyelenggara_id }}">
                        {{ $item->penyelenggara_nama }}
                    </option>
                @endforeach
            </select>
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
        <div class="col-md-6">
            <div class="form-group">
                <label>Foto pamflet</label>
                <input value="" type="file" name="foto_pamflet" id="foto_pamflet" class="form-control"
                    accept="image/*" required>
                <small id="error-foto_pamflet" class="error-text form-text text-danger"></small>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    function initSelect2() {
        // Hanya inisialisasi jika belum di-init
        $('#bidang_keahlian_id_create, #penyelenggara_id').select2({
            theme: 'bootstrap-5',
            placeholder: "- Pilih Bidang -",
            width: '100%',
            dropdownParent: $('#modal-lomba') // ⬅️ INI PENTING!
        });
    }

    $(document).ready(function () {
        initSelect2();
        // Inisialisasi Select2 saat modal dibuka
        $('#modal-lomba').on('shown.bs.modal', function () {
            initSelect2();
        });

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