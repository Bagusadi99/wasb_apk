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
                <h3 style="color: #4A8939">Jadwal Shift</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Shift</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal"
                                                data-bs-target="#addModal">
                                                <i class="bi bi-plus-circle"></i> Tambah Shift
                                            </button>
                                        </div>
                                        <table class="table table-striped table-responsive" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Shift</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forEach ($shifts as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->shift_nama ?? 'Tidak ada shift' }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                                                                onclick="loadDataShift('{{ $item->shift_id }}', '{{ $item->shift_nama }}')">
                                                                <i class="bi bi-pencil-fill"></i> Edit
                                                            </button>
                                                            <a class="btn btn-sm btn-danger">
                                                                <i class="bi bi-trash-fill"></i> Hapus
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforEach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Modal Tambah Shift -->
                                    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Tambah Shift</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="text-start">Shift:</h6>
                                                    <div class="form-group">
                                                        <input type="text" name="nama_shift" class="form-control" placeholder="Nama Shift">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success ms-1">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit Shift -->
                                    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editModalLabel">Edit Shift</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="text-start">Shift:</h6>
                                                    <div class="form-group">
                                                        <input type="text" id="edit_shift_nama" name="shift_nama" class="form-control" placeholder="Shift">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning ms-1">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

    <script>
        function loadDataShift(shiftId, shiftNama) {
            // Isi data ke dalam modal edit
            document.getElementById('edit_shift_nama').value = shiftNama;

            // Update form action URL dengan ID yang benar (jika diperlukan)
            // document.querySelector('#editModal form').action = document.querySelector('#editModal form').action.replace('__ID__', shiftId);
        }
    </script>
</body>

</html> 