<form action="{{ url('/rekomendasi/refresh') }}" method="POST" id="form-refresh-rekomendasi">
    @csrf
    <div class="modal-header">
        <h5 class="modal-title">Perbarui Data Rekomendasi</h5>
        <button type="button" class="close" data-dismiss="modal">
            <span>&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="form-group">
            <label for="metode"><strong>Pilih Metode Perhitungan:</strong></label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="metode" id="metode_topsis" value="topsis">
                <label class="form-check-label" for="metode_topsis">TOPSIS</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="metode" id="metode_saw" value="saw">
                <label class="form-check-label" for="metode_saw">SAW</label>
            </div>
            <small id="error-metode" class="text-danger"></small>
        </div>
    </div>


    <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-success"><i class="fa fa-refresh"></i> Perbarui</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-refresh-rekomendasi").validate({
            rules: {
                metode: {
                    required: true
                }
            },
            messages: {
                metode: {
                    required: "Silakan pilih salah satu metode."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "metode") {
                    error.insertAfter(element.closest(".form-group")); // Supaya tidak numpuk
                } else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if (response.status) {
                            $('#modal-rekomendasi').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message,
                            });
                            dataRekomendasi.ajax.reload();
                        } else {
                            $('.text-danger').text('');
                            $.each(response.msgField, function(key, val) {
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
