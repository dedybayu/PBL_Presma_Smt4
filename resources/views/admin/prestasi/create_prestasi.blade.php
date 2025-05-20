<form action="{{ url('/prestasi/')}}" method="POST" enctype="multipart/form-data" id="form_create">
    @csrf
    {{-- @method('PUT') --}}
    <div class="modal-header">
        <h5 class="modal-title">Edit Data prestasi</h5>
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
                        <option value="" disabled selected>- Pilih Prodi -</option>
                        @foreach($lomba as $item)
                            <option value="{{ $item->lomba_id }}">{{ $item->lomba_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-md-6">
                <div class="form-group">
                    <label>Kelas</label>
                    <select class="form-select" id="prestasi_kelas" name="kelas_id" style="width: 100%">
                        <option value="" disabled selected>- Pilih Kelas -</option>
                        @foreach($kelas as $item)
                            <option value="{{ $item->kelas_id }}" data-prodi-id="{{ $item->prodi_id }}">
                                {{ $item->kelas_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="col-md-6">
                <div class="form-group">
                    <label>aaaaa</label>
                    <input value="" type="text" name="aaaaa" id="aaaaa" class="form-control" required>
                    <small id="error-no_tlp" class="error-text form-text text-danger"></small>
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
        // Hanya inisialisasi jika belum di-init
        if (!$('#prestasi_lomba').hasClass("select2-hidden-accessible")) {
            $('#prestasi_lomba').select2({
                theme: 'bootstrap-5',
                placeholder: "- Pilih Prodi -",
                width: '100%',
                dropdownParent: $('#modal-prestasi') // ⬅️ INI PENTING!
            });
        }
    }


    $(document).ready(function () {
        initSelect2();
        // Inisialisasi Select2 saat modal dibuka
        $('#modal-prestasi').on('shown.bs.modal', function () {
            initSelect2();
        });

        $("#form_create").validate({
            rules: {
                username: { required: true, minlength: 3, maxlength: 20 },
                nama: { required: true, minlength: 3, maxlength: 100 },
                password: { minlength: 6, maxlength: 20 }
            },
            submitHandler: function (form) {
                var formData = new FormData(form); // Gunakan FormData untuk menangani file
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: formData,
                    processData: false, // Penting: Agar jQuery tidak memproses data
                    contentType: false, // Penting: Agar tidak diubah menjadi application/x-www-form-urlencoded
                    success: function (response) {
                        if (response.status) {
                            $('#modal-prestasi').modal('hide');
                            Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                            dataprestasi.ajax.reload();
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
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>