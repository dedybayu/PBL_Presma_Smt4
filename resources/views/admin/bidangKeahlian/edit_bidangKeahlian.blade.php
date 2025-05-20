<form action="{{ url('/bidangKeahlian/' . $bidangKeahlian->bidang_keahlian_id) }}" method="POST" id="form-edit-bidangKeahlian">
    @csrf
    @method('PUT')

    <div class="modal-header">
        <h5 class="modal-title">Edit Data Bidang Keahlian</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label>Kode Bidang Keahlian</label>
            <input type="text" name="bidang_keahlian_kode" id="bidang_keahlian_kode" class="form-control" value="{{ $bidangKeahlian->bidang_keahlian_kode }}">
            <small id="error-bidang_keahlian_kode" class="text-danger"></small>
        </div>
        
        <div class="form-group">
            <label>Nama Bidang Keahlian</label>
            <input type="text" name="bidang_keahlian_nama" id="bidang_keahlian_nama" class="form-control" value="{{ $bidangKeahlian->bidang_keahlian_nama }}">
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
    $("#form-edit-bidangKeahlian").validate({
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
                        Swal.fire({ icon: 'success', title: 'Berhasil', text: response.message });
                        dataBidangKeahlian.ajax.reload();
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