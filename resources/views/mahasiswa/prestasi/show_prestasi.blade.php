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
        Prestasi: {{$prestasi->prestasi_nama}}
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header-tab card-header">
            <h3 class="card-title"><i class="fa fa-trophy"> {{$prestasi->prestasi_nama}}</i>
            </h3>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Sertifikat</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img id="preview-sertifikat" src="{{ asset('storage/' . $prestasi->file_sertifikat) }}"
                                    alt="Sertifikat"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block; cursor: pointer;"
                                    onclick="showSertifikatModal(this)">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Bukti Foto</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img id="preview-sertifikat" src="{{ asset('storage/' . $prestasi->file_bukti_foto) }}"
                                    alt="Sertifikat"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Surat Tugas</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img id="preview-sertifikat" src="{{ asset('storage/' . $prestasi->file_surat_tugas) }}"
                                    alt="Sertifikat"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Surat Undangan</h5>
                            <div
                                style="position: relative; width: 100%; max-width: 600px; aspect-ratio: 16 / 9; overflow: hidden; background: #eee;">
                                <img id="preview-sertifikat"
                                    src="{{ asset('storage/' . $prestasi->file_surat_undangan) }}" alt="Sertifikat"
                                    style="width: 100%; height: 100%; object-fit: contain; display: block;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <x-slot:modal>
        <!-- Modal -->
        <div class="modal fade" id="modalSertifikat" tabindex="2" aria-labelledby="modalSertifikatLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content bg-transparent border-0">
                    <div class="modal-body text-center p-0">
                        <img id="modalSertifikatImg" src="" alt="Full Sertifikat"
                            style="max-width: 100%; max-height: 90vh;">
                    </div>
                </div>
            </div>
        </div>
    </x-slot:modal>

    <x-slot:js>
        <script>
            function showSertifikatModal(img) {
                const modalImg = document.getElementById('modalSertifikatImg');
                modalImg.src = img.src;

                const modal = new bootstrap.Modal(document.getElementById('modalSertifikat'));
                modal.show();
            }
        </script>

    </x-slot:js>
</x-layout>