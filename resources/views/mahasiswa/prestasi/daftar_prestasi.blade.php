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
        Daftar prestasi
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title"> Daftar Prestasi <i class="fa fa-trophy"></i>
            </h3>
            <div class="btn-actions-pane-right text-capitalize">
                {{-- <button class="btn-wide btn-outline-2x mr-md-2 btn btn-outline-focus btn-sm">View All</button> --}}
                <button onclick="modalAction('{{ url('/prestasi/create') }}')" class="btn btn-sm btn-success mt-1">
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                @foreach ($prestasi as $pres)
                    @php
                        if ($pres->status_verifikasi == '1') {
                            $bgColor = 'rgba(0, 255, 85, 0.144)'; // Hijau
                        } elseif ($pres->status_verifikasi == '0') {
                            $bgColor = 'rgba(255, 0, 0, 0.144)'; // Merah
                        } else {
                            $bgColor = 'rgba(255, 251, 0, 0.144)'; // Kuning
                        }
                    @endphp
                    <div class="col-md-6">
                        <div class="card mb-3"
                            style="max-width: 100%; border-radius: 16px; background-color: {{ $bgColor }};">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    <div
                                        style="position: relative; width: 100%; height: 100%; aspect-ratio: 1 / 1; border-radius: 16px 0 0 16px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $pres->file_bukti_foto) }}" alt="Foto Prestasi"
                                            style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; object-position: center;">
                                    </div>
                                </div>

                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h5 class="card-title">
                                            {{ \Illuminate\Support\Str::words($pres->prestasi_nama, 5, '...') }}</h5>
                                        <p class="card-text">Lomba: {{$pres->lomba->lomba_nama}}</p>
                                        <p class="card-text">Tingkat: {{$pres->lomba->tingkat->tingkat_lomba_nama}}</p>
                                        <p class="card-text">Penyelenggara:
                                            {{$pres->lomba->penyelenggara->penyelenggara_nama}}
                                        </p>
                                        <p class="card-text"><small class="text-body-secondary">
                                                {{ \Carbon\Carbon::parse($pres->created_at)->locale('id')->diffForHumans() }}
                                            </small>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>




        </div>
    </div>





    <x-slot:js>
        <script>

        </script>
    </x-slot:js>
</x-layout>