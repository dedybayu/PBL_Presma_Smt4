<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
        {{-- <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css"> --}}
    </x-slot:css>

    <x-slot:title>
        Daftar Bidang Keahlian
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title">Daftar Bidang Keahlian</h3>
            <div class="btn-actions-pane-right text-capitalize">
                <button onclick="modalAction('{{ url('/bidangKeahlian/create') }}')" class="btn btn-sm btn-success mt-1">
                    <i class="fa fa-plus"></i> Tambah Bidang Keahlian
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped table-hover" id="table-bidangKeahlian">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Bidang Keahlian</th>
                            <th>Nama Bidang Keahlian</th>
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
                $("#modal-bidangKeahlian .modal-content").html("");
                $.get(url, function(response) {
                    $("#modal-bidangKeahlian .modal-content").html(response);
                    $("#modal-bidangKeahlian").modal("show");
                });
            }

            $('#modal-bidangKeahlian').on('hidden.bs.modal', function() {
                $("#modal-bidangKeahlian .modal-content").html("");
            });

            var dataBidangKeahlian;
            $(document).ready(function() {
                dataBidangKeahlian = $('#table-bidangKeahlian').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('bidangKeahlian/list') }}",
                        dataType: "json",
                        type: "POST",
                        data: function(d) {
                            d.bidang_id = $('#filter_bidang_id').val();
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', className: "text-center", orderable: false, searchable: false },
                        { data: 'bidang_keahlian_kode', orderable: true, searchable: true },
                        { data: 'bidang_keahlian_nama', orderable: true, searchable: true },
                        { data: "aksi", className: "", orderable: false, searchable: false }
                    ]
                });

                $('#bidangKeahlian_id').on('change', function () {
                    dataBidangKeahlian.ajax.reload();
                });
            });
        </script>
    </x-slot:js>
</x-layout>