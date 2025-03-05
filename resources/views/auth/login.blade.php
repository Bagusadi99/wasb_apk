<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WASB - pengawasan kebersihan</title>
    <link rel="shortcut icon" href="{{ asset('template/dist/assets/compiled/png/logotransjatim.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/app-dark.css') }}">
    <link rel="stylesheet" href="{{ asset('template/dist/assets/compiled/css/auth.css') }}">
</head>

<body style="background-color: #d5edd2;">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card shadow-lg p-4" style="width: 350px; height: 400px;">
            <div class="d-flex align-items-center justify-content-center mb-4">
                <a href="#">
                    <img src="{{ asset('template/dist/assets/compiled/png/logotransjatim.png') }}" alt="Logo" style="width: 80px; height: 80px;">
                </a>
                <div class="ms-4 text-center">
                    <h5 class="mb-0 text-success">WASB</h5>
                    <h6 class="text-success">Pengawasan Kebersihan</h6>
                </div>
            </div>            
            
            <form action="{{ route('login.input') }}" method="POST">
                @csrf   
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person mb-2"></i></span>
                        <input type="text" class="form-control" id="user_nama" name="user_nama" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="mb-5">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-shield-lock mb-2"></i></span>
                        <input type="password" class="form-control" id="user_password" name="user_password" placeholder="Masukkan password" required>
                    </div>
                </div>
                <button type="submit" class="btn btn-success w-100">Masuk</button>
            </form>
        </div>
    </div>
</body>
<script src="{{ asset('template/dist/assets/static/js/initTheme.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if ($message = Session::get('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $message }}',
        });
    </script>
@endif

</html>
