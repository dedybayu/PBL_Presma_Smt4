<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />
    </x-slot:css>

    <x-slot:title>
        Daftar Kelas
    </x-slot:title>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Kelas</h3>
        </div>

        <div class="card-body">

            {{-- Filter --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-12 col-md-1 control-label col-form-label">Filter:</label>

                        <div class="col-12 col-md-4 mb-2 mb-md-0">
                            <select class="form-select" id="prodi_id" name="prodi_id" style="width: 100%">
                                <option value="">- Semua -</option>
                                @foreach($prodi as $item)
                                    <option value="{{ $item->prodi_id }}">{{ $item->prodi_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter Prodi</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <!-- Kelas Table -->
                <table class="table table-bordered table-sm table-striped table-hover" id="table-kelas">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Kelas</th>
                            <th>Nama Kelas</th>
                            <th>Program Studi</th>
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
                $("#modal-crud .modal-content").html("");

                $.get(url, function (response) {
                    $("#modal-crud .modal-content").html(response);
                    $("#modal-crud").modal("show");
                });
            }

            $('#modal-crud').on('hidden.bs.modal', function () {
                $("#modal-crud .modal-content").html("");
            });

            var dataKelas;
            $(document).ready(function () {
                $('#prodi_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua -",
                    allowClear: true,
                    width: '100%'
                });

                dataKelas = $('#table-kelas').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('kelas/list') }}",
                        type: "POST",
                        data: function (d) {
                            d.prodi_id = $('#prodi_id').val();
                        }
                    },
                    columns: [
                        { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                        { data: "kode", orderable: true, searchable: true },
                        { data: "nama", orderable: true, searchable: true },
                        { data: "prodi", orderable: true, searchable: true },
                        { data: "aksi", orderable: false, searchable: false }
                    ]
                });

                $('#prodi_id').on('change', function () {
                    dataKelas.ajax.reload();
                });
            });
        </script>
    </x-slot:js>
</x-layout>