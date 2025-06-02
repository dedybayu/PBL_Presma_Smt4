<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    </x-slot:css>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title">Edit Daftar Prestasi <i class="fa fa-trophy"></i></h3>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ url('edit-lomba') }}" enctype="multipart/form-data" id="form-edit-lomba">
                @csrf

                <div class="row">
                    {{-- Kode Lomba --}}
                    <div class="col-md-12">
                        <x-form.input name="lomba_kode" label="Kode Lomba" :value="$lomba->lomba_kode" required />
                    </div>

                    {{-- Nama & Deskripsi --}}
                    <div class="col-md-6">
                        <x-form.input name="lomba_nama" label="Nama Lomba" :value="$lomba->lomba_nama" required />
                    </div>
                    <div class="col-md-6">
                        <x-form.input name="lomba_deskripsi" label="Deskripsi Lomba" :value="$lomba->lomba_deskripsi" required />
                    </div>

                    {{-- Link Website & Tingkat --}}
                    <div class="col-md-6">
                        <x-form.input name="link_website" label="Link Website Lomba" :value="$lomba->link_website" required />
                    </div>
                    <div class="col-md-6">
                        <x-form.select name="tingkat_lomba_id" label="Tingkat" :options="$tingkat" :selected="$lomba->tingkat_lomba_id" optionValue="tingkat_lomba_id" optionLabel="tingkat_lomba_nama" required />
                    </div>

                    {{-- Bidang & Penyelenggara --}}
                    <div class="col-md-6">
                        <x-form.select name="bidang_keahlian_id" label="Bidang" id="bidang_keahlian_id_edit" :options="$bidang" :selected="$lomba->bidang_keahlian_id" optionValue="bidang_keahlian_id" optionLabel="bidang_keahlian_nama" required />
                    </div>
                    <div class="col-md-6">
                        <x-form.select name="penyelenggara_id" label="Penyelenggara" id="penyelenggara_id" :options="$penyelenggara" :selected="$lomba->penyelenggara_id" optionValue="penyelenggara_id" optionLabel="penyelenggara_nama" required />
                    </div>

                    {{-- Tanggal --}}
                    <div class="col-md-6">
                        <x-form.input name="tanggal_mulai" label="Tanggal Mulai" :value="$lomba->tanggal_mulai" required />
                    </div>
                    <div class="col-md-6">
                        <x-form.input name="tanggal_selesai" label="Tanggal Selesai" :value="$lomba->tanggal_selesai" required />
                    </div>

                    {{-- Status Verifikasi --}}
                    <div class="col-md-6">
                        <x-form.select name="status_verifikasi" label="Status Verifikasi" :selected="$lomba->status_verifikasi" :options="[['value' => 1, 'label' => 'Terverifikasi'], ['value' => 2, 'label' => 'Menunggu'], ['value' => 0, 'label' => 'Ditolak']]" />
                    </div>

                    {{-- Foto Pamflet --}}
                    <div class="col-md-6">
                        <x-form.image-preview name="foto_pamflet" label="Foto Pamflet" :src="asset('storage/' . $lomba->foto_pamflet)" />
                    </div>

                    {{-- Tombol --}}
                    <div class="modal-footer mt-3">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <x-slot:js>
        <script>
            function previewImage(event) {
                const targetId = event.target.dataset.target;
                const image = document.getElementById(targetId);
                const file = event.target.files[0];

                if (file && file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = e => image.src = e.target.result;
                    reader.readAsDataURL(file);
                    event.target.classList.remove('is-invalid');
                } else {
                    image.src = '';
                    event.target.classList.add('is-invalid');
                }
            }

            function initSelect2() {
                $('#bidang_keahlian_id_edit, #penyelenggara_id').select2({
                    theme: 'bootstrap-5',
                    width: '100%',
                    dropdownParent: $('#modal-lomba')
                });
            }

            $(document).ready(function () {
                $('#modal-lomba').on('shown.bs.modal', initSelect2);

                $('#form-edit-lomba').validate({
                    rules: {
                        lomba_kode: { required: true, minlength: 3 },
                        lomba_nama: { required: true, minlength: 3 },
                        lomba_deskripsi: { required: true },
                        link_website: { required: true },
                        tingkat_lomba_id: { required: true },
                        bidang_keahlian_id: { required: true },
                        penyelenggara_id: { required: true },
                        tanggal_mulai: { required: true },
                        tanggal_selesai: { required: true },
                        status_verifikasi: { required: true },
                    },
                    submitHandler: function (form) {
                        const formData = new FormData(form);
                        $.ajax({
                            url: form.action,
                            method: form.method,
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (res) {
                                if (res.status) {
                                    $('#modal-lomba').modal('hide');
                                    Swal.fire('Berhasil', res.message, 'success');
                                    dataLomba.ajax.reload();
                                } else {
                                    $('.error-text').text('');
                                    $.each(res.msgField, (key, val) => {
                                        $('#error-' + key).text(val[0]);
                                    });
                                    Swal.fire('Error', res.message, 'error');
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
    </x-slot:js>
</x-layout>
