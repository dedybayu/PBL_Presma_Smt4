<form action="{{ url('/bidangKeahlian') }}" method="POST" id="form-tambah-bidangKeahlian">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Tambah Data Bidang Keahlian</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label for="bidang_keahlian_kode">Kode Bidang Keahlian</label>
            <input type="text" name="bidang_keahlian_kode" id="bidang_keahlian_kode" class="form-control">
            <small id="error-bidang_keahlian_kode" class="text-danger"></small>
        </div>

        <div class="form-group">
            <label for="bidang_keahlian_nama">Nama Bidang Keahlian</label>
            <input type="text" name="bidang_keahlian_nama" id="bidang_keahlian_nama" class="form-control">
            <small id="error-bidang_keahlian_nama" class="text-danger"></small>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    $(document).ready(function () {
        $("#form-tambah-bidangKeahlian").validate({
            rules: {
                bidang_keahlian_kode: { required: true, minlength: 3, maxlength: 255 },
                bidang_keahlian_nama: { required: true, minlength: 3, maxlength: 255 }
            },
            submitHandler: function (form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function (response) {
                        if (response.status) {
                            $('#modal-bidangKeahlian').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            });
                            dataBidangKeahlian.ajax.reload();
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
            }
        });
    });
</script>