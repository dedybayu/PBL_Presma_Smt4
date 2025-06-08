<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />

        <style>
            .table-blue-striped tbody tr:nth-of-type(odd) {
                background-color: #007bff27;
                /* Warna biru muda */
            }

            .table-blue-striped tbody tr:nth-of-type(even) {
                background-color: #00ffd510;
                /* Warna biru muda */
            }
        </style>
    </x-slot:css>

    <x-slot:title>
        Edit Lomba: {{ $lomba->lomba_nama }}
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title"><i class="fa fa-trophy"> {{ $lomba->lomba_nama }}</i>
            </h3>
        </div>

        <div class="card-body">
            <form action="{{ url('/daftar_lomba/' . $lomba->lomba_id) }}" method="POST"
                enctype="multipart/form-data" id="form-edit-lomba">
                @csrf
                @method('PUT')
                <div class="row">
                    {{-- <div class="col-md-6">
                        <div class="form-group">
                            <label>Kode Lomba</label>
                            <input type="text" name="lomba_kode" id="lomba_kode" class="form-control"
                                value="{{ $lomba->lomba_kode }}">
                            <small id="error-lomba_kode" class="error-text form-text text-danger"></small>
                        </div>
                    </div> --}}
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Nama Lomba</label>
                            <input type="text" name="lomba_nama" id="lomba_nama" class="form-control"
                                value="{{ $lomba->lomba_nama }}">
                            <small id="error-lomba_nama" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="lomba_deskripsi">Deskripsi Lomba<span style="color: red;">*</span></label>
                            <textarea name="lomba_deskripsi" id="lomba_deskripsi" class="form-control" rows="5" required>{{ $lomba->lomba_deskripsi }}</textarea> {{-- Changed to textarea, value moved inside, added rows --}}
                            <small id="error-lomba_deskripsi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Link Website Lomba</label>
                            <input type="text" name="link_website" id="link_website" class="form-control"
                                value="{{ $lomba->link_website }}">
                            <small id="error-link_website" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tingkat</label>
                            <select name="tingkat_lomba_id" id="tingkat_lomba_id" class="form-control">
                                <option value="" disabled>- Pilih Tingkat -</option>
                                @foreach ($tingkat as $k)
                                    <option value="{{ $k->tingkat_lomba_id }}"
                                        {{ $lomba->tingkat_lomba_id == $k->tingkat_lomba_id ? 'selected' : '' }}>
                                        {{ $k->tingkat_lomba_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-tingkat_lomba_id" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Bidang</label>
                            <select name="bidang_keahlian_id" id="bidang_keahlian_id_edit" class="form-control">
                                <option value="">-- Pilih Bidang --</option>
                                @foreach ($bidang as $item)
                                    <option value="{{ $item->bidang_keahlian_id }}"
                                        {{ old('bidang_kelas_id', $lomba->bidang_keahlian_id) == $item->bidang_keahlian_id ? 'selected' : '' }}>
                                        {{ $item->bidang_keahlian_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small id="error-bidang_keahlian_id" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Penyelenggara</label>
                            <select name="penyelenggara_id" id="penyelenggara_id" class="form-control">
                                <option value="">-- Pilih Penyelenggara --</option>
                                @foreach ($penyelenggara as $item)
                                <option value="{{ $item->penyelenggara_id }}"
                                    {{ old('penyelenggara_id', $lomba->penyelenggara_id) == $item->penyelenggara_id ? 'selected' : '' }}>
                                    {{ $item->penyelenggara_nama }}
                                </option>
                            @endforeach
                            </select>
                            <small id="penyelenggara_id" class="text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Jumlah Anggota</label>
                            <input type="text" name="jumlah_anggota" id="jumlah_anggota" class="form-control"
                                value="{{ $lomba->jumlah_anggota }}">
                            <small id="error-jumlah_anggota" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                                value="{{ $lomba->tanggal_mulai }}" required>
                            <small id="error-tanggal_mulai" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control"
                                value="{{ $lomba->tanggal_selesai }}" required>
                            <small id="error-tanggal_selesai" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Verifikasi</label>
                            <td class="col-9">
                                @if ($lomba->status_verifikasi === 1)
                                    <span class="badge bg-success">Terverifikasi</span>
                                @elseif ($lomba->status_verifikasi === 0)
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @endif
                            </td>
                            <small id="error-status_verifikasi" class="error-text form-text text-danger"></small>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Foto Pamflet</h5>
                                <div
                                    style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                    <img id="preview-pamflet"
                                        src="{{ asset('storage/' . $lomba->foto_pamflet) }}"
                                        alt="Pamflet"
                                        style="width: 100%; height: 100%; object-fit: contain; display: block;">
                                </div>
                                <div class="form-group mt-2">
                                    <input type="file" name="foto_pamflet" id="foto_pamflet" class="d-none"
                                        accept="image/*" onchange="previewImage(event)"
                                        data-target="preview-pamflet">

                                    <button type="button" class="btn btn-primary"
                                        onclick="document.getElementById('foto_pamflet').click()"><i
                                            class="fa fa-upload"></i> Ganti Foto</button>

                                    <small class="form-text text-muted">Abaikan jika tidak ingin diubah</small>
                                    <small id="error-foto_pamflet" class="error-text form-text text-danger"></small>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="mt-5 d-flex justify-content-end ">
                    <a href="{{ route('daftar_lomba.index') }}">
                        <button type="button" class="btn btn-warning mr-2" data-dismiss="modal">Batal</button>
                    </a> 
                    <button type="submit" class="btn btn-primary ml-2">Simpan</button>
                </div>

            </form>
        </div>
    </div>


    <x-slot:modal>
        <div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="modalPreviewLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl ">
                <div class="modal-content bg-white p-3 rounded-3">
                    <div class="modal-body text-center p-0">
                        <img id="modalPreviewImg" src="" alt="Preview"
                            style="max-width: 100%; max-height: 90vh; object-fit: contain;">
                    </div>
                </div>
            </div>
        </div>
    </x-slot:modal>



    <x-slot:js>

        <script>
            function initSelect2() {
                $('#bidang_keahlian_id_edit, #penyelenggara_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Pilih Bidang -",
                    width: '100%',
                    dropdownParent: $('#modal-lomba')
                });
            }

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
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil',
                                        text: response.message
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href =
                                                "{{ route('daftar_lomba.index') }}";
                                        }
                                    });

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
    </x-slot:js>


</x-layout>
