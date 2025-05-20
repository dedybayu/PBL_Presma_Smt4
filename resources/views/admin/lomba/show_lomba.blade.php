@empty($lomba)
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
                <a href="{{ url('/lomba') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div class="modal-header">
        <h5 class="modal-title">Data lomba</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <table class="table table-sm table-bordered table-striped">
            <tr>
                <th class="text-right col-3">Kode lomba :</th>
                <td class="col-9">{{ $lomba->lomba_kode }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">nama lomba :</th>
                <td class="col-9">{{ $lomba->lomba_nama }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">tingkat lomba :</th>
                <td class="col-9">{{ $lomba->tingkat->tingkat_lomba_nama }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">bidang lomba :</th>
                <td class="col-9">{{ $lomba->bidang->bidang_keahlian_nama }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">penyelanggara lomba :</th>
                <td class="col-9">{{ $lomba->penyelenggara->penyelenggara_nama }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">tanggal mulai  :</th>
                <td class="col-9">{{ $lomba->tanggal_mulai }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">tanggal selesai :</th>
                <td class="col-9">{{ $lomba->tanggal_selesai }}</td>
            </tr>
        </table>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
        </div>
@endempty
