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
            <select name="lomba_id" id="lomba_id" class="form-control">
                <option value="" disabled>- Pilih Lomba -</option>
                @foreach($lomba as $l)
                    <option value="{{ $l->lomba_id }}" {{ $prestasi->lomba_id == $l->lomba_id ? 'selected' : '' }}>
                        {{ $l->lomba_nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-lomba_id" class="text-danger"></small>
        </div>

        <div class="form-group">
            <label>Mahasiswa</label>
            <select name="mahasiswa_id" id="mahasiswa_id" class="form-control">
                <option value="">-- Pilih Mahasiswa --</option>
                @foreach($mahasiswa as $m)
                    <option value="{{ $m->mahasiswa_id }}" {{ $prestasi->mahasiswa_id == $m->mahasiswa_id ? 'selected' : '' }}>
                        ({{ $m->nim }}) {{ $m->nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-mahasiswa_id" class="text-danger"></small>
        </div>

        <div class="form-group">
            <label>Dosen Pembimbing</label>
            <select name="dosen_id" id="dosen_id" class="form-control">
                <option value="">-- Pilih Dosen Pembimbing --</option>
                @foreach($dosen as $d)
                    <option value="{{ $d->dosen_id }}" {{ $prestasi->dosen_id == $d->dosen_id ? 'selected' : '' }}>
                        ({{ $d->nidn }}) {{ $d->nama }}
                    </option>
                @endforeach
            </select>
            <small id="error-dosen_id" class="text-danger"></small>
        </div>

        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal_perolehan" id="tanggal_perolehan" class="form-control" value="{{ $prestasi->tanggal_perolehan }}">
            <small id="error-tanggal_perolehan" class="error-text form-text text-danger"></small>
        </div>

        <div class="form-group">
            <label>Juara</label>
            <select name="juara" id="prestasi_juara" class="form-control">
                <option value="" disabled>- Pilih Juara -</option>
                <option value="1" {{ $prestasi->juara == 1 ? 'selected' : '' }}>Juara 1</option>
                <option value="2" {{ $prestasi->juara == 2 ? 'selected' : '' }}>Juara 2</option>
                <option value="3" {{ $prestasi->juara == 3 ? 'selected' : '' }}>Juara 3</option>
                <option value="4" {{ $prestasi->juara == 4 ? 'selected' : '' }}>Kategori Lain</option>
            </select>
            <small id="error-juara" class="error-text form-text text-danger"></small>
        </div>

        <div class="form-group" id="juara_lain">
            <label>Nama Kategori Juara</label>
            <input type="text" name="nama_juara" id="nama_juara" class="form-control" value="{{ $prestasi->nama_juara }}" placeholder="Contoh: Best Writer">
            <small id="error-nama_juara" class="error-text form-text text-danger"></small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    function toggleJuaraLainEdit() {
        const selected = document.getElementById('prestasi_juara').value;
        const juaraLainGroup = document.getElementById('juara_lain');
        const input = document.getElementById('nama_juara');

        if (selected === '4') {
            juaraLainGroup.style.display = 'block';
            input.setAttribute('required', 'required');
        } else {
            juaraLainGroup.style.display = 'none';
            input.removeAttribute('required');
            input.value = '';
        }
    }

    $(document).ready(function () {
        toggleJuaraLainEdit();
        $('#prestasi_juara').on('change', toggleJuaraLainEdit);

        $("#form-edit-prestasi").validate({
            rules: {
                prestasi_nama: { required: true, minlength: 3, maxlength: 255 },
                lomba_id: { required: true },
                mahasiswa_id: { required: true },
                dosen_id: { required: true },
                tanggal_perolehan: { required: true },
                juara: { required: true },
                nama_juara: {
                    required: function () {
                        return $('#prestasi_juara').val() === '4';
                    },
                    minlength: 3
                }
            },
            messages: {
                nama_juara: {
                    required: "Masukkan nama kategori jika memilih 'Kategori Lain'"
                }
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
