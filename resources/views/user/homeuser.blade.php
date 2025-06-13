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
                <a class="burger-btn d-block d-xl-none" style="color: #4A8939">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
            <h3 style="color: #4A8939">Home</h3>
            </div>
            <div class="page-content">
                <section class="basic-choices">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body d-flex flex-column">
                                    <div class="d-flex mb-2">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        <h5 class="card-title mb-0">Informasi</h5>
                                    </div>
                                    <p class="mt-0">Silakan pilih form pelaporan yang tersedia pada menu untuk memulai.</p>
                                </div>
                            </div>
                            <div class="row mt-3 justify-content-start">
                                <div class="col-12 col-md-6 mb-0">
                                    <a href="/halteuser" class="text-decoration-none">
                                        <div class="card text-center shadow-sm border-0">
                                            <div class="card-body py-2">
                                                <i class="bi bi-bus-front-fill fs-4 mb-2" style="color: #4A8939"></i>
                                                <h6 style="color: #4A8939"> Form Halte</h6>
                                                <p class="text-muted small mb-0">Lapor Kebersihan Halte</p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-12 col-md-6 mb-3">
                                    <a href="/pooluser" class="text-decoration-none">
                                        <div class="card text-center shadow-sm border-0">
                                            <div class="card-body py-2">
                                                <i class="bi bi-buildings-fill fs-4 mb-2" style="color: #4A8939"></i>
                                                <h6 style="color: #4A8939">Form Pool</h6>
                                                <p class="text-muted small mb-0">Lapor Kebersihan Pool</p>
                                            </div>
                                        </div>
                                    </a>
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
                    {{-- <div class="float-end">
            <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span>
                by <a href="https://saugi.me">Saugi</a></p>
        </div> --}}
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('template/dist/assets/static/js/components/dark.js') }}"></script>
    <script src="{{ asset('template/dist/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/compiled/js/app.js') }}"></script>
    <!-- Need: Apexcharts -->
    <script src="{{ asset('template/dist/assets/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('template/dist/assets/static/js/pages/dashboard.js') }}"></script>

</body>

</html>
