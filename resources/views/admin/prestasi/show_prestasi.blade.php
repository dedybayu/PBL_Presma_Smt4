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
    <div class="modal-header">
        <h5 class="modal-title">Data prestasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
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
    </div>
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
    </div>
@endempty