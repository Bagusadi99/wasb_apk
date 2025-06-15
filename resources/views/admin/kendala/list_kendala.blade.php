<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WASB - Pengawasan Kebersihan</title>
    <link rel="shortcut icon" href="{{ asset('template/dist/assets/compiled/png/logotransjatim.png') }}"
        type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/table-datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Add any custom styles here */
    </style>
</head>

<body style="background-color: #d5edd2;">
    <script src="{{ asset('template/dist/assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('admin.sidebaradmin')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3" style="color: #4A8939;"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3 style="color: #4A8939">Kendala Halte dan Pool</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">

                    <div class="form-group mb-4">
                        <h6 for="pilihKendala" class="form-label">Pilih Jenis Kendala:</h6>
                        <select class="choices form-select" id="pilihKendala" onchange="tampilkanTabel()">
                            <option value="" disabled selected>Jenis Kendala</option>
                            <option value="pool">Kendala Pool</option>
                            <option value="halte">Kendala Halte</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-12" id="tabelPool" style="display: none;">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Kendala Pool</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal"
                                                data-bs-target="#addModalPool">
                                                <i class="bi bi-plus-circle"></i> Tambah Kendala
                                            </button>
                                        </div>
                                        <table class="table table-striped table-responsive data-table" id="tablepool">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Kendala</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kendala_pool as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->kendala_pool ?? 'Tidak ada kendala' }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                            data-bs-target="#editModal"
                                                            onclick="populateEditModal('pool', '{{ $item->kendala_pool_id }}', '{{ $item->kendala_pool }}')">
                                                            <i class="bi bi-pencil-fill"></i> Edit
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal"
                                                            onclick="populateDeleteModal('pool', '{{ $item->kendala_pool_id }}', '{{ $item->kendala_pool }}')">
                                                            <i class="bi bi-trash-fill"></i> Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" id="tabelHalte" style="display: none;">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Kendala Halte</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal"
                                                data-bs-target="#addModalHalte">
                                                <i class="bi bi-plus-circle"></i> Tambah Kendala
                                            </button>
                                        </div>
                                        <table class="table table-striped table-responsive data-table" id="tablehalte">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Kendala</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($kendala_halte as $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->kendala_halte ?? 'Tidak ada kendala' }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                            data-bs-target="#editModal"
                                                            onclick="populateEditModal('halte', '{{ $item->kendala_halte_id }}', '{{ $item->kendala_halte }}')">
                                                            <i class="bi bi-pencil-fill"></i> Edit
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal"
                                                            data-bs-target="#deleteModal"
                                                            onclick="populateDeleteModal('halte', '{{ $item->kendala_halte_id }}', '{{ $item->kendala_halte }}')">
                                                            <i class="bi bi-trash-fill"></i> Hapus
                                                        </button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Tambah Pool --}}
                    <div class="modal fade" id="addModalPool" tabindex="-1" role="dialog" aria-labelledby="addModalPoolLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form action="{{ route('kendala.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tipe" value="pool">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addModalPoolLabel">Tambah Kendala Pool</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label>Nama Kendala:</label>
                                        <input type="text" name="kendala_pool" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Tambah Halte --}}
                    <div class="modal fade" id="addModalHalte" tabindex="-1" role="dialog" aria-labelledby="addModalHalteLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form action="{{ route('kendala.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tipe" value="halte">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addModalHalteLabel">Tambah Kendala Halte</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label>Nama Kendala:</label>
                                        <input type="text" name="kendala_halte" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Universal Edit Modal --}}
                    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form id="universalEditForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tipe" id="edit_tipe">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editModalLabel">Edit Kendala</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <label>Nama Kendala:</label>
                                        <input type="text" id="edit_kendala_nama" name="nama_kendala" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Universal Delete Modal --}}
                    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form id="universalDeleteForm" action="" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="hidden" name="tipe" id="delete_tipe">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Hapus Kendala</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Apakah Anda yakin ingin menghapus kendala <strong id="delete_kendala_nama"></strong>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger ms-1">Hapus</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-end">
                        <p>&copy; {{ date('Y') }} Trans Jawa Timur</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace(); // Initialize Feather Icons
    </script>


    <script>
        // Initialize DataTables
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize Simple DataTables for both tables
            if (document.getElementById('tablepool')) {
                new simpleDatatables.DataTable(document.getElementById('tablepool'));
            }
            if (document.getElementById('tablehalte')) {
                new simpleDatatables.DataTable(document.getElementById('tablehalte'));
            }
        });

        function tampilkanTabel() {
            var pilihan = document.getElementById("pilihKendala").value;
            document.getElementById("tabelPool").style.display = (pilihan === "pool") ? "block" : "none";
            document.getElementById("tabelHalte").style.display = (pilihan === "halte") ? "block" : "none";
        }

        // Universal function to populate Edit Modal
        function populateEditModal(type, id, name) {
            document.getElementById('editModalLabel').innerText = `Edit Kendala ${type === 'pool' ? 'Pool' : 'Halte'}`;
            document.getElementById('edit_tipe').value = type;
            document.getElementById('edit_kendala_nama').value = name;
            document.getElementById('universalEditForm').action = `/kendala/${id}`;
            // Optional: If you have different input fields for pool/halte, you'd hide/show them here.
            // For now, assuming 'kendala_nama' is universal.
        }

        // Universal function to populate Delete Modal
        function populateDeleteModal(type, id, name) {
            document.getElementById('deleteModalLabel').innerText = `Hapus Kendala ${type === 'pool' ? 'Pool' : 'Halte'}`;
            document.getElementById('delete_tipe').value = type;
            document.getElementById('delete_kendala_nama').innerText = name;
            document.getElementById('universalDeleteForm').action = `/kendala/${id}`;
        }
    </script>

    {{-- Sweet Alert --}}
    @if(session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session("success") }}',
                showConfirmButton: false,
                timer: 2000
            });
        </script>
    @endif

    @if($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                showConfirmButton: true
            });
        </script>
    @endif
</body>

</html>