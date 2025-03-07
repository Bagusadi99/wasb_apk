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
        @include('user.sidebaruser')
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3" style="color: #4A8939;"></i>
                </a>
            </header>
            <div class="page-heading">
            <h3 style="color: #4A8939">Form Helte & Shalter</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Halte / Shalter</h4>
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
                                                        <select name="shift_id" id="shift" class="choices form-select">
                                                            <option value=""disabled selected>Pilih Shift</option>
                                                            @foreach ($koridors as $koridor)
                                                                <option value="{{ $koridor->koridor_id }}">{{ $koridor->koridor_nama }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Tanggal</h6>
                                                        <input type="date" class="form-control" placeholder="Masukkan Tanggal">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Nama Halte</h6>
                                                        <input type="text" class="form-control" placeholder="Masukkan Nama Halte">
                                                    </div>
                                                    <div class="col-md-6 mb-4">
                                                        <h6>Lokasi</h6>
                                                        <input type="location" class="form-control" placeholder="Masukkan Lokasi">
                                                    </div>
                                                    <hr>
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Lantai Halte</h6>
                                                        <input type="file" class="imageInput form-control" data-target="previewImage1" accept="image/*">
                                                        <img id="previewImage1" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>
                                                
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Kaca Halte</h6>
                                                        <input type="file" class="imageInput form-control" data-target="previewImage2" accept="image/*">
                                                        <img id="previewImage2" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>
                                                
                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Sampah Halte</h6>
                                                        <input type="file" class="imageInput form-control" data-target="previewImage3" accept="image/*">
                                                        <img id="previewImage3" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>

                                                    <div class="col-md-6 mb-3">
                                                        <h6>Foto Kebersihan Kondisi Halte</h6>
                                                        <input type="file" class="imageInput form-control" data-target="previewImage4" accept="image/*">
                                                        <img id="previewImage4" src="#" alt="Pratinjau Gambar" style="display: none; margin-top: 10px; max-width: 100%; height: auto;">
                                                    </div>

                                                    <div class="col-md-6 mb-4">
                                                        <h6>Kendala Halte</h6>
                                                        <input type="text" class="form-control" placeholder="Masukkan Kendala">
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
                    {{-- <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://saugi.me">Saugi</a></p>
        </div> --}}
                </div>
            </footer>
        </div>
    </div>
    <script>
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
    </script>
    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>
    <!-- Need: Apexcharts -->
    <script src="{{ asset('template/dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/static/js/pages/dashboard.js') }}"></script>

</body>

</html>
