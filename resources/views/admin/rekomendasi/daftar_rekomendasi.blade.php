<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />
        {{--
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap5.min.css">
        --}}
    </x-slot:css>

    <x-slot:title>
        Daftar Rekomendasi Mahasiswa
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title">Daftar Rekomendasi Mahasiswa</h3>
            <div class="btn-actions-pane-right text-capitalize">
                <button onclick="modalAction('{{ url('/rekomendasi/refresh') }}')" class="btn btn-sm btn-success mt-1">
                    <i class="fa fa-refresh" aria-hidden="true"></i> Perbarui Data
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive w-100">
                <table class="table table-bordered table-sm table-striped table-hover w-100" id="table-rekomendasi">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Lomba</th>
                            <th>Rekomendasi Mahasiswa</th>
                            <th>NIM Mahasiswa</th>
                            <th>Rank/Lomba</th>
                        </tr>
                    </thead>
                </table>
            </div>

            <div class="btn-actions-pane-right text-capitalize mt-3">
                <button onclick="modalAction('{{ url('/rekomendasi/confirm') }}')" class="btn btn-sm btn-danger mt-1">
                    <i class="fa fa-trash" aria-hidden="true"></i> Hapus Semua Data
                </button>
            </div>
        </div>
    </div>

    <x-slot:modal>
        <div id="modal-rekomendasi" class="modal fade animate shake" tabindex="-1" role="dialog"
            data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-xs" role="document">
                <div class="modal-content"></div>
            </div>
        </div>
    </x-slot:modal>

    <x-slot:js>
        <script>
            function modalAction(url) {
                $("#modal-rekomendasi .modal-content").html("");
                $.get(url, function(response) {
                    $("#modal-rekomendasi .modal-content").html(response);
                    $("#modal-rekomendasi").modal("show");
                });
            }

            $('#modal-rekomendasi').on('hidden.bs.modal', function() {
                $("#modal-rekomendasi .modal-content").html("");
            });

            var dataRekomendasi;
            $(document).ready(function() {
                dataRekomendasi = $('#table-rekomendasi').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('rekomendasi/list') }}",
                        dataType: "json",
                        type: "POST",
                        data: function(d) {
                            d.bidang_id = $('#filter_bidang_id').val();
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            className: "text-center",
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama_lomba',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'rekomendasi_mahasiswa',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'nim',
                            orderable: true,
                            searchable: true
                        },
                        {
                            data: 'rank',
                            orderable: true,
                            searchable: true
                        },

                    ]
                });

                $('#rekomendasi_id').on('change', function() {
                    dataRekomendasi.ajax.reload();
                });
            });
        </script>
    </x-slot:js>
</x-layout>
