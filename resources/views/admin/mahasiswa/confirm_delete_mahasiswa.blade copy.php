@empty($mahasiswa)
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
                <a href="{{ url('/mahasiswa') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <div class="modal-header">
        <h5 class="modal-title">Data mahasiswa</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="alert alert-warning">
            <h5><i class="icon fas fa-ban"></i> Konfirmasi !!!</h5>
            Apakah Anda ingin menghapus data mahasiswa seperti di bawah ini?
        </div>
        <table class="table table-sm table-bordered table-striped">
            <tr>
                <th class="text-right col-3">Nama mahasiswa :</th>
                <td class="col-9">{{ $mahasiswa->nama }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">Kode mahasiswa :</th>
                <td class="col-9">{{ $mahasiswa->nim }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">Kelas :</th>
                <td class="col-9">{{ $mahasiswa->kelas->kelas_nama }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">no_telp :</th>
                <td class="col-9">{{ $mahasiswa->no_tlp }}</td>
            </tr>
        </table>
        <div class="modal-footer"></div>
        {{-- <form action="{{ url('/mahasiswa/' . $mahasiswa->mahasiswa_id) }}" method="POST" id="form-delete">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
        </form> --}}
        <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
    </div>
@endempty