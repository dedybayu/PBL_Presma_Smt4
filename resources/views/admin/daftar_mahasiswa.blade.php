<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css"> --}}

    </x-slot:css>
    <x-slot:title>
        Daftar Mahasiswa
    </x-slot:title>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Mahasiswa</h3>
        </div>

        <div class="card-body">

            {{-- Filter --}}
            {{-- Filter --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-12 col-md-1 control-label col-form-label">Filter:</label>

                        <div class="col-12 col-md-3 mb-2 mb-md-0">
                            <select class="form-select" id="prodi_id" name="prodi_id" style="width: 100%">
                                <option value="">- Semua -</option>
                                @foreach($prodi as $item)
                                    <option value="{{ $item->prodi_id }}">{{ $item->prodi_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter Prodi</small>
                        </div>
                        <div class="col-12 col-md-3 mb-2 mb-md-0">
                            <select class="form-select" id="kelas_id" name="kelas_id" style="width: 100%">
                                <option value="">- Semua -</option>
                                @foreach($kelas as $item)
                                    <option value="{{ $item->kelas_id }}">{{ $item->kelas_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter Kelas</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <!-- Mahasiswa Table -->
                <table class="table table-bordered table-sm table-striped table-hover" id="table-mahasiswa">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Info</th>
                            <th>Kelas</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                </table>
            </div>

        </div>
    </div>

    {{-- Modal Container --}}
    <div id="modal-crud" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
        data-keyboard="false" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content"></div>
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


            var dataMahasiswa
            $(document).ready(function () {
                $('#prodi_id, #kelas_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua -",
                    allowClear: true,
                    width: '100%' // Gunakan width penuh
                });



                dataMahasiswa = $('#table-mahasiswa').DataTable({
                    serverSide: true,
                    // responsive: true, // <-- ini penting

                    ajax: {
                        url: "{{ url('mahasiswa/list') }}",
                        dataType: "json",
                        type: "POST",
                        data: function (d) {
                            d.prodi_id = $('#prodi_id').val();
                            d.kelas_id = $('#kelas_id').val();
                        }
                    },
                    columns: [
                        { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                        { data: "nim", className: "", orderable: true, searchable: true },
                        { data: "info", className: "", orderable: true, searchable: true },
                        { data: "kelas", className: "", orderable: true, searchable: true },
                        { data: "alamat", className: "", orderable: false, searchable: true },
                        { data: "aksi", className: "", orderable: false, searchable: false }
                    ]
                });


                $('#prodi_id, #kelas_id').on('change', function () {
                    dataMahasiswa.ajax.reload();
                });

            });
        </script>
    </x-slot:js>
</x-layout>