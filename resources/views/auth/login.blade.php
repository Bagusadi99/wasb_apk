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
    <style>
        body {
            background-image: url('{{ asset('template/dist/assets/compiled/jpg/bgtransjatim4.jpg') }}');
            background-size: cover; /* Sesuaikan ukuran gambar */
            background-position: center 70%; /* Posisi gambar: tengah horizontal, 20% dari atas */
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        /* .glass-card {
            background-color: rgba(255, 255, 255, 0.3);
        backdrop-filter: blur(10px); 
        } */
        
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card glass-card shadow-lg p-4" style="width: 350px; height: auto">
            <div class="d-flex align-items-center justify-content-center mb-4">
                <a href="#">
                    <img src="{{ asset('template/dist/assets/compiled/png/logotransjatim.png') }}" alt="Logo" style="width: 80px; height: 80px;">
                </a>
                <div class="ms-4 text-center">
                    <h5 class="mb-0 text-success">WASB</h5>
                    <h6 class="text-success">Pengawasan Kebersihan</h6>
                </div>
            </div>            

            @if (Session::has('error'))
                <div class="alert alert-light-danger color-danger">
                    <i class="bi bi-exclamation-circle"></i> {{ Session::get('error') }}
                </div>
            @endif
            
            <form action="{{ route('login.input') }}" method="POST">
                @csrf   
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person mb-2"></i></span>
                        <input type="text" class="form-control" id="user_nama" name="user_nama" placeholder="Masukkan username" required>
                    </div>
                </div>
                <div class="mb-4">
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

</html>
