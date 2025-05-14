<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css"> --}}

    </x-slot:css>
    <x-slot:title>
        Daftar Dosen
    </x-slot:title>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Dosen</h3>
        </div>

        <div class="card-body">

            {{-- Filter --}}
            {{-- Filter --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-12 col-md-1 control-label col-form-label">Filter:</label>

                        <div class="col-12 col-md-3 mb-2 mb-md-0">
                            <select class="form-select" id="dosen_id" name="dosen_id" style="width: 100%">
                                <option value="">- Semua -</option>
                                @foreach($dosen as $item)
                                    <option value="{{ $item->dosen_id}}">{{ $item->nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter Nama</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <!-- Dosen Table -->
                <table class="table table-bordered table-sm table-striped table-hover" id="table-dosen">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIDN</th>
                            <th>Info</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>


    <x-slot:js>
        <script>
            function modalAction(url) {
                // Kosongkan modal sebelum memuat konten baru
                $("#modal-crud .modal-content").html("");

                // Panggil modal melalui AJAX
                $.get(url, function (response) {
                    $("#modal-crud .modal-content").html(response);
                    $("#modal-crud").modal("show");
                });
            }

            // Bersihkan isi modal setelah ditutup
            $('#modal-crud').on('hidden.bs.modal', function () {
                $("#modal-crud .modal-content").html("");
            });


            var dataDosen
            $(document).ready(function () {
                $('#dosen_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua -",
                    allowClear: true,
                    width: '100%' // Gunakan width penuh
                });



                dataDosen = $('#table-dosen').DataTable({
                    serverSide: true,
                    // responsive: true, // <-- ini penting

                    ajax: {
                        url: "{{ url('dosen/list') }}",
                        dataType: "json",
                        type: "POST",
                        data: function (d) {
                            d.dosen_id = $('#dosen_id').val();
                        }
                    },
                    columns: [
                        { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                        { data: "nidn", className: "", orderable: true, searchable: true },
                        { data: "info", className: "", orderable: true, searchable: true },
                        { data: "aksi", className: "", orderable: false, searchable: false }
                    ]
                });


                $('#dosen_id').on('change', function () {
                    dataDosen.ajax.reload();
                });

            });
        </script>
    </x-slot:js>
</x-layout>