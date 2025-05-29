<x-layout>
    <x-slot:css>
        <!-- Tambahkan CSS tambahan di sini jika dibutuhkan -->
    </x-slot:css>

    <x-slot:title>
        Dashboard Admin
    </x-slot:title>

    <!-- Dashboard Lomba -->
    <h3 class="mb-3">Data Lomba</h3>
    <div class="row">
        <!-- Total Lomba -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-primary">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Lomba</div>
                        <div class="widget-subheading">Jumlah event lomba</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="total-lomba">{{ $totalLomba }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lomba Terverifikasi -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-success">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Terverifikasi</div>
                        <div class="widget-subheading">Lomba disetujui</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="lomba-verifikasi">{{ $lombaVerifikasi }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lomba Pending -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-warning">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Pending</div>
                        <div class="widget-subheading">Menunggu verifikasi</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="lomba-pending">{{ $lombaPending }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lomba Ditolak -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-danger">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Ditolak</div>
                        <div class="widget-subheading">Lomba ditolak</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="lomba-ditolak">{{ $lombaDitolak }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Prestasi -->
    <h3 class="mb-3">Data Prestasi</h3>
    <div class="row">
        <!-- Total Prestasi -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-primary">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Total Prestasi</div>
                        <div class="widget-subheading">Jumlah event Prestasi</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="total-prestasi">{{ $totalPrestasi }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi Terverifikasi -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-success">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Terverifikasi</div>
                        <div class="widget-subheading">Prestasi disetujui</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="prestasi-verifikasi">{{ $prestasiVerifikasi }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi Pending -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-warning">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Pending</div>
                        <div class="widget-subheading">Menunggu verifikasi</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="prestasi-pending">{{ $prestasiPending }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Prestasi Ditolak -->
        <div class="col-md-6 col-xl-3">
            <div class="card mb-3 widget-content bg-danger">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">Ditolak</div>
                        <div class="widget-subheading">Prestasi ditolak</div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white">
                            <span id="prestasi-ditolak">{{ $prestasiDitolak }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Untuk Grafik --}}
    <!-- Grafik Prestasi per Tingkat -->
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card mb-3">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize fw-normal">
                        Grafik Prestasi Berdasarkan Tingkat Lomba
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="grafik-prestasi" height="100"></canvas>
                </div>
            </div>
        </div>
    </div> --}}

    <x-slot:modal>
        <!-- Tambahkan modal di sini -->
    </x-slot:modal>

    <x-slot:js>
       <!-- Tambahkan js di sini -->
    </x-slot:js>
</x-layout>