<x-layout>
    <x-slot:css>
    </x-slot:css>
    <x-slot:title>
        Daftar Mahasiswa
    </x-slot:title>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Mahasiswa</h3>
        </div>

        <div class="card-body">
            <!-- Filter Section -->
            <div class="form-horizontal filter-date p-3 border-bottom mb-4">
                <div class="row align-items-center">
                    <!-- Filter Dropdown -->
                    <div class="col-auto">
                        <div class="input-group input-group-sm">
                            <label class="input-group-text bg-light border-end-0 rounded-start" for="filter_kelas">
                                <i class="fa fa-filter text-muted"></i>
                            </label>
                            <select name="filter_kelas" id="filter_kelas"
                                class="form-select form-select-sm filter_kelas border-start-0" style="min-width: 150px">
                                <option value="">- Semua -</option>
                                <option value="TI">Kelas TI</option>
                                <option value="SIB">Kelas SIB</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Box -->
                    <div class="col-auto">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 rounded-start">
                                <i class="fa fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="search-mahasiswa"
                                placeholder="Search">
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="reset-filter">
                            <i class="fa fa-undo"></i> Reset
                        </button>
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

    <!-- Modal Section -->
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


            var dataSupplier
            $(document).ready(function () {
                dataSupplier = $('#table-mahasiswa').DataTable({
                    serverSide: true,
                    ajax: {
                        url: "{{ url('mahasiswa/list') }}",
                        dataType: "json",
                        type: "POST",
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
            });
        </script>
    </x-slot:js>
</x-layout>