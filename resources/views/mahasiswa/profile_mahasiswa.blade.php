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
                        <x-profile.mahasiswa.profile_mahasiswa></x-profile.mahasiswa.profile_mahasiswa>
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
        <x-profile.mahasiswa.edit_profile_mahasiswa></x-profile.mahasiswa.edit_profile_mahasiswa>
    </template>


    <x-slot:js>
        <script>
            function previewImage(event) {
                var reader = new FileReader();
                reader.onload = function() {
                    var output = document.getElementById('profileImage');
                    output.src = reader.result;
                }
                reader.readAsDataURL(event.target.files[0]);
                document.getElementById('remove_picture').value = "0";
            }

            function removeImage() {
                document.getElementById('profileImage').src = '/../assets/images/user.png';
                document.getElementById('foto_profile').value = '';
                document.getElementById('remove_picture').value = "1";
            }

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

                // Dapatkan token dari meta tag
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                // Tambahkan input CSRF baru (jika belum ada atau untuk memastikan fresh)
                const form = document.getElementById('form-edit-profile');
                let csrfInput = form.querySelector('input[name="_token"]');

                if (csrfInput) {
                    csrfInput.value = csrfToken; // Perbarui jika sudah ada
                } else {
                    // Tambahkan jika tidak ada
                    csrfInput = document.createElement('input');
                    csrfInput.setAttribute('type', 'hidden');
                    csrfInput.setAttribute('name', '_token');
                    csrfInput.setAttribute('value', csrfToken);
                    form.prepend(csrfInput);
                }
            }


            function cancelEditProfile() {
                const container = document.querySelector('.tab-profile');
                container.innerHTML = originalProfileContent;
            }

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

            $(document).ready(function() {
                // Cek jika ada hash di URL (misal: #tab-eg115-0)
                var hash = window.location.hash;
                if (hash) {
                    $('.nav a[href="' + hash + '"]').tab('show');
                }

                // Optional: update hash saat tab diklik
                $('.nav a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
                    history.replaceState(null, null, $(e.target).attr('href'));
                });
            });
        </script>
    </x-slot:js>
</x-layout>
