<x-layout>
    <x-slot:css>
    </x-slot:css>
    <x-slot:title>
        Daftar Mahasiswa
    </x-slot:title>

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Mahasiswa</h3>
        </div>

        <div class="card-body">
            <!-- Filter Section -->
            <div class="form-horizontal filter-date p-3 border-bottom mb-4">
                <div class="row align-items-center">
                    <!-- Filter Dropdown -->
                    <div class="col-auto">
                        <div class="input-group input-group-sm">
                            <label class="input-group-text bg-light border-end-0 rounded-start" for="filter_kelas">
                                <i class="fa fa-filter text-muted"></i>
                            </label>
                            <select name="filter_kelas" id="filter_kelas" class="form-select form-select-sm filter_kelas border-start-0" style="min-width: 150px">
                                <option value="">- Semua -</option>
                                <option value="TI">Kelas TI</option>
                                <option value="SIB">Kelas SIB</option>
                            </select>
                        </div>
                    </div>

                    <!-- Search Box -->
                    <div class="col-auto">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-end-0 rounded-start">
                                <i class="fa fa-search text-muted"></i>
                            </span>
                            <input type="text" class="form-control border-start-0" id="search-mahasiswa" placeholder="Search">
                        </div>
                    </div>

                    <!-- Reset Button -->
                    <div class="col-auto">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="reset-filter">
                            <i class="fa fa-undo"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mahasiswa Table -->
            <table class="table table-bordered table-sm table-striped table-hover" id="table-mahasiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Info</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mahasiswa as $index => $m)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->nama }}</td>
                            <td>{{ $m->kelas->kelas_nama ?? '-' }}</td>
                            <td>
                                <div><i class="fa fa-envelope"></i> {{ $m->email }}</div>
                                <div><i class="fa fa-phone"></i> {{ $m->no_tlp }}</div>
                            </td>
                            <td>{{ $m->alamat ?? '-' }}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-pen"></i>
                                </button>
                                <button class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Section -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" data-backdrop="false" data-keyboard="false" data-width="75%">
    </div>

    <x-slot:js>
        <script>
            // Inisialisasi tooltip (Bootstrap)
            $(document).ready(function(){
                $('[data-bs-toggle="tooltip"]').tooltip();
            });

            // Function to handle modal loading
            function modalAction(url = '') {
                $('#myModal').load(url, function () {
                    $('#myModal').modal('show');
                });
            }

            // Filter by class
            $('.filter_kelas').on('change', function () {
                var selectedKelas = $(this).val().toLowerCase();
                $('#table-mahasiswa tbody tr').each(function () {
                    var kelasText = $(this).find('td:nth-child(4)').text().toLowerCase();
                    $(this).toggle(selectedKelas === "" || kelasText.includes(selectedKelas));
                });
            });

            // Search filter for mahasiswa
            $('#search-mahasiswa').on('keyup', function () {
                var value = $(this).val().toLowerCase();
                $('#table-mahasiswa tbody tr').filter(function () {
                    $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            });

            // Reset filter dan pencarian
            $('#reset-filter').on('click', function () {
                $('.filter_kelas').val('');
                $('#search-mahasiswa').val('');
                $('#table-mahasiswa tbody tr').show();
            });
        </script>
    </x-slot:js>
</x-layout>