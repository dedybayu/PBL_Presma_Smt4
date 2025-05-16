@empty($mahasiswa)
    <div id="modal-mahasiswa" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/mahasiswa') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/mahasiswa/' . $mahasiswa->mahasiswa_id) }}" method="POST" id="form-edit">
        @csrf
        @method('PUT')
        <div class="modal-header">
            <h5 class="modal-title">Edit Data mahasiswa</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center">
                        <img id="profileImage" class="img-thumbnail rounded-circle mb-3"
                            style="width: 160px; height: 160px; object-fit: cover;"
                            src="{{ $mahasiswa->profile_picture ? asset('storage/' . auth()->mahasiswa()->profile_picture) : asset('assets/images/user.png') }}"
                            alt="Profile picture">

                        <div class="mt-2">
                            <input type="file" id="profile_picture" name="profile_picture" class="d-none" accept="image/*"
                                onchange="previewImage(event)">
                            <button type="button" onclick="document.getElementById('profile_picture').click()"
                                class="btn btn-primary">
                                Change Picture
                            </button>
                            <button type="button" onclick="removeImage()" class="btn btn-outline-danger">
                                Delete Picture
                            </button>
                        </div>
                    </div>
                </div>

                <input type="hidden" id="remove_picture" name="remove_picture" value="0">

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username</label>
                        <input value="{{ $mahasiswa->user->username }}" type="text" name="username" id="username"
                            class="form-control" required>
                        <small id="error-username" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>NIM</label>
                        <input value="{{ $mahasiswa->nim }}" type="number" name="nim" id="nim" class="form-control"
                            required>
                        <small id="error-nim" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input value="{{ $mahasiswa->nama }}" type="text" name="nama" id="nama" class="form-control"
                            required>
                        <small id="error-nama" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Email</label>
                        <input value="{{ $mahasiswa->email }}" type="email" name="email" id="email" class="form-control"
                            required>
                        <small id="error-email" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>No. Tlp</label>
                        <input value="{{ $mahasiswa->no_tlp }}" type="text" name="no_tlp" id="no_tlp" class="form-control"
                            required>
                        <small id="error-no_tlp" class="error-text form-text text-danger"></small>
                    </div>
                </div>
            </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <input value="{{ $mahasiswa->alamat }}" type="text" name="alamat" id="alamat" class="form-control"
                        required>
                    <small id="error-alamat" class="error-text form-text text-danger"></small>
                </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tahun Angkatan</label>
                        <input value="{{ $mahasiswa->tahun_angkatan }}" type="number" name="tahun_angkatan"
                            id="tahun_angkatan" class="form-control" required>
                        <small id="error-tahun_angkatan" class="error-text form-text text-danger"></small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password</label>
                        <input value="" type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small>
                        <small id="error-password" class="error-text form-text text-danger"></small>
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
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('profileImage');
                output.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
            document.getElementById('remove_picture').value = "0";
        }

        function removeImage() {
            document.getElementById('profileImage').src = '/../img/mahasiswa.png';
            document.getElementById('profile_picture').value = '';
            document.getElementById('remove_picture').value = "1";
        }

        $(document).ready(function () {
            $("#form-edit").validate({
                rules: {
                    nim: { required: true, minlength: 3, maxlength: 20 },
                    nama: { required: true, minlength: 3, maxlength: 100 },
                    password: { minlength: 6, maxlength: 20 }
                },
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#modal-mahasiswa').modal('hide');
                                Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                                dataMahasiswa.ajax.reload();
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
@endempty