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
    <link rel="stylesheet" href="{{ asset('template/dist/assets/extensions/simple-datatables/style.css') }}">
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
                                                    <i class="bi bi-bus-front-fill fs-5 text-white"></i>
                                                </div>
                                                <div class="ms-lg-3 text-center text-lg-start">
                                                    <h5 class="text-muted font-semibold">Pengawas</h5>
                                                    <h6 class="text-extrabold mb-0">{{$pekerja}}</h6>
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
                                                    <i class="bi bi-bus-front-fill fs-5 text-white"></i>
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
                                                <div class="bg-success p-3 rounded mb-2 mb-lg-0">
                                                    <i class="bi bi-bus-front-fill fs-5 text-white"></i>
                                                </div>
                                                <div class="ms-lg-3 text-center text-lg-start">
                                                    <h5 class="text-muted font-semibold">Halte</h5>
                                                    <h6 class="text-extrabold mb-0">{{$halte}}</h6>
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
                                                    <i class="bi bi-bus-front-fill fs-5 text-white"></i>
                                                </div>
                                                <div class="ms-lg-3 text-center text-lg-start">
                                                    <h5 class="text-muted font-semibold">Pool</h5>
                                                    <h6 class="text-extrabold mb-0">{{$pool}}</h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header d-flex">
                                            <i class="bi bi-info-circle-fill me-2"></i>
                                            <h5 class="card-title">Filter Data Laporan Pengawas</h5>
                                        </div>
                                        <div class="card-body">
                                            <form method="GET" action="{{ route('admin.homeadmin') }}" class="row g-3">
                                                <div class="col-md-5">
                                                    <h6 for="kategori" class="form-label">Kategori Laporan</h6>
                                                    <select name="kategori" id="kategori" class="form-select">
                                                        <option value="halte" {{ request('kategori') == 'halte' ? 'selected' : '' }}>Halte</option>
                                                        <option value="pool" {{ request('kategori') == 'pool' ? 'selected' : '' }}>Pool</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-5">
                                                    <h6 for="bulan" class="form-label">Bulan</h6>
                                                    <select name="bulan" id="bulan" class="form-select">
                                                        @foreach(range(1, 12) as $b)
                                                            <option value="{{ $b }}" {{ request('bulan') == $b ? 'selected' : '' }}>
                                                                {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="submit" class="btn btn-success me-2">Cari</button>
                                                    <a href="{{ route('admin.homeadmin') }}" class="btn btn-danger">Reset</a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @if(request()->has('kategori') && request()->has('bulan'))
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <table class="table table-responsive" id="table1">
                                                    <thead>
                                                        <tr>
                                                            <th>Pengawas</th>
                                                            <th class="text-center">Jumlah Laporan</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if($laporanPerUser->isEmpty())
                                                            <tr>
                                                                <td colspan="3" class="text-center">
                                                                    <div class="alert alert-warning mb-0">
                                                                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                                                        Data tidak ditemukan untuk kategori dan bulan yang dipilih.
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @else
                                                            @foreach($laporanPerUser as $laporan)
                                                                <tr>
                                                                    <td>{{ $laporan->nama_pekerja }}</td>
                                                                    <td class="text-center">{{ $laporan->total_laporan }}</td>
                                                                    <td>
                                                                        @if($laporan->total_laporan == 0)
                                                                            <span class="badge bg-danger">Kosong</span>
                                                                        @elseif($laporan->total_laporan < 20)
                                                                            <span class="badge bg-warning text-dark">Kurang</span>
                                                                        @else
                                                                            <span class="badge bg-success">Terpenuhi</span>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>   
                        </div>
                    </div>
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-end">
                        <p>&copy; {{ date('Y') }} Transjatim</p>
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
    <script src="{{ asset('template/dist/assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('template/dist/assets/static/js/pages/simple-datatables.js') }}"></script>


</body>

</html>

