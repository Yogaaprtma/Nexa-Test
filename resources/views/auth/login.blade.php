<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .position-relative {
            position: relative;
        }
        .position-absolute {
            position: absolute;
        }
        .top-50 {
            top: 50%;
            margin-top: 13px;
        }
        .end-0 {
            right: 0;
        }
        .translate-middle-y {
            transform: translateY(-50%);
        }
        .me-3 {
            margin-right: 1rem;
        }
        .fa-eye, .fa-eye-slash {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-4 border border-dark p-4 rounded bg-white">
                <h1 class="h3 mb-3 fw-bold text-center">Halaman Login Pengguna</h1>

                <!-- error message -->
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- success message -->
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukan Email Kamu" required>
                        @error('email')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3 position-relative">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukan Password Kamu" required>
                        <span class="position-absolute top-50 end-0 translate-middle-y me-3" onclick="togglePasswordVisibility()">
                            <i class="fa fa-eye" id="togglePasswordIcon"></i>
                        </span>
                        @error('password')
                            <div class="text-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group mb-3">
                        <p>Belum punya akun? <a class="text-dark fw-bold" href="{{ route('register.page') }}">Daftar Sekarang</a></p>
                    </div>
                    <div class="d-flex flex-column align-items-center">
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-md btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const togglePasswordIcon = document.getElementById('togglePasswordIcon');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            togglePasswordIcon.classList.remove('fa-eye');
            togglePasswordIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            togglePasswordIcon.classList.remove('fa-eye-slash');
            togglePasswordIcon.classList.add('fa-eye');
        }
    }
</script>
</html>