<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    </x-slot:css>

    <x-slot:title>
        Daftar Penyelenggara
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title">Daftar Penyelenggara</h3>
            <div class="btn-actions-pane-right text-capitalize">
                <button onclick="modalAction('{{ url('/penyelenggara/create') }}')" class="btn btn-sm btn-success mt-1">
                    <i class="fa fa-plus"></i> Tambah Penyelenggara
                </button>
            </div>
        </div>

        <div class="card-body">
            {{-- Filter --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-12 col-md-1 control-label col-form-label">Filter:</label>

                        <div class="col-12 col-md-3 mb-2 mb-md-0">
                            <select class="form-select" id="filter_kota_id" name="kota_id" style="width: 100%">
                                <option value="">- Semua Kota -</option>
                                @foreach($kota as $item)
                                    <option value="{{ $item->kota_id }}">{{ $item->kota_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter Kota</small>
                        </div>

                        <div class="col-12 col-md-3 mb-2 mb-md-0">
                            <select class="form-select" id="filter_negara_id" name="negara_id" style="width: 100%">
                                <option value="">- Semua Negara -</option>
                                @foreach($negara as $item)
                                    <option value="{{ $item->negara_id }}">{{ $item->negara_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter Negara</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped table-hover" id="table-penyelenggara">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Penyelenggara</th>
                            <th>Kota</th>
                            <th>Negara</th>
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
                $("#modal-penyelenggara .modal-content").html("");
                $.get(url, function(response) {
                    $("#modal-penyelenggara .modal-content").html(response);
                    $("#modal-penyelenggara").modal("show");
                });
            }

            $('#modal-penyelenggara').on('hidden.bs.modal', function() {
                $("#modal-penyelenggara .modal-content").html("");
            });

            var dataPenyelenggara;
            $(document).ready(function() {
                $('#filter_kota_id, #filter_negara_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua -",
                    allowClear: true,
                    width: '100%'
                });

                dataPenyelenggara = $('#table-penyelenggara').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('penyelenggara/list') }}",
                        dataType: "json",
                        type: "POST",
                        data: function(d) {
                            d.kota_id = $('#filter_kota_id').val();
                            d.negara_id = $('#filter_negara_id').val();
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false },
                        { data: 'nama', orderable: true, searchable: true },
                        { data: 'kota', orderable: true, searchable: true },
                        { data: 'negara', orderable: true, searchable: true },
                        { data: 'aksi', className: "text-center", orderable: false, searchable: false }
                    ]
                });

                $('#filter_kota_id, #filter_negara_id').on('change', function() {
                    dataPenyelenggara.ajax.reload();
                });
            });
        </script>
    </x-slot:js>
</x-layout>