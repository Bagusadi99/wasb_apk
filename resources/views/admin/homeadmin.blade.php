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
                        <div class="col-12 col-lg-12">
                            <div class="row">
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-2">
                                            <div class="d-flex flex-column flex-lg-row align-items-center">
                                                <div class="bg-primary p-3 rounded mb-2 mb-lg-0">
                                                    <i class="bi bi-person-standing fs-5 text-white"></i>
                                                </div>
                                                <div class="ms-lg-3 text-center text-lg-start">
                                                    <h6 class="text-muted font-semibold">Pengawas</h6>
                                                    <h5 class="text-extrabold mb-0">{{$pekerja}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-2">
                                            <div class="d-flex flex-column flex-lg-row align-items-center">
                                                <div class="bg-warning p-3 rounded mb-2 mb-lg-0">
                                                    <i class="bi bi-building-fill fs-5 text-white"></i>
                                                </div>
                                                <div class="ms-lg-3 text-center text-lg-start">
                                                    <h6 class="text-muted font-semibold">Koridor</h6>
                                                    <h5 class="text-extrabold mb-0">{{$koridor}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-2">
                                            <div class="d-flex flex-column flex-lg-row align-items-center">
                                                <div class="bg-success p-3 rounded mb-2 mb-lg-0">
                                                    <i class="bi bi-bus-front-fill fs-5 text-white"></i>
                                                </div>
                                                <div class="ms-lg-3 text-center text-lg-start">
                                                    <h6 class="text-muted font-semibold">Halte</h6>
                                                    <h5 class="text-extrabold mb-0">{{$halte}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-lg-3 col-md-6">
                                    <div class="card">
                                        <div class="card-body px-4 py-4-2">
                                            <div class="d-flex flex-column flex-lg-row align-items-center">
                                                <div class="bg-info p-3 rounded mb-2 mb-lg-0">
                                                    <i class="bi bi-buildings-fill fs-5 text-white"></i>
                                                </div>
                                                <div class="ms-lg-3 text-center text-lg-start">
                                                    <h6 class="text-muted font-semibold">Pool</h6>
                                                    <h5 class="text-extrabold mb-0">{{$pool}}</h5>
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

</body>

</html>

