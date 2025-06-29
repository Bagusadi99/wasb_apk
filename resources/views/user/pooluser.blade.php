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
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/choices.js/public/assets/styles/choices.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Choices.js CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"> --}}

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
            cursor: default;
        }
        .coordinates-container {
            display: flex;
            gap: 10px;
        }
        .coordinate-input {
            flex: 1;
        }
        .camera-container {
            position: relative;
            margin-bottom: 15px;
        }
        .camera-button {
            display: inline-block;
            background-color: #4A8939;
            color: white;
            padding: 8px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 15px;
        }
        .camera-button i {
            margin-right: 5px;
        }
        .camera-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }
    </style>
</head>

<body style="background-color: #d5edd2;">
    <script src="{{ asset('template/dist/assets/static/js/initTheme.js') }}"></script>
    <div id="app">
        @include('user.sidebaruser')
        <div id="main">
            <header class="mb-3">
                <a class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3" style="color: #4A8939;"></i>
                </a>
            </header>
            <div class="page-heading">
            <h3 style="color: #4A8939">Form Pool</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Pool</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('formpool.store') }}" method="POST" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <div class="row">
                                                @csrf 
                                                <div class="col-md-6 mb-3">
                                                    <h6>Nama</h6>
                                                    <select name="pekerja_id" id="pekerja" class="form-select" required>
                                                        <option value=""disabled selected>Nama Pekerja</option>
                                                        @foreach ($pekerja as $item)
                                                            <option value="{{ $item->pekerja_id }}">{{ $item->nama_pekerja }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <h6>Shift</h6>
                                                    <select name="shift_id" id="shift" class="form-select" required>
                                                        <option value=""disabled selected>Pilih Shift</option>
                                                        @foreach ($shift as $item)
                                                            <option value="{{ $item->shift_id }}">{{ $item->shift_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <h6>Koridor</h6>
                                                    <select name="koridor_id" id="koridor" class="form-select" required>
                                                        <option value="" disabled selected>Pilih Koridor</option>
                                                        @foreach ($koridor as $item)
                                                            <option value="{{ $item->koridor_id }}">{{ $item->koridor_nama }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <h6>Tanggal & Waktu</h6>
                                                    <input type="text" class="form-control" id="live-time" disabled>
                                                    <input type="hidden" name="tanggal_waktu_pool" id="hidden-time">
                                                </div>
                                                <div class="col-md-6 mb-3" style="position: relative; z-index: 2;">
                                                    <h6>Pool</h6>
                                                    <select name="pool_id" id="pool" class="choices form-select" style="position: relative; z-index: 1050; background: white;">
                                                        <option value="" disabled selected>Pilih Pool</option>
                                                    </select>
                                                </div>                                                    
                                                <div class="col-md-3 mb-4">
                                                    <h6>Lokasi (Alamat)</h6>
                                                    <input type="text" id="lokasi" name="lokasi_pool" class="form-control" placeholder="Masukkan Lokasi" readonly>
                                                </div>
                                                <div class="col-md-3 mb-4">
                                                    <h6>Koordinat</h6>
                                                    <div class="coordinates-container">
                                                        <input type="text" id="latitude" name="latitude" class="form-control coordinate-input" placeholder="Latitude" readonly>
                                                        <input type="text" id="longitude" name="longitude" class="form-control coordinate-input" placeholder="Longitude" readonly>
                                                    </div>
                                                    <input type="hidden" id="koordinat" name="koordinat">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <button type="button" class="btn btn-success mt-2" onclick="getCurrentLocation()">
                                                        <i class="bi bi-geo-alt-fill"></i> Ambil Lokasi
                                                    </button>
                                                </div>
                                                
                                                <!-- Map container -->
                                                <div class="col-12 mb-4" style="z-index: 1">
                                                    <h6>Lokasi di Peta</h6>
                                                    <div id="map"></div>
                                                </div>
                                                
                                                <hr>
                                                <div class="col-md-6 mb-3">
                                                    <h6>Foto Kebersihan Lantai Pool</h6>
                                                    <div class="camera-container">
                                                        <div class="camera-button">
                                                            <i class="bi bi-camera-fill"></i> Ambil Foto
                                                        </div>
                                                        <input type="file" name="bukti_kebersihan_lantai_pool" class="camera-input imageInput" 
                                                            data-target="previewImage1" accept="image/*" capture="environment" required>
                                                    </div>
                                                    <img id="previewImage1" src="#" alt="Pratinjau Gambar" 
                                                        style="display: none; margin-top: 10px; max-width: 80%; height: auto; margin-left: auto; margin-right: auto;">
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <h6>Foto Kebersihan Kaca Pool</h6>
                                                    <div class="camera-container">
                                                        <div class="camera-button">
                                                            <i class="bi bi-camera-fill"></i> Ambil Foto
                                                        </div>
                                                        <input type="file" name="bukti_kebersihan_kaca_pool" class="camera-input imageInput" 
                                                            data-target="previewImage2" accept="image/*" capture="environment" required>
                                                    </div>
                                                    <img id="previewImage2" src="#" alt="Pratinjau Gambar" 
                                                        style="display: none; margin-top: 10px; max-width: 80%; height: auto; margin-left: auto; margin-right: auto;">
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <h6>Foto Kebersihan Sampah Pool</h6>
                                                    <div class="camera-container">
                                                        <div class="camera-button">
                                                            <i class="bi bi-camera-fill"></i> Ambil Foto
                                                        </div>
                                                        <input type="file" name="bukti_kebersihan_sampah_pool" class="camera-input imageInput" 
                                                            data-target="previewImage3" accept="image/*" capture="environment" required>
                                                    </div>
                                                    <img id="previewImage3" src="#" alt="Pratinjau Gambar" 
                                                        style="display: none; margin-top: 10px; max-width: 80%; height: auto; margin-left: auto; margin-right: auto;">
                                                </div>
                                                
                                                <div class="col-md-6 mb-3">
                                                    <h6>Foto Kebersihan Kondisi Pool</h6>
                                                    <div class="camera-container">
                                                        <div class="camera-button">
                                                            <i class="bi bi-camera-fill"></i> Ambil Foto
                                                        </div>
                                                        <input type="file" name="bukti_kondisi_pool" class="camera-input imageInput" 
                                                            data-target="previewImage4" accept="image/*" capture="environment" required>
                                                    </div>
                                                    <img id="previewImage4" src="#" alt="Pratinjau Gambar" 
                                                        style="display: none; margin-top: 10px; max-width: 80%; height: auto; margin-left: auto; margin-right: auto;">
                                                </div>                                                

                                                <div class="col-md-6 mb-3" style="position: relative; z-index: 2;">
                                                    <h6>Kendala Pool</h6>
                                                    <small class="form-text text-danger">*Jika tidak ada kendala pool, tidak perlu diisi</small>
                                                    <select name="kendala_pool_ids[]" id="kendala_pool" class="choices form-select" multiple>
                                                        @foreach ($kendala_pool as $item)
                                                            <option value="{{ $item->kendala_pool_id }}">{{ $item->kendala_pool }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="col-md-6 mb-3">
                                                    <h6>Foto Kendala Pool</h6>
                                                    <small class="form-text text-danger">*Jika tidak ada kendala pool, tidak perlu diisi</>
                                                    <div class="camera-container">
                                                        <div class="camera-button">
                                                            <i class="bi bi-camera-fill"></i> Ambil Foto
                                                        </div>
                                                        <input type="file" name="bukti_kendala_pool" class="camera-input imageInput" 
                                                            data-target="previewImage5" accept="image/*" capture="environment">
                                                    </div>
                                                    <img id="previewImage5" src="#" alt="Pratinjau Gambar" 
                                                        style="display: none; margin-top: 10px; max-width: 80%; height: auto; margin-left: auto; margin-right: auto;">
                                                </div>

                                                <div class="card">
                                                    <button type="submit" class="btn btn-success">Kirim</button>
                                                </div>
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
                        <p>&copy; {{ date('Y') }} Trans Jawa Timur </p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin="">
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const koridorDropdown = document.getElementById('koridor');
            const poolDropdown = document.getElementById('pool');
            const kendalaPoolDropdown = document.getElementById('kendala_pool');  


            // Inisialisasi Choices.js
            const poolChoices = new Choices(poolDropdown, {
                searchEnabled: true,
                removeItemButton: false,
                shouldSort: false,
                itemSelectText: '',
                allowHTML: true
            });

            // Inisialisasi Choices.js untuk kendala pool (multiple select)
            const kendalaChoices = new Choices(kendalaPoolDropdown, {
                removeItemButton: true,
                searchEnabled: true,
                shouldSort: false,
                itemSelectText: '',
                allowHTML: true,
                // placeholder: true,
                // placeholderValue: 'Pilih Kendala Pool'
            });

            koridorDropdown.addEventListener('change', function () {
                const koridorId = this.value;

                if (koridorId) {
                    fetch(`/get-pool-by-koridor/${koridorId}`)
                        .then(response => response.json())
                        .then(data => {
                            poolChoices.clearChoices(); // Hapus pilihan sebelumnya

                            if (data.length > 0) {
                                let options = data.map(item => ({
                                    value: item.pool_id,
                                    label: item.pool_nama
                                }));
                                poolChoices.setChoices(options, 'value', 'label', true);
                            } else {
                                poolChoices.setChoices([{
                                    value: "",
                                    label: "Tidak ada pool tersedia",
                                    disabled: true
                                }], 'value', 'label', true);
                            }
                        })
                        .catch(error => console.error('Fetch error:', error));
                } else {
                    poolChoices.clearChoices();
                    poolChoices.setChoices([{
                        value: "",
                        label: "Pilih Pool",
                        disabled: true
                    }], 'value', 'label', true);
                }
            });
            
            // Jika ada data koordinat yang sudah ada (misalnya saat edit), tampilkan di peta
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            
            if (latitudeInput.value && longitudeInput.value) {
                updateMap(parseFloat(latitudeInput.value), parseFloat(longitudeInput.value));
            }

            // Trigger camera automatically when a camera button is clicked
            document.querySelectorAll(".camera-container").forEach(container => {
                button.addEventListener("click", function() {
                    const input = this.querySelector(".camera-input");
                    if (input) {
                        input.click();
                    }
                });
            });
        });

        //Script untuk inisialisasi peta
        var map = L.map('map', {
            zoomControl: true,
            dragging: false,
            touchZoom: false,
            doubleClickZoom: false,
            scrollWheelZoom: false,
            boxZoom: false,
            tap: false,
            keyboard: false
        }).setView([-7.2575, 112.7521], 13);
        
        var marker = null;
        
        // Add OpenStreetMap tiles
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);
        

        map.on('click', function(e) {
                const { lat, lng } = e.latlng;
                map.setView([lat, lng], 18);
                
                if (marker !== null) {
                    map.removeLayer(marker);
                }

                marker = L.marker([lat, lng]).addTo(map);
                
                document.getElementById("latitude").value = lat;
                document.getElementById("longitude").value = lng;
                document.getElementById("koordinat").value = `${lat},${lng}`;
            });

        // Fungsi untuk memperbarui peta berdasarkan koordinat
        function updateMap(latitude, longitude) {
            map.setView([latitude, longitude], 18);
            
            if (marker !== null) {
                map.removeLayer(marker);
            }
            
            marker = L.marker([latitude, longitude]).addTo(map);
        }

        // Fungsi untuk mendapatkan lokasi saat ini
        function getCurrentLocation() {
            const lokasiInput = document.getElementById("lokasi");
            const latitudeInput = document.getElementById("latitude");
            const longitudeInput = document.getElementById("longitude");
            const koordinatInput = document.getElementById("koordinat");

            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        // Get high accuracy coordinates
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        
                        // Format coordinates with more precision (6 decimal places)
                        const formattedLat = latitude.toFixed(6);
                        const formattedLng = longitude.toFixed(6);
                        
                        // Set coordinates in the input fields
                        latitudeInput.value = formattedLat;
                        longitudeInput.value = formattedLng;
                        koordinatInput.value = `${formattedLat},${formattedLng}`;
                        
                        // Update map view
                        updateMap(latitude, longitude);
                        
                        // Fetch address from OpenStreetMap
                        const apiUrl = `https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`;

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
                        latitudeInput.value = "";
                        longitudeInput.value = "";
                    },
                    { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
                );
            } else {
                lokasiInput.value = "Geolocation tidak didukung";
                latitudeInput.value = "";
                longitudeInput.value = "";
            }
        }
        
        // Event listeners untuk preview gambar
        document.querySelectorAll(".imageInput").forEach(input => {
            input.addEventListener("change", function(event) {
                const file = event.target.files[0];
                const targetImg = document.getElementById(event.target.getAttribute("data-target"));

                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        targetImg.src = e.target.result;
                        targetImg.style.display = "block";
                    };
                    reader.readAsDataURL(file);
                } else {
                    targetImg.style.display = "none";
                }
            });
        });
    </script>
    <script>
        function updateLiveTime() {
            const now = new Date();
            
            // Format tampilan: "DD-MM-YYYY HH:MM WIB" (contoh: 11-04-2025 14:30 WIB)
            const formattedTime = now.toLocaleString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).replace(/\./g, ':'); // Ganti titik dengan strip (format Indonesia)
            
            // Format database: "YYYY-MM-DD HH:MM:SS" (contoh: 2025-04-11 14:30:00)
            const dbTime = now.toISOString().slice(0, 19).replace('T', ' ');
            
            // Update nilai input
            document.getElementById('live-time').value = `${formattedTime} WIB`;
            document.getElementById('hidden-time').value = dbTime;
        }
    
        // Jalankan sekali saat halaman dimuat
        updateLiveTime();
        
        // Update setiap 1 menit (60000 ms)
        setInterval(updateLiveTime, 60000);
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
    

    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- Choices.js JS -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script> --}}
    <script src="{{ asset('template/dist/assets/static/js/pages/form-element-select.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>

</body>
</html>