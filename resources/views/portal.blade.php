<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Simpeg Universitas Nurul Jadid</title>
    <link rel="icon" href="{{ asset('assets/media/logos/favicon.ico') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fonts/font.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('assets/plugins/plugins.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.bundle.css') }}">
</head>

<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed aside-enabled aside-fixed"
      style="background-color: #f1f4f8; background-image: linear-gradient(to right, rgba(206,206,206,0.31) 1px, transparent 1px), linear-gradient(to bottom, rgba(206,206,206,0.31) 1px, transparent 1px); background-size: 25px 25px; position: relative;">
<div class="d-flex flex-column flex-root">
    <div class="d-flex flex-column flex-column-fluid">
        <div class="d-flex flex-center flex-column flex-column-fluid">
            <div class="container">
                <div class="row align-items-center">
                    <div class="d-flex justify-content-center align-items-center">

                        <form class="w-lg-500px w-sm-500px p-10 bg-white rounded-3 shadow"
                            novalidate="novalidate" id="kt_sign_in_form"
                            method="POST" action="{{ route('logindb') }}">
                            @if (session('error'))
                                <div class="alert alert-danger text-center" id="lock-message">
                                    {{ session('error') }}
                                    @if (session('lock_seconds'))
                                        <span id="countdown" data-seconds="{{ session('lock_seconds') }}"></span>
                                    @endif
                                </div>
                            @endif
                            @csrf

                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-4">Masuk</h1>
                            </div>

                            <!-- Username -->
                            <div class="d-flex flex-column mb-2">
                                <label class="form-label fs-6 fw-bold mb-2">
                                    <span class="required">Nama Pengguna</span>
                                </label>
                                <input type="text" name="username" placeholder="Masukkan nama pengguna"
                                    value="{{ old('username') }}"
                                    class="form-control bg-transparent @error('username') is-invalid @enderror">
                                @error('username')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="d-flex flex-column mb-2">
                                <label class="form-label fs-6 fw-bold mb-2">
                                    <span class="required">Kata Sandi</span>
                                </label>
                                <div class="position-relative mb-2">
                                    <input class="form-control bg-transparent @error('password') is-invalid @enderror"
                                        type="password" name="password" placeholder="Masukkan kata sandi">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Google reCAPTCHA -->
                            <div class="d-flex flex-column mb-2">
                                {!! NoCaptcha::display() !!}
                                @if ($errors->has('g-recaptcha-response'))
                                    <span class="text-danger small">{{ $errors->first('g-recaptcha-response') }}</span>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end mb-3">
                                <a href="{{ route('forgot') }}" class="form-label fs-6 fw-bold mb-2 text-black">
                                    Lupa Kata Sandi?
                                </a>
                            </div>

                            <div class="d-grid my-4">
                                <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                                    <span class="indicator-label">Masuk</span>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-auto py-3 text-center">
        <p class="text-dark fw-bold p-0 m-0">© {{ date('Y') }} Pusat Data & Sistem Informasi Universitas Nurul Jadid</p>
        <p class="p-0 m-0">{{ request()->ip() }}</p>
    </footer>
</div>
<script src="{{ asset('assets/plugins/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
<!-- Tambahkan ini di bawah sebelum tag </body> -->
{!! NoCaptcha::renderJs() !!}

<script>
document.addEventListener("DOMContentLoaded", function() {
    const countdownEl = document.getElementById('countdown');
    const btnLogin = document.getElementById('kt_sign_in_submit');
    if (!countdownEl) return;

    let remaining = parseInt(countdownEl.dataset.seconds);

    // Disable tombol login selama terkunci
    btnLogin.disabled = true;

    const updateTimer = () => {
        const minutes = Math.floor(remaining / 60);
        const seconds = remaining % 60;
        countdownEl.textContent = ` (${minutes}:${seconds.toString().padStart(2, '0')})`;

        if (remaining <= 0) {
            btnLogin.disabled = false;
            window.location.reload(); // refresh agar bisa login lagi
        } else {
            remaining--;
            setTimeout(updateTimer, 1000);
        }
    };

    updateTimer();
});
</script>

</body>

</html>
