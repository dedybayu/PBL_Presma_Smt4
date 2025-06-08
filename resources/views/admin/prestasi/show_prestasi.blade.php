@empty($prestasi)
    <div id="modal-delete" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/prestasi') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    @php
        if ($prestasi->status_verifikasi == '1') {
            $bgColor = 'rgba(0, 255, 85, 0.144)'; // Hijau
        } elseif ($prestasi->status_verifikasi == '0') {
            $bgColor = 'rgba(255, 0, 0, 0.144)'; // Merah
        } else {
            $bgColor = 'rgba(255, 251, 0, 0.144)'; // Kuning
        }
    @endphp
    <div class="modal-header">
        <h5 class="modal-title">Data prestasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
        <table class="table table-sm table-bordered table-striped">
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
                <td class="col-9">
                    @if ($prestasi->status_verifikasi === 1)
                        Terverifikasi
                    @elseif ($prestasi->status_verifikasi === 0)
                        Ditolak
                    @else
                        Menunggu Verifikasi
                    @endif
                </td>
            </tr>
        </table>

        <div class="row">
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Foto Sertifikat</h5>
                        <!-- Gambar Sertifikat -->
                        <div
                            style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                            <a href="{{ asset('storage/' . $prestasi->file_sertifikat) }}" target="_blank">
                                <img id="preview-sertifikat" src="{{ file_exists(public_path('storage/' . $prestasi->file_sertifikat)) ? asset('storage/' . $prestasi->file_sertifikat) : asset('assets/images/broken-image.png') }}"
                                    alt="Sertifikat"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Bukti Foto</h5>
                        <!-- Gambar Bukti Foto -->
                        <div
                            style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                            <a href="{{ asset('storage/' . $prestasi->file_bukti_foto) }}" target="_blank">
                                <img id="preview-bukti-foto" src="{{ file_exists(public_path('storage/' . $prestasi->file_bukti_foto)) ? asset('storage/' . $prestasi->file_bukti_foto) : asset('assets/images/broken-image.png') }}"
                                    alt="Bukti Foto"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Surat Tugas</h5>
                        <!-- Gambar Surat Tugas -->
                        <div
                            style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                            <a href="{{ asset('storage/' . $prestasi->file_surat_tugas) }}" target="_blank">
                                <img id="preview-surat_tugas" src="{{ file_exists(public_path('storage/' . $prestasi->file_surat_tugas)) ? asset('storage/' . $prestasi->file_surat_tugas) : asset('assets/images/broken-image.png') }}"
                                    alt="surat_tugas"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Surat Undangan</h5>
                        <!-- Gambar Surat Undangan -->
                        <div
                            style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                            <a href="{{ asset('storage/' . $prestasi->file_surat_undangan) }}" target="_blank">
                                <img id="preview-surat_undangan"
                                    src="{{ file_exists(public_path('storage/' . $prestasi->file_surat_undangan)) ? asset('storage/' . $prestasi->file_surat_undangan) : asset('assets/images/broken-image.png') }}" alt="surat_undangan"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">File Proposal</h5>
                        <div style="position: relative; width: 100%; height: 500px; border: 1px solid #ccc;">
                                <iframe id="preview-proposal"
                                    src="{{ $prestasi->file_proposal && file_exists(public_path('storage/' . $prestasi->file_proposal)) ? asset('storage/' . $prestasi->file_proposal) : '' }}"
                                    width="100%" height="100%" style="border: none;"></iframe>

                                @if (!$prestasi->file_proposal)
                                    <div
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.85);">
                                        <p id="no-proposal" style="color: #666; font-size: 18px;">Tidak ada proposal</p>
                                    </div>
                                @endif
                                @if (!file_exists(public_path('storage/' . $prestasi->file_proposal)))
                                    <div
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; background-color: rgba(255, 255, 255, 0.85);">
                                        <p id="no-proposal" style="color: #666; font-size: 18px;">File proposal tidak ditemukan</p>
                                    </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 mt-4">
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
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
    </div>
@endempty