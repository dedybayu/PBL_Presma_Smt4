<x-layout>
    <x-slot:css>
        <style>
            .table-blue-striped tbody tr:nth-of-type(odd) {
                background-color: #007bff27;
            }

            .table-blue-striped tbody tr:nth-of-type(even) {
                background-color: #00ffd510;
            }
        </style>
    </x-slot:css>

    <x-slot:title>
        Detail Lomba: {{ $lomba->lomba_nama }}
    </x-slot:title>

    @php
        $bgColor = match ($lomba->status_verifikasi) {
            '1' => 'rgba(0, 255, 85, 0.144)', // Hijau
            '0' => 'rgba(255, 0, 0, 0.144)', // Merah
            default => 'rgba(255, 251, 0, 0.144)', // Kuning
        };
    @endphp

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title"><i class="fa fa-trophy"></i> {{ $lomba->lomba_nama }}</h3>
        </div>

        <div class="card-body">
            <table class="table table-sm table-bordered table-blue-striped">
                <tr>
                    <th class="text-right col-3">Kode Lomba:</th>
                    <td class="col-9">{{ $lomba->lomba_kode ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Nama Lomba:</th>
                    <td class="col-9">{{ $lomba->lomba_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Deskripsi:</th>
                    <td class="col-9">{{ $lomba->lomba_deskripsi ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Tanggal Mulai:</th>
                    <td class="col-9">{{ $lomba->tanggal_mulai ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Tanggal Selesai:</th>
                    <td class="col-9">{{ $lomba->tanggal_selesai ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Link Website:</th>
                    <td class="col-9">
                        @if ($lomba->link_website)
                            <a href="{{ $lomba->link_website }}" target="_blank">{{ $lomba->link_website }}</a>
                        @else
                            -
                        @endif
                    </td>
                </tr>
                <tr>
                    <th class="text-right col-3">Penyelenggara:</th>
                    <td class="col-9">{{ $lomba->penyelenggara->penyelenggara_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Tingkat Lomba:</th>
                    <td class="col-9">{{ $lomba->tingkat->tingkat_lomba_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Bidang Keahlian:</th>
                    <td class="col-9">{{ $lomba->bidang->bidang_keahlian_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Status Verifikasi:</th>
                    <td class="col-9">
                        @if ($lomba->status_verifikasi === 1)
                            <span class="badge bg-success">Terverifikasi</span>
                        @elseif ($lomba->status_verifikasi === 0)
                            <span class="badge bg-danger">Ditolak</span>
                        @else
                            <span class="badge bg-warning">Menunggu Verifikasi</span>
                        @endif
                    </td>
                </tr>
            </table>

            {{-- Preview Pamflet --}}
            <div class="mt-4">
                <h5>Pamflet Lomba</h5>
                @if ($lomba->foto_pamflet && file_exists(public_path('storage/' . $lomba->foto_pamflet)))
                    <img src="{{ asset('storage/' . $lomba->foto_pamflet) }}" alt="Pamflet Lomba"
                        style="max-width: 100%; height: auto; border: 1px solid #ccc; padding: 4px; border-radius: 8px;">
                @else
                    <p class="text-muted">Pamflet tidak tersedia</p>
                @endif
            </div>

            @if (auth()->user()->user_id == $lomba->user_id)
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('daftar_lomba.index') }}" class="btn btn-primary"><i
                            class="fa fa-arrow-left"></i> Kembali</a>
                    <div>
                        <a href="{{ route('daftar_lomba.edit', $lomba->lomba_id) }}" class="btn btn-success"><i
                                class="fa fa-edit"></i> Edit</a>
                        <button onclick="modalDelete('{{ route('daftar_lomba.confirm', $lomba->lomba_id) }}')"
                            class="btn btn-danger"><i class="fa fa-trash"></i> Hapus</button>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <x-slot:modal>
        <div id="modal-delete" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-xs" role="document">
                <div class="modal-content"></div>
            </div>
        </div>
    </x-slot:modal>

    <x-slot:js>
        <script>
            function modalDelete(url) {
                $("#modal-delete .modal-content").html("");
                $.get(url, function(response) {
                    $("#modal-delete .modal-content").html(response);
                    $("#modal-delete").modal("show");
                });
            }

            $('#modal-delete').on('hidden.bs.modal', function() {
                $("#modal-delete .modal-content").html("");
            });
        </script>
    </x-slot:js>
</x-layout>
