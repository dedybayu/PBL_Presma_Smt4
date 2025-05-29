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
        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('lomba.index') }}" class="mb-3">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group row">
                            <div class="col-12 col-md-6 mb-2 mb-md-0">
                                <select class="form-select" id="tingkat_lomba_id" name="tingkat_lomba_id" style="width: 100%">
                                    <option value="">- Semua Tingkat -</option>
                                    @foreach($tingkat_lomba as $item)
                                        <option value="{{ $item->tingkat_lomba_id }}" {{ request('tingkat_lomba_id') == $item->tingkat_lomba_id ? 'selected' : '' }}>
                                            {{ $item->tingkat_lomba_nama }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Filter Tingkat Lomba</small>
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
                            <input type="text" name="search" class="form-control" placeholder="Cari nama lomba atau penyelenggara..." value="{{ request('search') }}">
                            <button class="btn btn-primary ml-1" type="submit">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <hr>

            <div class="row mt-4">
                @if($lomba->count())
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
                                        <div style="position: relative; width: 100%; height: 100%; aspect-ratio: 1 / 1; border-radius: 16px 0 0 16px; overflow: hidden;">
                                            @if($lmb->foto_poster)
                                                <img src="{{ asset('storage/' . $lmb->foto_poster) }}" alt="Poster Lomba"
                                                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                            @else
                                                <img src="{{ asset('images/default-lomba.jpg') }}" alt="Poster Default"
                                                     style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-7">
                                        <div class="card-body d-flex flex-column">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <p class="card-text mb-0">
                                                    <small class="text-muted">
                                                        {{ \Carbon\Carbon::parse($lmb->tanggal_selesai)->locale('id')->isoFormat('LL') }}
                                                    </small>
                                                </p>
                                            </div>

                                            <a href="{{ route('lomba.show', $lmb->lomba_id) }}">
                                                <h5 class="card-title">{{ $lmb->lomba_nama }}</h5>
                                            </a>

                                            <table class="mb-0" style="font-size: 14px;">
                                                <tr>
                                                    <th style="padding: 4px 8px;">Tingkat</th>
                                                    <td style="padding: 4px 4px;">:</td>
                                                    <td style="padding: 4px 8px;">{{ $lmb->tingkat->tingkat_lomba_nama }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px 8px;">Bidang</th>
                                                    <td style="padding: 4px 4px;">:</td>
                                                    <td style="padding: 4px 8px;">{{ $lmb->bidang->bidang_nama ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th style="padding: 4px 8px;">Penyelenggara</th>
                                                    <td style="padding: 4px 4px;">:</td>
                                                    <td style="padding: 4px 8px;">{{ $lmb->penyelenggara->penyelenggara_nama }}</td>
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
    </x-slot:modal>

    <x-slot:js>
        <script>
            $(document).ready(function () {
                $('#tingkat_lomba_id').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua Tingkat -",
                    allowClear: true,
                    width: '100%'
                });

                $('#tingkat_lomba_id').on('change', function () {
                    $(this).closest('form').submit();
                });
            });

            var dataLomba
            $(document).ready(function () {
                $('#tingkat_lomba_id, #status_verifikasi').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua -",
                    allowClear: true,
                    width: '100%' // Gunakan width penuh
                });

                $('#tingkat_lomba_id, #status_verifikasi').on('change', function () {
                    $(this).closest('form').submit();
                });
            });
        </script>
    </x-slot:js>

</x-layout>
