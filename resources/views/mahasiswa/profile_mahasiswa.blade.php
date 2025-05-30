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
        Profil
        <div class="page-title-subheading">Profil Mahasiswa</div>
    </x-slot:title>

    <div class="mb-3 card">
        <div class="card-header card-header-tab-animation">
            <ul class="nav nav-justified">
                <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-0" class="active nav-link"
                        style="font-weight: bold;">Profile</a></li>
                <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-1" class="nav-link"
                        style="font-weight: bold;">Keahlian</a></li>
                <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-2" class="nav-link"
                        style="font-weight: bold;">Minat</a></li>
                <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-3" class="nav-link"
                        style="font-weight: bold;">Organisasi</a></li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content">
                <div class="tab-pane active" id="tab-eg115-0" role="tabpanel">
                    <div class="tab-profile ">
                        <h1>Iki Profil</h1>

                        <div class="d-flex justify-content-end">
                            <button class="btn btn-success" onclick="editProfile()"><i class="fa fa-edit"></i> Edit</button>
                        </div>
                    </div>

                </div>
                <div class="tab-keahlian tab-pane" id="tab-eg115-1" role="tabpanel">
                    <p>Like Aldus PageMaker including versions of Lorem. It has survived not only five centuries, but
                        also the leap into electronic typesetting, remaining
                        essentially unchanged. </p>
                </div>
                <div class="tab-minat tab-pane" id="tab-eg115-2" role="tabpanel">
                    <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown
                        printer took a galley of type and scrambled it to make a
                        type specimen book. It has
                        survived not only five centuries, but also the leap into electronic typesetting, remaining
                        essentially unchanged. </p>
                </div>
                <div class="tab-organisasi tab-pane" id="tab-eg115-3" role="tabpanel">
                    <p>Lorem Ipsum has been sdv tyjthe industry's standard dummy text ever since the 1500s, when an
                        unknown
                        printer took a galley of type and scrambled it to make a
                        type specimen book. It has
                        survived not only five centuries, but also the leap into electronic typesetting, remaining
                        essentially unchanged. </p>
                </div>
            </div>
        </div>
    </div>

    <x-slot:modal>
        <div id="modal-delete" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static"
            data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-xs" role="document">
                <div class="modal-content"></div>
            </div>
        </div>
    </x-slot:modal>

    <template id="template-edit-profile">
        <h1>Edit Profile</h1>

        <div class="d-flex justify-content-between">
        <button class="btn btn-warning" onclick="cancelEditProfile()">Batal</button>
        <button class="btn btn-success" onclick><i class="fa fa-save"></i> Simpan</button>
        </div>
    </template>


    <x-slot:js>
        <script>
            // Simpan isi awal .tab-profile
            let originalProfileContent;

            // Simpan isi awal saat halaman pertama kali dimuat
            window.addEventListener('DOMContentLoaded', () => {
                const container = document.querySelector('.tab-profile');
                originalProfileContent = container.innerHTML;
            });

            function editProfile() {
                const template = document.getElementById('template-edit-profile');
                const clone = document.importNode(template.content, true);
                const container = document.querySelector('.tab-profile');

                // Hapus isi lama
                container.innerHTML = '';
                container.appendChild(clone);
            }

            function cancelEditProfile() {
                const container = document.querySelector('.tab-profile');
                container.innerHTML = originalProfileContent;
            }

            function modalDelete(url) {
                // Kosongkan modal sebelum memuat konten baru
                $("#modal-delete .modal-content").html("");

                // Panggil modal melalui AJAX
                $.get(url, function(response) {
                    $("#modal-delete .modal-content").html(response);
                    $("#modal-delete").modal("show");
                });
            }

            // Bersihkan isi modal setelah ditutup
            $('#modal-delete').on('hidden.bs.modal', function() {
                $("#modal-delete .modal-content").html("");
            });

            var dataPrestasi
            $(document).ready(function() {
                $('#tingkat_lomba_id, #status_verifikasi').select2({
                    theme: 'bootstrap-5',
                    placeholder: "- Semua -",
                    allowClear: true,
                    width: '100%' // Gunakan width penuh
                });

                $('#tingkat_lomba_id, #status_verifikasi').on('change', function() {
                    $(this).closest('form').submit();
                });
            });
        </script>
    </x-slot:js>
</x-layout>
