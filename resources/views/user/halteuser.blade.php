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
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" 
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" 
        crossorigin=""/>
    <style>
        #map {
            height: 300px;
            width: 100%;
            border-radius: 8px;
            margin-bottom: 15px;
            cursor: default; /* Change cursor to default to indicate no interaction */
        }
    </style>
</head>

<body style="background-color: #d5edd2;">
    <script src="{{ asset('template/dist/assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('user.sidebaruser')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3" style="color: #4A8939;"></i>
                </a>
            </header>
            <div class="page-heading">
            <h3 style="color: #4A8939">Form Halte & Shelter</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Halte / Shelter</h4>
                                </div>
                                <div class="card-body">
                                    <form action="">
                                        <div class="form-group">
                                            <div class="row">
                                                <form action="" method="POST">
                                                    @csrf <!-- Tambahkan CSRF Token untuk keamanan -->
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Nama</h6>
                                                        <select name="pekerja_id" id="pekerja" class="choices form-select">
                                                            <option value=""disabled selected>Nama Pekerja</option>
                                                            @foreach ($pekerjas as $pekerja)
                                                                <option value="{{ $pekerja->pekerja_id }}">{{ $pekerja->nama_pekerja }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Shift</h6>
                                                        <select name="shift_id" id="shift" class="choices form-select">
                                                            <option value=""disabled selected>Pilih Shift</option>
                                                            @foreach ($shifts as $shift)
                                                                <option value="{{ $shift->shift_id }}">{{ $shift->shift_nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Koridor</h6>
                                                        <select name="koridor_id" id="koridor" class="choices form-select">
                                                            <option value="" disabled selected>Pilih Koridor</option>
                                                            @foreach ($koridors as $koridor)
                                                                <option value="{{ $koridor->koridor_id }}">{{ $koridor->koridor_nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Tanggal</h6>
                                                        <input type="date" name="tanggal" class="form-control" placeholder="Masukkan Tanggal">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Halte</h6>
                                                        <select name="halte_id" id="halte" class="choices form-select">
                                                            <option value="" disabled selected>Pilih Halte</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 mb-4">
                                                        <h6>Lokasi (Alamat)</h6>
                                                        <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Masukkan Lokasi" readonly>
                                                    </div>
                                                    <div class="col-md-3 mb-4">
                                                        <h6>Koordinat (Lat, Lng)</h6>
                                                        <input type="text" id="koordinat" name="koordinat" class="form-control" placeholder="Koordinat" readonly>
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <button type="button" class="btn btn-success mt-1" onclick="getCurrentLocation()">
                                                            <i class="bi bi-geo-alt-fill"></i> Ambil Lokasi
                                                        </button>
                                                    </div>
                                                    
                                                    <!-- Map container -->
                                                    <div class="col-12 mb-4">
                                                        <h6>Lokasi di Peta</h6>
                                                        <div id="map"></div>
                                                    </div>
                                                    
                                                    <hr>
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Lantai Halte</h6>
                                                        <input type="file" name="foto_lantai" class="imageInput form-control" data-target="previewImage1" accept="image/*">
                                                        <img id="previewImage1" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>
                                                
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Kaca Halte</h6>
                                                        <input type="file" name="foto_kaca" class="imageInput form-control" data-target="previewImage2" accept="image/*">
                                                        <img id="previewImage2" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>
                                                
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Sampah Halte</h6>
                                                        <input type="file" name="foto_sampah" class="imageInput form-control" data-target="previewImage3" accept="image/*">
                                                        <img id="previewImage3" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Kondisi Halte</h6>
                                                        <input type="file" name="foto_kondisi" class="imageInput form-control" data-target="previewImage4" accept="image/*">
                                                        <img id="previewImage4" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <h6>Kendala Halte</h6>
                                                        <input type="text" name="kendala" class="form-control" placeholder="Masukkan Kendala">
                                                    </div>
                                                </form>
                                            </div> 

                                            <div class="card">
                                                <button type="submit" class="btn btn-success">Kirim</button>
                                            </div>
                                        </div>
                                    </form>                                
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
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
            
    <script>
        // Initialize map with default view (Indonesia)
        var map = L.map('map', {
            zoomControl: true,
            dragging: false,  // Disable map dragging
            touchZoom: false, // Disable touch zoom
            doubleClickZoom: false, // Disable double click zoom
            scrollWheelZoom: false, // Disable scroll wheel zoom
            boxZoom: false,   // Disable box zoom
            tap: false,       // Disable tap handler
            keyboard: false   // Disable keyboard navigation
        }).setView([-7.2575, 112.7521], 13);
        
        var marker = null;
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        
        document.querySelectorAll(".imageInput").forEach(input => {
            input.addEventListener("change", function(event) {
                const file = event.target.files[0]; // Ambil file yang dipilih
                const targetImg = document.getElementById(event.target.getAttribute("data-target"));
    
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        targetImg.src = e.target.result; // Set gambar ke src
                        targetImg.style.display = "block"; // Tampilkan gambar
                    };
                    reader.readAsDataURL(file);
                } else {
                    targetImg.style.display = "none"; // Sembunyikan jika tidak ada file
                }
            });
        });

        function getCurrentLocation() {
            const lokasiInput = document.getElementById("lokasi");
            const koordinatInput = document.getElementById("koordinat");

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        // Get high accuracy coordinates
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        const accuracy = position.coords.accuracy;
                        
                        // Format coordinates with more precision (6 decimal places)
                        const formattedLat = latitude.toFixed(6);
                        const formattedLng = longitude.toFixed(6);
                        
                        // Set coordinates in the input field with higher precision
                        koordinatInput.value = `${formattedLat}, ${formattedLng}`;
                        
                        const apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;

                        // Update map with high zoom level for precision
                        map.setView([latitude, longitude], 18);
                        
                        // Remove previous marker if exists
                        if (marker !== null) {
                            map.removeLayer(marker);
                        }
                        
                        // Add new marker with precise coordinates (no popup text)
                        marker = L.marker([latitude, longitude]).addTo(map);

                        // Fetch detailed address from OpenStreetMap
                        fetch(apiUrl)
                            .then(response => response.json())
                            .then(data => {
                                const address = data.display_name || "Alamat tidak ditemukan";
                                lokasiInput.value = address;
                            })
                            .catch(error => {
                                console.error("Error fetching address:", error);
                                lokasiInput.value = "Gagal mengambil alamat";
                            });
                    },
                    function (error) {
                        console.error("Error getting location:", error);
                        lokasiInput.value = "Lokasi tidak dapat diambil";
                        koordinatInput.value = "N/A";
                    },
                    // Enable high accuracy option
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                lokasiInput.value = "Geolocation tidak didukung";
                koordinatInput.value = "N/A";
            }
        }
        
        // Function to update map when coordinates are entered manually
        // This is kept in case the coordinates are changed by other system processes
        document.getElementById("koordinat").addEventListener("change", function() {
            const koordinatValue = this.value.split(",");
            if (koordinatValue.length === 2) {
                const lat = parseFloat(koordinatValue[0].trim());
                const lng = parseFloat(koordinatValue[1].trim());
                
                if (!isNaN(lat) && !isNaN(lng)) {
                    // Set high precision view
                    map.setView([lat, lng], 18);
                    
                    if (marker !== null) {
                        map.removeLayer(marker);
                    }
                    
                    // Add marker without popup
                    marker = L.marker([lat, lng]).addTo(map);
                }
            }
        });
    </script>

    {{-- Scrip Relasi Koridor & Halte --}}
    <script>
        document.getElementById('koridor').addEventListener('change', function() {
        const koridorId = this.value;
        const halteDropdown = document.getElementById('halte');

        if (koridorId) {
            // Lakukan permintaan AJAX ke server
            fetch(`/get-halte-by-koridor/${koridorId}`)
                .then(response => response.json())
                .then(data => {
                    // Kosongkan dropdown halte
                    halteDropdown.innerHTML = '<option value="" disabled selected>Pilih Halte</option>';

                    // Isi dropdown halte dengan data yang diterima
                    data.forEach(halte => {
                        const option = document.createElement('option');
                        option.value = halte.halte_id;
                        option.textContent = halte.halte_nama;
                        halteDropdown.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        } else {
            // Kosongkan dropdown halte jika tidak ada koridor yang dipilih
            halteDropdown.innerHTML = '<option value="" disabled selected>Pilih Halte</option>';
        }
    });
    </script>
    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>

</body>

</html>