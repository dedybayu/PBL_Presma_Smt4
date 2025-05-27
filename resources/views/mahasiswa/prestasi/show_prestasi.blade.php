<x-layout>
    <x-slot:css>
        <style>
            .table-blue-striped tbody tr:nth-of-type(odd) {
                background-color: #007bff27;
                /* Warna biru muda */
            }

            .table-blue-striped tbody tr:nth-of-type(even) {
                background-color: #00ffd510;
                /* Warna biru muda */
            }
        </style>
    </x-slot:css>

    <x-slot:title>
        Prestasi: {{$prestasi->prestasi_nama}}
    </x-slot:title>

    @php
        if ($prestasi->status_verifikasi == '1') {
            $bgColor = 'rgba(0, 255, 85, 0.144)'; // Hijau
        } elseif ($prestasi->status_verifikasi == '0') {
            $bgColor = 'rgba(255, 0, 0, 0.144)'; // Merah
        } else {
            $bgColor = 'rgba(255, 251, 0, 0.144)'; // Kuning
        }
    @endphp

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title"><i class="fa fa-trophy"> {{$prestasi->prestasi_nama}}</i>
            </h3>
        </div>

        <div class="card-body">
            <table class="table table-sm table-bordered table-blue-striped">
                <tr>
                    <th class="text-right col-3">NIM :</th>
                    <td class="col-9">{{ $prestasi->mahasiswa->nim }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Mahasiswa :</th>
                    <td class="col-9">{{ $prestasi->mahasiswa->nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Prestasi :</th>
                    <td class="col-9">{{ $prestasi->prestasi_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Lomba :</th>
                    <td class="col-9">{{ $prestasi->lomba->lomba_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Penyelenggara :</th>
                    <td class="col-9">{{ $prestasi->lomba->penyelenggara->penyelenggara_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Juara :</th>
                    <td class="col-9">{{ $prestasi->nama_juara ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Tingkat :</th>
                    <td class="col-9">{{ $prestasi->lomba->tingkat->tingkat_lomba_nama ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Poin :</th>
                    <td class="col-9">{{ $prestasi->poin ?? '-' }}</td>
                </tr>
                <tr>
                    <th class="text-right col-3">Status Verifikasi :</th>
                    <td class="col-9 align-middle">
                        @if ($prestasi->status_verifikasi === 1)
                            <span class="badge bg-success mt-1 mb-1 text-white">Terverifikasi</span>
                        @elseif ($prestasi->status_verifikasi === 0)
                            <span class="badge bg-danger mt-1 mb-1 text-white">Ditolak</span>
                        @else
                            <span class="badge bg-warning mt-1 mb-1 text-white">Menunggu Verifikasi</span>
                        @endif
                    </td>
                </tr>
            </table>
            <div class="row">
                <div class="col-md-6 mb-2">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Sertifikat</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img src="{{ asset('storage/' . $prestasi->file_sertifikat) }}" alt="Sertifikat"
                                    class="img-click-preview"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block; cursor: pointer;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Bukti Foto</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img id="preview-sertifikat" src="{{ asset('storage/' . $prestasi->file_bukti_foto) }}"
                                    alt="Bukti Foto" class="img-click-preview"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Surat Tugas</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img id="preview-sertifikat" src="{{ asset('storage/' . $prestasi->file_surat_tugas) }}"
                                    alt="Surat Tugas" class="img-click-preview"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-2">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Surat Undangan</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img id="preview-sertifikat" class="img-click-preview"
                                    src="{{ asset('storage/' . $prestasi->file_surat_undangan) }}" alt="Surat Undangan"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">File Proposal</h5>
                            <div style="position: relative; width: 100%; height: 500px; border: 1px solid #ccc;">
                                <iframe id="preview-proposal"
                                    src="{{ $prestasi->file_proposal ? asset('storage/' . $prestasi->file_proposal) : '' }}"
                                    width="100%" height="100%" style="border: none;"></iframe>

                                @if (!$prestasi->file_proposal)
                                    <div
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.85);">
                                        <p id="no-proposal" style="color: #666; font-size: 18px;">Tidak ada proposal</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 mb-2">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pesan Dari Admin</h5>
                            <div class="card" style="background-color: {{ $bgColor }}">
                                <div class="card-body">
                                    <p class="card-text mb-0"
                                        style="{{ empty(trim($prestasi->message)) ? 'font-style: italic; color: #6c757d;' : '' }}">
                                        {{ empty(trim($prestasi->message)) ? 'Tidak ada pesan' : $prestasi->message }}
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <x-slot:modal>
            <div class="modal fade" id="modalPreview" tabindex="-1" aria-labelledby="modalPreviewLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-xl ">
                    <div class="modal-content bg-white p-3 rounded-3">
                        <div class="modal-body text-center p-0">
                            <img id="modalPreviewImg" src="" alt="Preview"
                                style="max-width: 100%; max-height: 90vh; object-fit: contain;">
                        </div>
                    </div>
                </div>
            </div>
        </x-slot:modal>



        <x-slot:js>
            <script>
                document.addEventListener('DOMContentLoaded', function () {
                    const previewImgs = document.querySelectorAll('.img-click-preview');
                    const modalImg = document.getElementById('modalPreviewImg');
                    const modal = new bootstrap.Modal(document.getElementById('modalPreview'));

                    previewImgs.forEach(img => {
                        img.addEventListener('click', function () {
                            modalImg.src = this.src;
                            modal.show();
                        });
                    });
                });
            </script>
        </x-slot:js>


</x-layout>