<x-layout>
    <x-slot:css>
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"
            rel="stylesheet" />
    </x-slot:css>

    <x-slot:title>
        Daftar Lomba
        <div class="page-title-subheading">Semua perlombaan bergengsi menantimu</div>
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title mt-2 mb-2"> Daftar Lomba <i class="fa fa-trophy"></i></h3>
             <div class="btn-actions-pane-right text-capitalize">
                {{-- <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View All</button> --}}
                <button onclick="modalAction('{{ url('/daftar_lomba/create') }}')" class="btn btn-sm btn-success mt-1">
                    <i class="fa fa-plus"></i> Tambah data
                </button>
            </div>
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('daftar_lomba.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                <select class="form-select" id="tingkat_lomba_id" name="tingkat_lomba_id"
                                    style="width: 100%">
                                    <option value="">- Semua Tingkat -</option>
                                    @foreach ($tingkat_lomba as $item)
                                        <option value="{{ $item->tingkat_lomba_id }}"
                                            {{ request('tingkat_lomba_id') == $item->tingkat_lomba_id ? 'selected' : '' }}>
                                            {{ $item->tingkat_lomba_nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Filter Tingkat Lomba</small>
                            </div>
                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                <select class="form-select" id="bidang_keahlian_id" name="bidang_keahlian_id"
                                    style="width: 100%">
                                    <option value="">- Semua Bidang -</option>
                                    @foreach ($bidang_keahlian as $item)
                                        <option value="{{ $item->bidang_keahlian_id }}"
                                            {{ request('bidang_keahlian_id') == $item->bidang_keahlian_id ? 'selected' : '' }}>
                                            {{ $item->bidang_keahlian_nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Filter Bidang Keahlian</small>
                            </div>
                            <div class="col-12 col-md-4 mb-2 mb-md-0">
                                <select class="form-select" id="status_verifikasi" name="status_verifikasi"
                                    style="width: 100%">
                                    <option value="">- Semua -</option>
                                    <option value="1" {{ request('status_verifikasi') == '1' ? 'selected' : '' }}>
                                        Terverifikasi
                                    </option>
                                    <option value="2" {{ request('status_verifikasi') == '2' ? 'selected' : '' }}>
                                        Menunggu
                                    </option>
                                    <option value="0" {{ request('status_verifikasi') == '0' ? 'selected' : '' }}>
                                        Ditolak
                                    </option>
                                </select>
                                <small class="form-text text-muted">Filter Status Verifikasi</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama lomba atau penyelenggara..." value="{{ request('search') }}">
                            <button class="btn btn-primary ml-1" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <hr>

            <div class="row mt-4">
                @if ($lomba->count())
                    @foreach ($lomba as $lmb)
                        @php
                            if ($lmb->status_verifikasi == '1') {
                                $bgColor = 'rgba(0, 255, 85, 0.144)'; // Hijau
                            } elseif ($lmb->status_verifikasi == '0') {
                                $bgColor = 'rgba(255, 0, 0, 0.144)'; // Merah
                            } else {
                                $bgColor = 'rgba(255, 255, 0, 0.144)'; // Kuning
                            }
                        @endphp
                        <div class="col-md-6">
                            <div class="card mb-3" style="border-radius: 16px; background-color: {{ $bgColor }};">
                                <div class="row g-0">
                                    <div class="col-md-5">
                                        <a href="{{ route('daftar_lomba.show', $lmb->lomba_id) }}">
                                            <div
                                                style="position: relative; width: 100%; height: 100%; aspect-ratio: 1 / 1; border-radius: 16px 0 0 16px; overflow: hidden;">
                                                @if ($lmb->foto_pamflet)
                                                    <img src="{{ file_exists(public_path('storage/' . $lmb->foto_pamflet)) ? asset('storage/' . $lmb->foto_pamflet) : asset('assets/images/image-dummy.png') }}"
                                                        alt="Pamflet Lomba" alt="Poster Lomba"
                                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/images/image-dummy.png') }}"
                                                        alt="Poster Default"
                                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                                @endif
                                            </div>
                                        </a>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="card-body d-flex flex-column">
                                            <div
                                                class="d-flex justify-content-between align-items-center mt-auto mb-3 pb-2 border-bottom">
                                                <p class="card-text mb-0">
                                                    <small class="text-body-secondary">
                                                        {{ \Carbon\Carbon::parse($lmb->updated_at)->locale('id')->diffForHumans() }}
                                                    </small>
                                                </p>
                                                @if (auth()->user()->user_id == $lmb->user_id)
                                                    <div class="d-flex">
                                                        <a href="{{ route('daftar_lomba.edit', $lmb->lomba_id) }}"
                                                            class="btn btn-sm btn-warning mr-1"><i
                                                                class="fa fa-edit"></i>
                                                            Edit</a>
                                                        <button
                                                            onclick="modalDelete('{{ route('daftar_lomba.confirm', $lmb->lomba_id) }}')"
                                                            class="btn btn-sm btn-danger ml-1"><i
                                                                class="fa fa-trash"></i>
                                                            Hapus</button>
                                                    </div>
                                                @endif

                                            </div>

                                            <a href="{{ route('daftar_lomba.show', $lmb->lomba_id) }}">
                                                <h5 class="card-title">{{ $lmb->lomba_nama }}</h5>
                                            </a>

                                            <table class="mb-0" style="font-size: 14px;">
                                                <tr>
                                                    <th style="padding: 4px 8px;">Tingkat</th>
                                                    <td style="padding: 4px 4px;">:</td>
                                                    <td style="padding: 4px 8px;">
                                                        {{ $lmb->tingkat->tingkat_lomba_nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px 8px;">Bidang</th>
                                                    <td style="padding: 4px 4px;">:</td>
                                                    <td style="padding: 4px 8px;">
                                                        {{ $lmb->bidang->bidang_keahlian_nama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px 8px;">Penyelenggara</th>
                                                    <td style="padding: 4px 4px;">:</td>
                                                    <td style="padding: 4px 8px;">
                                                        {{ $lmb->penyelenggara->penyelenggara_nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px 8px;">Tanggal Mulai</th>
                                                    <td style="padding: 4px 4px;">:</td>
                                                    <td style="padding: 4px 8px;">
                                                        {{ \Carbon\Carbon::parse($lmb->tanggal_mulai)->locale('id')->translatedFormat('d F Y') }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 text-center mt-4 mb-4">
                        <h5 class="text-muted">Lomba tidak ditemukan.</h5>
                    </div>
                @endif
            </div>
        </div>

        <div class="d-flex justify-content-end mt-4 mr-4">
            {{ $lomba->links() }}
        </div>
    </div>

    <x-slot:modal>
        <div id="modal-lomba" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content"></div>
            </div>
        </div>
    </x-slot:modal>

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

                $('#bidang_keahlian_id, #tingkat_lomba_id, #status_verifikasi').select2({
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
                        { data: "link", className: "", orderable: true, searchable: true },
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
