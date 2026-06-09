<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Jelajah Jawa Timur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body class="min-vh-100 d-flex align-items-center justify-content-center p-3 p-md-4">

    <div class="card register-card shadow-lg border-0 w-100">
        <div class="row g-0 h-100">

            {{-- Kiri: Hero Text --}}
            <div class="col-lg-6 d-none d-lg-flex align-items-end p-5 hero-side">
                <div>
                    <h2 class="fw-bold mb-3">Event Seru<br>Nungguin Kamu <i class="bi bi-stars"></i></h2>
                    <p class="fw-light mb-0">Konser, pameran, festival — semua ada. Daftar, datang, dan ceritain pengalamanmu ke ribuan orang.</p>
                </div>
            </div>

            {{-- Kanan: Form --}}
            <div class="col-lg-6 d-flex align-items-center justify-content-center p-4 p-md-5 bg-white">
                <div class="w-100" style="max-width: 400px;">

                    <h2 class="fw-bold text-dark mb-2">Daftar Akun</h2>
                    <p class="text-muted mb-4 fs-6">Buat akun dan mulai temukan event favoritmu!</p>

                    {{-- Error validasi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label fw-medium text-secondary">Nama Lengkap</label>
                            <input type="text"
                                class="form-control py-2 @error('name') is-invalid @enderror"
                                id="nama" name="name"
                                placeholder="Masukkan nama lengkap"
                                value="{{ old('name') }}"
                                autocomplete="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium text-secondary">Email</label>
                            <input type="email"
                                class="form-control py-2 @error('email') is-invalid @enderror"
                                id="email" name="email"
                                placeholder="contoh@email.com"
                                value="{{ old('email') }}"
                                autocomplete="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label fw-medium text-secondary">Kata Sandi</label>
                            <div class="position-relative">
                                <input type="password"
                                    class="form-control py-2 pe-5 @error('password') is-invalid @enderror"
                                    id="password" name="password"
                                    placeholder="••••••••"
                                    autocomplete="new-password" required>
                                <span class="toggle-password" onclick="togglePassword('password', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label for="confirm_password" class="form-label fw-medium text-secondary">Konfirmasi Kata Sandi</label>
                            <div class="position-relative">
                                <input type="password"
                                    class="form-control py-2 pe-5"
                                    id="confirm_password"
                                    name="password_confirmation"
                                    placeholder="••••••••"
                                    autocomplete="new-password" required>
                                <span class="toggle-password" onclick="togglePassword('confirm_password', this)">
                                    <i class="bi bi-eye-slash"></i>
                                </span>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary-custom w-100 rounded-3">Buat Akun</button>
                    </form>

                    <div class="divider my-4 small">atau lanjutkan dengan</div>

                    <div class="d-flex gap-3 mb-4">
                        <a href="{{ route('auth.google') }}"
                            class="btn btn-light border flex-grow-1 py-2 text-secondary fw-medium d-flex align-items-center justify-content-center gap-2">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg"
                                alt="Google Logo" style="width: 20px; height: 20px;">
                            Google
                        </a>
                        <button type="button" disabled
                            class="btn btn-light border flex-grow-1 py-2 text-secondary fw-medium d-flex align-items-center justify-content-center gap-2"
                            title="Apple Sign In belum tersedia">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fa/Apple_logo_black.svg"
                                alt="Apple Logo" style="width: 20px; height: 20px;">
                            Apple
                        </button>
                    </div>

                    <p class="text-center text-muted small mb-0">
                        Sudah punya akun?
                        <a href="{{ route('login') }}" class="text-green fw-bold text-decoration-none">Masuk</a>
                    </p>

                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function togglePassword(fieldId, btn) {
            const input = document.getElementById(fieldId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bi-eye-slash', 'bi-eye');
            } else {
                input.type = 'password';
                icon.classList.replace('bi-eye', 'bi-eye-slash');
            }
        }
    </script>
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>