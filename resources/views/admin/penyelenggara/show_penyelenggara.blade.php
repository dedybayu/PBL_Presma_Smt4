@empty($penyelenggara)
    <div id="modal-delete" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5>
                    Data yang anda cari tidak ditemukan
                </div>
                <a href="{{ url('/penyelenggara') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div class="modal-header">
        <h5 class="modal-title">Detail Penyelenggara</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <table class="table table-sm table-bordered table-striped">
            <tr>
                <th class="text-right col-4">Nama Penyelenggara :</th>
                <td class="col-8">{{ $penyelenggara->penyelenggara_nama }}</td>
            </tr>
            <tr>
                <th class="text-right col-4">Kota :</th>
                <td class="col-8">{{ $penyelenggara->kota->kota_nama ?? '-' }}</td>
            </tr>
            <tr>
                <th class="text-right col-4">Negara :</th>
                <td class="col-8">{{ $penyelenggara->negara->negara_nama ?? '-' }}</td>
            </tr>
        </table>
        <div class="modal-footer">
            <button onclick="modalAction('{{ url('/penyelenggara/' . $penyelenggara->penyelenggara_id . '/edit') }}')" class="btn btn-success btn-sm">Edit</button>
            <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
        </div>
    </div>
@endempty