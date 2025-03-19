<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WASB - Pengawasan Kebersihan</title>
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
                <h3 style="color: #4A8939">Pengawas</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">List Pengawas</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal"
                                                data-bs-target="#addModal">
                                                <i class="bi bi-plus-circle"></i> Tambah Pengawas
                                            </button>
                                        </div>
                                        <table class="table table-striped table-responsive" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama</th>
                                                    <th>Shift</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pekerja as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td>{{ $item->nama_pekerja }}</td>
                                                        <td>{{ $item->shift->shift_nama ?? 'Tidak ada shift' }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-warning mb-1 mt-1" data-bs-toggle="modal" data-bs-target="#editModal" 
                                                                onclick="loadDataPengawas('{{ $item->pekerja_id }}', '{{ $item->nama_pekerja }}', '{{ $item->shift->shift_nama ?? 'Tidak ada shift' }}')">
                                                                <i class="bi bi-pencil-fill"></i> Edit
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                                onclick="setDeleteData('{{ $item->pekerja_id }}', '{{ $item->nama_pekerja }}')">
                                                                <i class="bi bi-trash-fill"></i> Hapus
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Modal Tambah Pengawas -->
                                    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable, role="document">
                                            <div class="modal-content">
                                                @csrf
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="addModalLabel">Tambah Pengawas</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="text-start">Nama Pengawas:</h6>
                                                    <div class="form-group">
                                                        <input type="text" name="nama_pengawas" class="form-control" placeholder="Nama Pengawas">
                                                    </div>
                                                    <h6 class="text-start">Shift:</h6>
                                                    <div class="form-group">
                                                        <input type="text" name="shift" class="form-control" placeholder="Shift">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-success ms-1">Simpan</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit Pengawas -->
                                    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title", id="editModalLabel">Edit Pengawas</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <h6 class="text-start">Nama Pengawas:</h6>
                                                    <div class="form-group">
                                                        <input type="text" id="edit_nama_pengawas" name="nama_pengawas" class="form-control" placeholder="Nama Pengawas">
                                                    </div>
                                                    <h6 class="text-start">Shift:</h6>
                                                    <div class="form-group">
                                                        <input type="text" id="edit_shift" name="shift" class="form-control" placeholder="Shift">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-warning ms-1">Simpan</button>
                                                </div>
                                            
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Hapus Pengawas -->
                                    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                @csrf
                                                @method('DELETE')
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Hapus Pengawas</h5>
                                                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                        <i data-feather="x"></i>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>Apakah Anda yakin ingin menghapus pengawas - <br>
                                                        <strong id="delete_nama_pengawas"></strong>?</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger ms-1">Hapus</button>
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
                        <p>&copy; {{ date('Y') }} Trans Jawa Timur </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>

    {{-- Script untuk mengisi data ke dalam modal --}}
    <script>
        function loadDataPengawas(id, nama, shiftNama) {
            // Isi data ke dalam modal edit
            document.getElementById('edit_nama_pengawas').value = nama;
            document.getElementById('edit_shift').value = shiftNama;
        }

        function setDeleteData(id, nama) {
            // Isi data ke dalam modal hapus
            document.getElementById('delete_nama_pengawas').textContent = nama;  
        }
    </script>
</body>

</html>