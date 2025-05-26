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
        Daftar Lomba
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title"> Portfolio Performance
            </h3>
            <div class="btn-actions-pane-right text-capitalize">
                {{-- <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View All</button> --}}
                <button onclick="modalAction('{{ url('/lomba/create') }}')" class="btn btn-sm btn-success mt-1">
                    <i class="fa fa-plus"></i> Tambah data
                </button>
            </div>
        </div>

        <div class="card-body">


            {{-- Filter --}}
            {{-- Filter --}}
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-12 col-md-1 control-label col-form-label">Filter:</label>

                        <div class="col-12 col-md-3 mb-2 mb-md-0">
                            <select class="form-select" id="bidang_keahlian_id" name="bidang_keahlian_id" style="width: 100%">
                                <option value="">- Semua -</option>
                                @foreach($bidang as $item)
                                    <option value="{{ $item->bidang_keahlian_id }}">{{ $item->bidang_keahlian_nama }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter bidang</small>
                        </div>
                        {{-- <div class="col-12 col-md-3 mb-2 mb-md-0">
                            <select class="form-select" id="kelas_id" name="kelas_id" style="width: 100%">
                                <option value="">- Semua -</option>
                                @foreach($kelas as $item)
                                    <option value="{{ $item->kelas_id }}" data-prodi-id="{{ $item->prodi_id }}">
                                        {{ $item->kelas_nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Filter Kelas</small>
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <!-- Mahasiswa Table -->
                <table class="table table-bordered table-sm table-striped table-hover" id="table-lomba">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>lomba kode</th>
                            <th>Info</th>
                            <th>Deskripsi</th>
                            <th>Tanggal mulai</th>
                            <th>Tanggal selesai</th>
                            <th>Status verifikasi</th>
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
                $("#modal-lomba .modal-content").html("");

                // Panggil modal melalui AJAX
                $.get(url, function (response) {
                    $("#modal-lomba .modal-content").html(response);
                    $("#modal-lomba").modal("show");
                });
            }

            // Bersihkan isi modal setelah ditutup
            $('#modal-lomba').on('hidden.bs.modal', function () {
                $("#modal-lomba .modal-content").html("");
            });

            var dataLomba
            $(document).ready(function () {
                // handleKelasFilterByBidang('#bidang_keahlian_id');

                $('#bidang_keahlian_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua -",
                    allowClear: true,
                    width: '100%' // Gunakan width penuh
                });



                dataLomba = $('#table-lomba').DataTable({
                    serverSide: true,
                    // responsive: true, // <-- ini penting

                    ajax: {
                        url: "{{ url('lomba/list') }}",
                        dataType: "json",
                        type: "POST",
                        data: function (d) {
                            d.bidang_keahlian_id = $('#bidang_keahlian_id').val();
                            
                        }
                    },
                    columns: [
                        { data: "DT_RowIndex", className: "text-center", orderable: false, searchable: false },
                        { data: "lomba_kode", className: "", orderable: true, searchable: true },
                        { data: "info", className: "", orderable: true, searchable: true },
                        { data: "deskripsi", className: "", orderable: true, searchable: true },
                        { data: "tanggal_mulai", className: "", orderable: true, searchable: true },
                        { data: "tanggal_selesai", className: "", orderable: false, searchable: true },
                        { data: "status_verifikasi", className: "", orderable: false, searchable: true },
                        { data: "aksi", className: "", orderable: false, searchable: false }
                    ]
                });


                $('#bidang_keahlian_id').on('change', function () {
                    dataLomba.ajax.reload();
                });

            });

            // function handleKelasFilterByP(prodiSelector, kelasSelector) {
            //     const $prodi = $(prodiSelector);
            //     const $kelas = $(kelasSelector);

            //     const allOptions = $kelas.find('option').clone(); // simpan semua opsi awal

            //     $kelas.prop('disabled', true);

            //     $prodi.on('change', function () {
            //         const selectedProdiId = $(this).val();

            //         if (selectedProdiId) {
            //             // Filter opsi sesuai prodi
            //             const filteredOptions = allOptions.filter(function () {
            //                 const prodiId = $(this).data('prodi-id');
            //                 return !prodiId || prodiId == selectedProdiId || $(this).val() === ""; // biarkan option kosong tetap ada
            //             });

            //             $kelas.empty().append(filteredOptions); // update opsi
            //             $kelas.prop('disabled', false).val('');

            //             // Refresh Select2
            //             if ($kelas.hasClass("select2-hidden-accessible")) {
            //                 $kelas.trigger('change.select2');
            //             }
            //         } else {
            //             $kelas.prop('disabled', true).val('');

            //             if ($kelas.hasClass("select2-hidden-accessible")) {
            //                 $kelas.trigger('change.select2');
            //             }
            //         }
            //     });
            // }
        </script>
    </x-slot:js>
</x-layout>