<form action="{{ url('/prestasi/')}}" method="POST" enctype="multipart/form-data" id="form_create">
    @csrf
    {{-- @method('PUT') --}}
    <div class="modal-header">
        <h5 class="modal-title">Tambah Data prestasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Prestasi</label>
                    <input value="" type="text" name="prestasi_nama" id="prestasi_nama" class="form-control" required>
                    <small id="error-prestasi_nama" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Pilih Lomba</label>
                    <select class="form-select" id="prestasi_lomba" name="lomba_id" style="width: 100%">
                        <option value="" disabled selected>- Pilih Lomba -</option>
                        @foreach($lomba as $item)
                            <option value="{{ $item->lomba_id }}">{{ $item->lomba_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Pilih Mahasiswa</label>
                    <select class="form-select" id="prestasi_mahasiswa" name="mahasiswa_id" style="width: 100%">
                        <option value="" disabled selected>- Pilih Mahasiswa -</option>
                        @foreach($mahasiswa as $item)
                            <option value="{{ $item->mahasiswa_id }}">({{ $item->nim }}) {{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Pilih Dosen Pembimbing</label>
                    <select class="form-select" id="prestasi_dosbim" name="dosen_id" style="width: 100%">
                        <option value="" disabled selected>- Pilih Dosen -</option>
                        @foreach($dosen as $item)
                            <option value="{{ $item->dosen_id }}">({{ $item->nidn }}) {{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>            
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal</label>
                    <input value="" type="date" name="tanggal_perolehan" id="tanggal_perolehan" class="form-control" required>
                    <small id="error-file_bukti_foto" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Juara</label>
                    <select class="form-select" id="prestasi_juara" name="juara" style="width: 100%">
                        <option value="" disabled selected>- Pilih Juara -</option>
                        <option value="1">Juara 1</option>
                        <option value="2">Juara 2</option>
                        <option value="3">Juara 3</option>
                        <option value="4">Kategori Lain</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group" id="juara_lain">
                    <label>Nama Kategori Juara</label>
                    <input value="" type="text" name="nama_juara" id="juara_lain" class="form-control"
                        placeholder="Contoh : Best Writer">
                    <small id="error-nama_juara" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Foto Sertifikat</label>
                    <input value="" type="file" name="file_sertifikat" id="file_sertifikat" class="form-control"
                        accept="image/*" required>
                    <small id="error-file_sertifikat" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Bukti Foto</label>
                    <input value="" type="file" name="file_bukti_foto" id="file_bukti_foto" class="form-control"
                        accept="image/*" required>
                    <small id="error-file_bukti_foto" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Surat Tugas</label>
                    <input value="" type="file" name="file_surat_tugas" id="file_surat_tugas" class="form-control"
                        accept="image/*" required>
                    <small id="error-file_surat_tugas" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Surat Undangan</label>
                    <input value="" type="file" name="file_surat_undangan" id="file_surat_undangan" class="form-control"
                        accept="image/*" required>
                    <small id="error-file_surat_undangan" class="error-text form-text text-danger"></small>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label>Proposal</label>
                    <input value="" type="file" name="file_proposal" id="file_proposal" class="form-control" accept="application/pdf">
                    <small id="error-file_surat_undangan" class="error-text form-text text-danger"></small>
                </div>
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
        $('#prestasi_lomba, #prestasi_mahasiswa, #prestasi_dosbim, #prestasi_juara').select2({
            theme: 'bootstrap-5',
            width: '100%',
            dropdownParent: $('#modal-prestasi')
        });
    }

    function toggleJuaraLain() {
        const selected = document.getElementById('prestasi_juara').value;
        const juaraLainGroup = document.querySelector('#juara_lain');
        const juaraLainInput = juaraLainGroup.querySelector('input');

        if (selected === '4') {
            juaraLainGroup.style.display = 'block';
            juaraLainInput.setAttribute('required', 'required');
        } else {
            juaraLainGroup.style.display = 'none';
            juaraLainInput.removeAttribute('required');
            juaraLainInput.value = '';
        }
    }

    $(document).ready(function () {
        initSelect2();
        toggleJuaraLain();

        $('#prestasi_juara').on('change', function () {
            toggleJuaraLain();
        });

        $('#modal-prestasi').on('shown.bs.modal', function () {
            initSelect2();
        });

        $("#form_create").validate({
            rules: {
                prestasi_nama: {
                    required: true,
                    minlength: 3,
                    maxlength: 100
                },
                lomba_id: {
                    required: true
                },
                mahasiswa_id: {
                    required: true
                },
                dosen_id: {
                    required: true
                },
                juara: {
                    required: true
                },
                nama_juara: {
                    required: function () {
                        return $('#prestasi_juara').val() === '4';
                    },
                    minlength: 3
                },
                file_sertifikat: {
                    required: true,
                    extension: "jpg|jpeg|png"
                },
                file_bukti_foto: {
                    required: true,
                    extension: "jpg|jpeg|png"
                },
                file_surat_tugas: {
                    required: true,
                    extension: "jpg|jpeg|png"
                },
                file_surat_undangan: {
                    required: true,
                    extension: "jpg|jpeg|png"
                },
                file_proposal: {
                    required: false,
                    extension: "pdf"
                }
            },

            messages: {
                nama_juara: {
                    required: "Masukkan nama kategori jika memilih 'Kategori Lain'"
                },
                file_sertifikat: {
                    extension: "File harus berupa gambar (jpg, jpeg, png, gif)"
                },
                file_bukti_foto: {
                    extension: "File harus berupa gambar (jpg, jpeg, png, gif)"
                },
                file_surat_tugas: {
                    extension: "File harus berupa gambar (jpg, jpeg, png, gif)"
                },
                file_surat_undangan: {
                    extension: "File harus berupa gambar (jpg, jpeg, png, gif)"
                }
            },

            submitHandler: function (form) {
                var formData = new FormData(form);
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.status) {
                            $('#modal-prestasi').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataPrestasi.ajax.reload();
                        } else {
                            $('.error-text').text('');
                            $.each(response.msgField, function (prefix, val) {
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