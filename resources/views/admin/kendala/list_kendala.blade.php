<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WASB - pengawasan kebersihan</title>
    <link rel="shortcut icon" href="{{ asset('template/dist/assets/compiled/png/logotransjatim.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/iconly.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/table-datatable.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

                    <!-- Dropdown Pilihan -->
                    <div class="form-group mb-4">
                        <h6 for="pilihKendala" class="form-label">Pilih Jenis Kendala:</h6>
                        <select class="form-select" id="pilihKendala" onchange="tampilkanTabel()">
                            <option value="" disabled selected>Jenis Kendala</option>
                            <option value="pool">Kendala Pool</option>
                            <option value="halte">Kendala Halte</option>
                        </select>
                    </div>

                    <div class="row">
                        <!-- Tabel Pool -->
                        <div class="col-md-12" id="tabelPool" style="display: none;">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Kendala Pool</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal" data-bs-target="#addModalPool">
                                                <i class="bi bi-plus-circle"></i> Tambah Kendala
                                            </button>
                                        </div>
                                        <table class="table table-striped table-responsive table1" id="tablepool">
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
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModalPool"
                                                        onclick="loadDataKendala('{{ $item->kendala_pool_id }}', '{{ $item->kendala_pool }}')">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                            <i class="bi bi-trash-fill"></i>
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

                        <!-- Tabel Halte -->
                        <div class="col-md-12" id="tabelHalte" style="display: none;">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Kendala Halte</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal" data-bs-target="#addModalHalte">
                                                <i class="bi bi-plus-circle"></i> Tambah Kendala
                                            </button>
                                        </div>
                                        <table class="table table-striped table-responsive table1" id="tablehalte">
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
                                                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModalHalte"
                                                        onclick="loadDataKendala('{{ $item->kendala_halte_id }}', '{{ $item->kendala_halte }}')">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                                            <i class="bi bi-trash-fill"></i>
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
                    <div class="modal fade" id="addModalPool" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form action="{{ route('kendala.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tipe" value="pool">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Kendala Pool</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal">
                                            <i data-feather="x"></i>
                                        </button>
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
                    <div class="modal fade" id="addModalHalte" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form action="{{ route('kendala.store') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="tipe" value="halte">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Kendala Halte</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal">
                                            <i data-feather="x"></i>
                                        </button>
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

                    {{-- Modal Edit Pool --}}
                    <div class="modal fade" id="editModalPool" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form id="editForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tipe" value="pool">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kendala Pool</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label>Nama Kendala:</label>
                                        <input type="text" id="edit_kendala_pool" name="kendala_pool" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit Halte --}}
                    <div class="modal fade" id="editModalHalte" tabindex="-1" role="dialog">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <form id="editForm" action="" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="tipe" value="halte">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Kendala Pool</h5>
                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal">
                                            <i data-feather="x"></i>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <label>Nama Kendala:</label>
                                        <input type="text" id="edit_kendala_halte" name="kendala_halte" class="form-control" required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-success">Simpan</button>
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
    <script src="{{ asset('template/dist/assets/static/js/pages/simple-datatables.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>

    <!-- Script Kendala Pilihan -->
    <script>
        function tampilkanTabel() {
            var pilihan = document.getElementById("pilihKendala").value;
            document.getElementById("tabelPool").style.display = (pilihan === "pool") ? "block" : "none";
            document.getElementById("tabelHalte").style.display = (pilihan === "halte") ? "block" : "none";
        }

        document.querySelectorAll('.table1').forEach(function (el) {
            new simpleDatatables.DataTable(el);
        })

        function loadDataKendala(id, kendalaPool) {
            // Isi data ke dalam modal edit
            document.getElementById('edit_kendala_pool').value = kendalaPool;
            document.getElementById("editForm").action = "/kendala/" + id;

        }
        function loadDataKendala(id, kendalaHalte) {
            // Isi data ke dalam modal edit
            document.getElementById('edit_kendala_halte').value = kendalaHalte;
            document.getElementById("editForm").action = "/kendala/" + id;

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
