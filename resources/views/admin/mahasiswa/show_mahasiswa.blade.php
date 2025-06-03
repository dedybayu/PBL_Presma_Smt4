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
                <th class="text-right col-3">No telp :</th>
                <td class="col-9">{{ $mahasiswa->no_tlp }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">IPK :</th>
                <td class="col-9">{{ $mahasiswa->ipk }}</td>
            </tr>
        </table>
        <h5 class="modal-title">Detail prestasi</h5>
        <table class="table table-sm table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Prestasi</th>
                    <th>Tanggal Perolehan Prestasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($mahasiswa->prestasi as $i => $prestasiItem)
                    <tr>
                        <td>{{ $i + 1 }}</td>
                        <td>{{ $prestasiItem->prestasi_nama?? '-' }}</td>
                        <td>{{ $prestasiItem->tanggal_perolehan?? '-' }}</td>
                        <td>
                            <button onclick="modalAction('{{ url('/prestasi/' . $prestasiItem->prestasi_id . '/show') }}')"
                                class="btn btn-info btn-sm mt-1 mb-1"><i class="fa fa-eye"></i>
                                Detail
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
            <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
        </div>
    @endempty
