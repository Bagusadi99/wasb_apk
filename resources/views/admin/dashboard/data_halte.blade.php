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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .page-content {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }

        .page-content.active {
            grid-template-columns: 2fr 1fr;
        }

        .detail-section {
            display: none;
        }

        .page-content.active .detail-section {
            display: block;
        }

        .close-btn {
            cursor: pointer;
            float: right;
            font-size: 1.5rem;
            font-weight: bold;
            color: #000;
        }

        .close-btn:hover {
            color: #ff0000;
        }

        #mini-map {
            height: 200px;
            width: 100%;
            border-radius: 8px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .page-content.active {
                grid-template-columns: 1fr;
            }
        }
        .image-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 5px;
        }

        .image-container img {
            max-width: 100%;
            max-height: 120px;
        }
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
                <h3 style="color: #4A8939"> Data Halte / Shalter</h3>
            </div>
            <!-- Tambahkan Form Filter di sini -->
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('filter_datahalte') }}">
                        <div class="row">
                            <div class="col-md-4">
                                <h6 for="start_date">Dari Tanggal</h6>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-4">
                                <h6 for="end_date">Sampai Tanggal</h6>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2">Filter</button>
                                @if(request('start_date') || request('end_date'))
                                    <a href="{{ url()->current() }}" class="btn btn-danger me-2">Reset</a>
                                @endif

                                <div class="dropdown">
                                    <button class="btn btn-success dropdown-toggle me-1" type="button"
                                        id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <i class="bi bi-error-circle me-50"></i> Eksport
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
                                        <a class="dropdown-item" href="#"><i class="bi bi-filetype-pdf"></i> PDF</a>
                                        <a class="dropdown-item" href="#"><i class="bi bi-filetype-exe"></i> EXCEL</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Tampilkan info filter jika sedang aktif -->
            @if(request('start_date') && request('end_date'))
                <div class="alert alert-primary">
                    Menampilkan data Tanggal <strong>{{ date('d F Y', strtotime(request('start_date'))) }}</strong> 
                    sampai <strong>{{ date('d F Y', strtotime(request('end_date'))) }}</strong>
                </div>
            @endif
            <div class="page-content" id="page-content">
                <!-- Bagian Kiri: Tabel -->
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">List Data Halte / Shalter</h4>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-striped" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Petugas</th>
                                                        <th>Shift</th>
                                                        <th>Tanggal & Waktu</th>
                                                        <th>Bukti Kebersihan</th>
                                                        <th style="text-align: center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($laporan_halte as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $item->pekerja->nama_pekerja }}</td>
                                                            <td>{{ $item->shift->shift_nama }}</td>
                                                            <td>{{ $item->tanggal_waktu_halte}}</td>
                                                            <td>
                                                                <img src="{{ asset('storage/' . $item->bukti_kebersihan_lantai_halte) }}" 
                                                                    alt="Bukti Kebersihan" 
                                                                    style="max-width: 100px; max-height: 100px;">
                                                            </td>
                                                            <td style="text-align: center">
                                                                <button class="btn btn-primary btn-sm detail-btn mb-1 mt-1" 
                                                                        data-id="{{ $item->laporan_halte_id }}">
                                                                    <i class="bi bi-eye-fill"></i> Detail
                                                                </button>
                                                                <button class="btn btn-danger btn-sm mb-1 mt-1">
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
                    </div>
                </section>

                <!-- Bagian Kanan: Detail -->
                <section class="detail-section" id="detail-section">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title mt-3">Detail Data</h4>
                            <span class="close-btn" id="close-detail"><i class="bi bi-x-lg"></i></span>
                        </div>
                        <hr>
                        <div class="card-body" id="detail-content">

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
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Validasi client-side untuk tanggal
        document.querySelector('form').addEventListener('submit', function(e) {
            const startDate = new Date(document.getElementById('start_date').value);
            const endDate = new Date(document.getElementById('end_date').value);
        });
        
        // Minimaps
        let miniMap = null;
        let marker = null;

        // Fungsi untuk inisialisasi peta
        function initMap(latitude, longitude, title) {
            // Hapus peta lama jika ada
            if (miniMap) {
                miniMap.remove();
            }

            // Buat peta baru
            miniMap = L.map('mini-map').setView([latitude, longitude], 15);

            // Tambahkan tile layer (OpenStreetMap)
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(miniMap);

            // Tambahkan marker
            marker = L.marker([latitude, longitude]).addTo(miniMap);
        }

        // Event listener untuk tombol detail
        document.querySelectorAll('.detail-btn').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');

                // Load partial view
                fetch(`/detail_datahalte/${id}`)
                    .then(response => response.text())
                    .then(html => {
                        // Tampilkan detail
                        document.getElementById('detail-content').innerHTML = html;
                        document.getElementById('page-content').classList.add('active');
                        document.getElementById('detail-section').style.display = 'block';

                        // Ambil data koordinat dari element
                        const container = document.querySelector('#detail-content > div');
                        const lat = parseFloat(container.dataset.latitude);
                        const lng = parseFloat(container.dataset.longitude);
                        
                        // Inisialisasi peta
                        initMap(lat, lng);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Gagal memuat data detail', 'error');
                    });
            });
        });

        // Event listener untuk tombol close
        document.getElementById('close-detail').addEventListener('click', function() {
            document.getElementById('page-content').classList.remove('active');
            document.getElementById('detail-section').style.display = 'none';
            document.getElementById('detail-content').innerHTML = '';
            
            // Hapus peta jika ada
            if (miniMap) {
                miniMap.remove();
                miniMap = null;
                marker = null;
            }
        });
    </script>
</body>
</html>