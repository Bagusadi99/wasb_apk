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
            <h3 style="color: #4A8939">Home Admin</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex">
                                    <i class="bi bi-info-circle-fill me-2"></i>
                                    <h4 class="card-title">Dashboard Admin</h4>
                                </div>
                                <div class="card-body">
                                    <form action="">
                                        <div class="form-group">
                                            <div class="row">
                                                
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

