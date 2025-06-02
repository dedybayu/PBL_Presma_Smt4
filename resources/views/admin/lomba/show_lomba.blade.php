@empty($lomba)
    {{-- This section is for when $lomba is empty (data not found) --}}
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
            {{-- For the 'not found' case, the footer with a close button might not be strictly necessary if 'Kembali' sends them away --}}
            {{-- But if you want a close button here too, you'd add: --}}
            {{-- <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
            </div> --}}
        </div>
    </div>
@else
    {{-- This section is for when $lomba is NOT empty (data found) --}}
    <div class="modal-header">
        <h5 class="modal-title">Data lomba</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body" style="max-height: 70vh; overflow-y: auto;"> 
        <div class="row">
            <div class="col-md-12 mt-2">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Foto Pamflet</h5>
                        <div
                            style="position: relative; width: 100%; max-width: 100%; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                            <a href="{{ asset('storage/' . $lomba->foto_pamflet) }}" target="_blank">
                                <img id="preview-pamflet" src="{{ asset('storage/' . $lomba->foto_pamflet) }}"
                                    alt="Pamflet"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <th class="text-right col-3">deskripsi lomba :</th>
                <td class="col-9">{{ $lomba->lomba_deskripsi }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">Link Website terkait :</th>
                <td class="col-9">{{ $lomba->link_website }}</td>
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
                <th class="text-right col-3">tanggal mulai :</th>
                <td class="col-9">{{ $lomba->tanggal_mulai }}</td>
            </tr>
            <tr>
                <th class="text-right col-3">tanggal selesai :</th>
                <td class="col-9">{{ $lomba->tanggal_selesai }}</td>
            </tr>
        </table>
    </div> {{-- End of modal-body --}}

    {{-- The modal-footer should be directly inside modal-content, after modal-body --}}
    <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary btn-sm">Close</button>
    </div>
@endempty