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
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Your existing styles here */
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
                <a class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3" style="color: #4A8939;"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3 style="color: #4A8939"> Data Halte / Shalter</h3>
            </div>
            <div class="card mb-3">
                <div class="card-body">
                    <form method="GET" action="{{ route('filter_datahalte') }}">
                        <div class="row">
                            <div class="col-md-2">
                                <h6 for="start_date">Koridor</h6>
                                <select name="koridor" class="choices form-select">
                                    <option value="" disabled {{ request('koridor') ? '' : 'selected' }}>Pilih Koridor</option>
                                    @foreach ($koridor as $item)
                                        <option value="{{ $item->koridor_id }}" {{ request('koridor') == $item->koridor_id ? 'selected' : '' }}>
                                            {{ $item->koridor_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <h6 for="start_date">Dari Tanggal</h6>
                                <input type="date" class="form-control" id="start_date" name="start_date"
                                    value="{{ request('start_date') }}">
                            </div>
                            <div class="col-md-3">
                                <h6 for="end_date">Sampai Tanggal</h6>
                                <input type="date" class="form-control" id="end_date" name="end_date"
                                    value="{{ request('end_date') }}">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary me-2" id="filterBtn" disabled>Filter</button>
                                @if (request('start_date') || request('end_date') || request('koridor'))
                                    <a href="{{ url()->current() }}" class="btn btn-danger me-2">Reset</a>
                                @endif

                                @if (request('start_date') && request('end_date'))
                                    <div class="dropdown">
                                        <button class="btn btn-success dropdown-toggle" type="button"
                                            id="dropdownMenuButtonIcon" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-download"></i> Ekspor
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonIcon">
                                            <li>
                                                <a href="javascript:void(0);" class="dropdown-item"
                                                    onclick="showPDFPreview('{{ route('export_pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date'), 'koridor' => request('koridor')]) }}')">
                                                    <i class="bi bi-filetype-pdf"></i> Preview PDF
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('export_excel', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}">
                                                    <i class="bi bi-file-earmark-spreadsheet"></i> Download Excel
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            @if (request('start_date') && request('end_date'))
                <div class="alert alert-primary">
                    Menampilkan data Tanggal **{{ date('d F Y', strtotime(request('start_date'))) }}**
                    sampai **{{ date('d F Y', strtotime(request('end_date'))) }}**
                </div>
            @elseif (request('koridor'))
                <div class="alert alert-primary">
                    Menampilkan data untuk **{{ $koridor->firstWhere('koridor_id', request('koridor'))->koridor_nama }}**
                </div>
            @endif
            <div class="page-content" id="page-content">
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
                                                        <th>Koridor</th>
                                                        <th>Halte</th>
                                                        <th>Tanggal & Waktu</th>
                                                        <th>Bukti Kebersihan</th>
                                                        <th style="text-align: center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($laporan_halte as $item)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td class="text-nowrap">{{ $item->pekerja->nama_pekerja }}</td>
                                                            <td>{{ $item->shift->shift_nama }}</td>
                                                            <td class="text-nowrap">{{ $item->koridor->koridor_nama ?? '-' }}</td>
                                                            <td>{{ $item->halte->halte_nama ?? '-' }}</td>
                                                            <td>{{ ($item->tanggal_waktu_halte) }}</td>
                                                            <td>
                                                                <img src="{{ asset('storage/' . $item->bukti_kebersihan_lantai_halte) }}"
                                                                    alt="Bukti Kebersihan"
                                                                    style="max-width: 100px; max-height: 100px;">
                                                            </td>
                                                            <td style="text-align: center">
                                                                <button
                                                                    class="btn btn-primary btn-sm detail-btn mb-1 mt-1"
                                                                    data-id="{{ $item->laporan_halte_id }}">
                                                                    <i class="bi bi-eye-fill"></i> Detail
                                                                </button>
                                                                {{-- ADDED: data-id for delete button --}}
                                                                <button class="btn btn-danger btn-sm delete-btn mb-1 mt-1"
                                                                        data-id="{{ $item->laporan_halte_id }}">
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

    {{-- ADDED: Hidden form for delete action --}}
    <form id="delete-form" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <div class="modal fade" id="previewExcelModal" tabindex="-1" aria-labelledby="previewExcelModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewExcelModalLabel">Preview Data Excel</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Petugas</th>
                                    <th>Shift</th>
                                    <th>Tanggal & Waktu</th>
                                    <th>Bukti Kebersihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($laporan_halte as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->pekerja->nama_pekerja }}</td>
                                        <td>{{ $item->shift->shift_nama }}</td>
                                        <td>{{ $item->tanggal_waktu_halte }}</td>
                                        <td>
                                            <img src="{{ asset('storage/' . $item->bukti_kebersihan_lantai_halte) }}"
                                                style="max-width: 100px;">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('export_excel', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}"
                            class="btn btn-success">
                            <i class="bi bi-download"></i> Download Excel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="previewPDFModal" tabindex="-1" aria-labelledby="previewPDFModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewPDFModalLabel">Preview PDF</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <iframe id="pdfIframe" src="" frameborder="0"
                        style="width: 100%; height: 80vh;"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-success" id="downloadPdfBtn" onclick="downloadPDF()">
                        <i class="bi bi-download"></i> Download PDF
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('template/dist/assets/static/js/pages/simple-datatables.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Validasi client-side untuk tanggal
        document.querySelector('form').addEventListener('submit', function(e) {
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;

            // Only validate date range if both dates are filled
            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);

                if (start > end) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan Tanggal',
                        text: 'Tanggal "Dari Tanggal" tidak boleh lebih besar dari "Sampai Tanggal".'
                    });
                    e.preventDefault(); // Prevent form submission
                }
            }
        });

        // Minimaps
        let miniMap = null;
        let marker = null;

        // Fungsi untuk inisialisasi peta
        function initMap(latitude, longitude) { // Removed 'title' as it wasn't used
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
        document.querySelector('#table1').addEventListener('click', function(e) {
            if (e.target.closest('.detail-btn')) {
                e.preventDefault();
                const button = e.target.closest('.detail-btn');
                const id = button.getAttribute('data-id');

                // Clear previous detail content to avoid stale data
                document.getElementById('detail-content').innerHTML = '<div class="text-center py-5">Memuat data...</div>';
                document.getElementById('page-content').classList.add('active');
                document.getElementById('detail-section').style.display = 'block';

                fetch(`/detail_datahalte/${id}`) // Make sure this route exists
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.text();
                    })
                    .then(html => {
                        document.getElementById('detail-content').innerHTML = html;

                        const container = document.querySelector('#detail-content > div');
                        // Ensure container and its dataset properties exist before trying to read them
                        if (container && container.dataset && container.dataset.latitude && container.dataset.longitude) {
                            const lat = parseFloat(container.dataset.latitude);
                            const lng = parseFloat(container.dataset.longitude);
                            // Only initialize map if coordinates are valid numbers
                            if (!isNaN(lat) && !isNaN(lng)) {
                                initMap(lat, lng);
                            } else {
                                console.error('Invalid latitude or longitude:', container.dataset.latitude, container.dataset.longitude);
                                // Optional: display a message if map cannot be loaded due to invalid coords
                                const mapContainer = document.getElementById('mini-map');
                                if (mapContainer) {
                                    mapContainer.innerHTML = '<p class="text-center text-danger">Tidak dapat menampilkan peta: Koordinat tidak valid.</p>';
                                }
                            }
                        } else {
                            console.error('Detail content or map coordinates not found.');
                            // Optional: display a message if map cannot be loaded
                             const mapContainer = document.getElementById('mini-map');
                                if (mapContainer) {
                                    mapContainer.innerHTML = '<p class="text-center text-danger">Tidak dapat menampilkan peta: Data detail tidak lengkap.</p>';
                                }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'Gagal memuat data detail. Silakan coba lagi.', 'error');
                        document.getElementById('detail-content').innerHTML = '<p class="text-center text-danger">Gagal memuat data detail.</p>';
                        // Optionally hide detail section on error
                        document.getElementById('page-content').classList.remove('active');
                        document.getElementById('detail-section').style.display = 'none';
                    });
            }
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

        document.addEventListener('DOMContentLoaded', function () {
            const koridorSelect = document.querySelector('select[name="koridor"]');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');
            const filterBtn = document.getElementById('filterBtn');

            function updateFilterButtonState() {
                const koridorFilled = koridorSelect.value !== "";
                const startDateFilled = startDateInput.value !== "";
                const endDateFilled = endDateInput.value !== "";

                // Simplified logic: Enabled if (Koridor selected AND no dates) OR (both dates selected)
                filterBtn.disabled = !((koridorFilled && !startDateFilled && !endDateFilled) || (startDateFilled && endDateFilled));
            }

            // Pantau perubahan input
            koridorSelect.addEventListener('change', updateFilterButtonState);
            startDateInput.addEventListener('input', updateFilterButtonState);
            endDateInput.addEventListener('input', updateFilterButtonState);

            // Jalankan saat halaman pertama kali dimuat
            updateFilterButtonState();
        });

        // ADDED: JavaScript for SweetAlert2 delete confirmation
        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.getElementById('delete-form');
                        // Make sure your route for deleting halte data is correctly defined in web.php
                        // For example: Route::delete('/datahalte/{id}', [YourController::class, 'destroy']);
                        form.action = `/datahalte/${id}`;
                        form.submit();
                    }
                })
            });
        });

    </script>

    <script>
        // Modify the showPDFPreview function to first display the PDF in iframe
        function showPDFPreview(url) {
            // Modify URL to include a parameter that indicates preview only
            const previewUrl = url + (url.includes('?') ? '&' : '?') + 'preview=true';

            // Set the iframe src to the preview URL
            document.getElementById('pdfIframe').src = previewUrl;

            // Store the original download URL for later use
            document.getElementById('downloadPdfBtn').setAttribute('data-url', url);

            // Show the modal
            var myModal = new bootstrap.Modal(document.getElementById('previewPDFModal'));
            myModal.show();
        }

        // Function to handle the download after preview
        function downloadPDF() {
            const downloadUrl = document.getElementById('downloadPdfBtn').getAttribute('data-url');
            window.location.href = downloadUrl + (downloadUrl.includes('?') ? '&' : '?') + 'download=true';
        }
    </script>

    <script>
        function previewPDF(url) {
            window.open(url, '_blank');
        }
    </script>

</body>

</html>