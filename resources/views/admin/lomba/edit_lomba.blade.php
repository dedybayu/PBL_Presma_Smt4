<form action="{{ url('/lomba/' . $lomba->lomba_id) }}" method="POST" id="form-edit-lomba" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Data lomba</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
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
            <label>Deskripsi Lomba</label>
            <input type="text" name="lomba_deskripsi" id="lomba_deskripsi" class="form-control"
                value="{{ $lomba->lomba_deskripsi }}" required>
            <small id="error-lomba_deskripsi" class="error-text form-text text-danger"></small>
        </div>
        <div class="form-group">
            <label>Link Website Lomba</label>
            <input type="text" name="link_website" id="link_website" class="form-control"
                value="{{ $lomba->link_website }}" required>
            <small id="error-link_website" class="error-text form-text text-danger"></small>
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
            <select class="form-select" id="bidang_keahlian_id_edit" name="bidang_keahlian_id" style="width: 100%">
                <option value="" disabled>- Pilih bidang -</option>
                @foreach ($bidang as $item)
                    <option value="{{ $item->bidang_keahlian_id }}"
                        {{ old('bidang_kelas_id', $lomba->bidang_keahlian_id) == $item->bidang_keahlian_id ? 'selected' : '' }}>
                        {{ $item->bidang_keahlian_nama }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Penyelenggara</label>
            <select class="form-select" id="penyelenggara_id" name="penyelenggara_id" style="width: 100%">
                <option value="" disabled>- Pilih penyelenggara -</option>
                @foreach ($penyelenggara as $item)
                    <option value="{{ $item->penyelenggara_id }}"
                        {{ old('penyelenggara_id', $lomba->penyelenggara_id) == $item->penyelenggara_id ? 'selected' : '' }}>
                        {{ $item->penyelenggara_nama }}
                    </option>
                @endforeach
            </select>
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
        <div class="form-group">
            <label>Status verifikasi</label>
            <select name="status_verifikasi" id="status_verifikasi" class="form-control">
                <option value="" disabled>- Pilih status -</option>
                <option value="1" {{ $lomba->status_verifikasi == 1 ? 'selected' : '' }}>Terverifikasi
                </option>
                <option value="2" {{ $lomba->status_verifikasi == 2 ? 'selected' : '' }}>Menunggu</option>
                <option value="0" {{ $lomba->status_verifikasi == 0 ? 'selected' : '' }}>Ditolak</option>
            </select>
            <small id="error-status_verifikasi" class="error-text form-text text-danger"></small>
        </div>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Foto Pamflet</h5>
                <!-- Gambar  -->
                <div
                    style="position: relative; width: 100%; max-width: auto; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                    <img id="preview-pamflet" src="{{ asset('storage/' . $lomba->foto_pamflet) }}" alt="Pamflet"
                        style="width: 100%; height: 100%; object-fit: contain; display: block;">
                </div>
                <div class="form-group mt-2">
                    <!-- Foto preview-pamflet -->
                    <input type="file" name="foto_pamflet" id="foto_pamflet" class="d-none" accept="image/*"
                        onchange="previewImage(event)" data-target="preview-pamflet">

                    <!-- Custom upload button -->
                    <button type="button" class="btn btn-primary"
                        onclick="document.getElementById('foto_pamflet').click()"><i class="fa fa-upload"></i>
                        Ganti foto</button>

                    <small class="form-text text-muted">Abaikan jika tidak ingin diubah</small>
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
    function previewImage(event) {
        const fileInput = event.target;
        const targetId = fileInput.getAttribute('data-target');
        const image = document.getElementById(targetId);
        const file = fileInput.files[0];

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                image.src = e.target.result;
            };
            reader.readAsDataURL(file);

            // Kosongkan pesan error jika valid
            const errorElement = fileInput.nextElementSibling?.nextElementSibling;
            if (errorElement) errorElement.textContent = '';
        } else {
            const errorElement = fileInput.nextElementSibling?.nextElementSibling;
            if (errorElement) errorElement.textContent = "File bukan gambar yang valid.";
        }
    }

    function initSelect2() {
        // Hanya inisialisasi jika belum di-init
        $('#bidang_keahlian_id_edit, #penyelenggara_id').select2({
            theme: 'bootstrap-5',
            placeholder: "- Pilih Bidang -",
            width: '100%',
            dropdownParent: $('#modal-lomba') // ⬅️ INI PENTING!
        });
    }
    $(document).ready(function() {
        $('#modal-lomba').on('shown.bs.modal', function() {
            initSelect2();
        });

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
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
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
