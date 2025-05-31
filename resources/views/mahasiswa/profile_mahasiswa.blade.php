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

                        {{-- PROFILE --}}
                        <div class="bg-light" style="height: 250px; overflow: hidden;">
                            <img src="{{ asset('assets/images/gdungjti2.png') }}" class="w-100 h-100 object-fit-cover"
                                style="object-fit: cover;">
                        </div>

                        <div class="text-center mt-n5">
                            <img src="{{ asset(auth()->user()->mahasiswa->foto_profile ? 'storage/' . auth()->user()->mahasiswa->foto_profile : 'assets/images/user.png') }}"
                                class="rounded-circle border border-primary shadow bg-white"
                                style="width: 150px; height: 150px; object-fit: cover;">
                            <div class="d-flex justify-content-center align-items-center mt-2">
                                <h4 class="mb-0 me-2">{{ auth()->user()->mahasiswa->nama }}</h4>
                            </div>
                            <p class="text-muted mt-2">{{ auth()->user()->mahasiswa->nim }}</p>
                            <span class="badge bg-info text-dark mb-3">Mahasiswa</span>
                        </div>

                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Nama Mahasiswa</label>
                                    <div type="text" class="form-control" style="background-color: #e9ecef">
                                        {{ auth()->user()->mahasiswa->nama }}</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">NIM Mahasiswa</label>
                                    <div type="text" class="form-control" style="background-color: #e9ecef">
                                        {{ auth()->user()->mahasiswa->nim }}</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Username</label>
                                    <div type="text" class="form-control" style="background-color: #e9ecef">
                                        {{ auth()->user()->username }}</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Email</label>
                                    <div type="text" class="form-control" style="background-color: #e9ecef">
                                        {{ auth()->user()->mahasiswa->email }}</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Kelas</label>
                                    <div type="text" class="form-control" style="background-color: #e9ecef">
                                        {{ auth()->user()->mahasiswa->kelas->kelas_nama }}</div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Angkatan</label>
                                    <div type="text" class="form-control" style="background-color: #e9ecef">
                                        {{ auth()->user()->mahasiswa->tahun_angkatan }}</div>
                                </div>
                                <div class="mb-3 col-md-12">
                                    <label class="form-label">Alamat</label>
                                    <div type="text" class="form-control" style="background-color: #e9ecef">
                                        {{ auth()->user()->mahasiswa->alamat }}</div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success" onclick="editProfile()"><i class="fa fa-edit"></i>
                                    Edit</button>
                            </div>

                        </div>
                        {{-- /PROFILE --}}

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
