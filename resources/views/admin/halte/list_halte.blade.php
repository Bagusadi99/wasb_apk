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
                <h3 style="color: #4A8939">Halte/Shalter</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">List Halte/Shalter</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success mb-2 me-2" data-bs-toggle="modal"
                                                data-bs-target="#addModal">
                                                <i class="bi bi-plus-circle"></i> Tambah Halte
                                            </button>
                                        </div>
                                        <table class="table table-striped table-responsive" id="table1">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Halte</th>
                                                    <th>Koridor</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($halte as $item)
                                                    <tr>
                                                        <td>{{ $loop->iteration ?? 'Data Tidak Tersedia' }}</td>
                                                        <td>{{ $item->halte_nama ?? 'Data Tidak Tersedia' }}</td>
                                                        <td>{{ $item->koridor ? $item->koridor->koridor_nama : 'Tidak ada koridor' }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal"
                                                            onclick="openEditModal('{{ $item->halte_id }}', '{{ $item->halte_nama }}', '{{ $item->koridor->koridor_id ?? 'Tidak ada halte'}}')">
                                                                <i class="bi bi-pencil-fill"></i> Edit
                                                            </button>
                                                            <button type="button" class="btn btn-sm btn-danger mb-1 mt-1" data-bs-toggle="modal" data-bs-target="#deleteModal" 
                                                                onclick="setDeleteData('{{ $item->halte_id }}', '{{ $item->halte_nama }}')">
                                                                <i class="bi bi-trash-fill"></i> Hapus
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Modal Tambah Halte -->
                                    <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <form action="{{ route('halte.store') }}" method="POST">
                                                    @csrf
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="addModalLabel">Tambah Halte</h5>
                                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="text-start">Halte:</h6>
                                                        <div class="form-group">
                                                            <input type="text" name="halte_nama" class="form-control" placeholder="Nama Halte">
                                                        </div>
                                                        <h6 class="text-start">Koridor:</h6>
                                                        <div class="form-group">
                                                            <select name="koridor_id" class="choices form-select" required>
                                                                <option value=""disabled selected>Pilih Koridor</option>
                                                                @foreach ($koridor as $item)
                                                                    <option value="{{ $item->koridor_id }}">{{ $item->koridor_nama }}</option> <!-- ID yang dikirim -->
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-success ms-1">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Edit Halte -->
                                    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <form id="editForm" action="" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Halte</h5>
                                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <h6 class="text-start">Halte:</h6>
                                                        <div class="form-group">
                                                            <input type="text" id="edit_halte_nama" name="halte_nama" class="form-control" placeholder="Nama Halte">
                                                        </div>
                                                        <h6 class="text-start">Koridor:</h6>
                                                        <div class="form-group">
                                                            <select id="edit_koridor" name="koridor_id" class="choices form-select">
                                                                @foreach($koridor as $item)
                                                                    <option value="{{ $item->koridor_id }}">{{ $item->koridor_nama }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-warning ms-1">Simpan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal Hapus Halte -->
                                    <div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <form id="deleteForm" action="" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Hapus Halte</h5>
                                                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Apakah Anda yakin ingin menghapus halte - <br>
                                                            <strong id="delete_halte_nama"></strong>?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger ms-1">Hapus</button>
                                                    </div>
                                                </form>
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
    
    {{-- Script Modal --}}
    <script>
        function openEditModal(id, nama, koridorId) {
            document.getElementById('edit_halte_nama').value = nama;
            document.getElementById('edit_koridor').value = koridorId;
            // Set action form untuk update
            document.querySelector('#editModal form').action = `/halte/${id}`;
        }
        function setDeleteData(id, nama) {
            // Isi data ke dalam modal hapus
            document.getElementById('delete_halte_nama').textContent = nama;
            document.getElementById("deleteForm").action = "/halte/" + id;

            // Tampilkan modal hapus
            // new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
    
    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('template/dist/assets/static/js/pages/simple-datatables.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>

</body>

</html>