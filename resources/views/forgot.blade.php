<!DOCTYPE html>
<html lang="id" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Simpeg PT. Nusantara Teknologi Solusi</title>
    <link rel="icon" href="{{ asset('assets/media/logos/favicon.png') }}" type="image/x-icon">
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

                        <!-- Form Kirim OTP -->
                        <form class="w-lg-500px w-sm-500px p-10 bg-white rounded-3 shadow" novalidate="novalidate"
                              id="kt_sign_in_form" method="POST">
                            @csrf
                            <input type="hidden" name="recaptcha_token" id="recaptcha_token">

                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-4">Masuk</h1>
                            </div>

                            <!-- Alert untuk pesan error -->
                            <div id="alert" class="alert alert-danger d-none"></div>

                            <div class="d-flex flex-column mb-2">
                                <label class="form-label fs-6 fw-bold mb-2">
                                    <span class="required">Gmail</span>
                                </label>
                                <input type="email" placeholder="Masukkan gmail" name="email" id="email"
                                       autocomplete="off" class="form-control bg-transparent" required>
                            </div>
                            <div class="d-grid my-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Kirim OTP</span>
                                </button>
                            </div>
                        </form>

                        <!-- Form Verifikasi OTP (Awalnya Disembunyikan) -->
                        <form class="w-lg-500px w-sm-500px p-10 bg-white rounded-3 shadow d-none" id="otpform">
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-4">Verifikasi OTP</h1>
                            </div>
                            <input type="hidden" name="email" id="otp-email">


                            <div id="alert-otp" class="alert alert-danger d-none"></div>
                            <p id="masked-email" class="text-muted mb-4 text-center"></p>

                            <div class="d-flex flex-column mb-2">
                                <label class="form-label fs-6 fw-bold mb-2">
                                    <span class="required">Kode OTP</span>
                                </label>
                                <input type="text" placeholder="Masukkan kode OTP" name="otp" id="otp"
                                       autocomplete="off" class="form-control bg-transparent" required>
                            </div>
                            <div class="d-grid my-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Verifikasi OTP</span>
                                </button>
                            </div>
                        </form>

                        <!-- Form Reset Password (Awalnya Disembunyikan) -->
                        <form class="w-lg-500px w-sm-500px p-10 bg-white rounded-3 shadow d-none" id="resetpassword">
                            <div class="text-center mb-11">
                                <h1 class="text-dark fw-bolder mb-4">Reset Password</h1>
                            </div>

                            <div id="alert-reset" class="alert alert-danger d-none"></div>

                            <div class="d-flex flex-column mb-2">
                                <label class="form-label fs-6 fw-bold mb-2">
                                    <span class="required">Password Baru</span>
                                </label>
                                <input type="password" placeholder="Masukkan password baru" name="new_password" id="newpassword"
                                       class="form-control bg-transparent" required>
                            </div>
                            <div class="d-flex flex-column mb-2">
                                <label class="form-label fs-6 fw-bold mb-2">
                                    <span class="required">Konfirmasi Password</span>
                                </label>
                                <input type="password" placeholder="Konfirmasi password baru" name="new_password_confirmation" id="confirmpassword"
                                       class="form-control bg-transparent" required>
                            </div>
                            <div class="d-grid my-4">
                                <button type="submit" class="btn btn-primary">
                                    <span class="indicator-label">Reset Password</span>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="mt-auto py-3 text-center">
        <p class="text-dark fw-bold p-0 m-0">© {{ date('Y') }} Pusat Data & Sistem Informasi PT. Nusantara Teknologi Solusi</p>
        <p class="p-0 m-0">{{ request()->ip() }}</p>
    </footer>
</div>
<script src="{{ asset('assets/plugins/plugins.bundle.js') }}"></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}"></script>
</body>
</html>
<script>
     // letakkan di luar try biar efisien

    // Form Kirim OTP
document.querySelector("#kt_sign_in_form").addEventListener("submit", async function(e) {
    e.preventDefault();

    const email = document.querySelector("#email").value;
    const alert = document.getElementById("alert");

    try {
        const response = await fetch("http://127.0.0.1:8000/api/send", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({ email })
        });

        const result = await response.json();
        console.log("Status:", response.status);
        console.log("Result:", result);

        if (response.ok) {
           localStorage.setItem("reset_email", email);
            document.getElementById("kt_sign_in_form").classList.add("d-none");
            document.getElementById("otpform").classList.remove("d-none");
            alert.classList.add("d-none");

            // 🔹 Tambahkan ini agar masking email muncul
            const masked = maskEmail(email);
            document.getElementById("masked-email").innerText = "Kode OTP telah dikirim ke " + masked;
        } else {
            alert.classList.remove("d-none");
            alert.innerText = result.message || "Kirim OTP gagal.";
        }
    } catch (err) {
        alert.classList.remove("d-none");
        alert.innerText = "Terjadi kesalahan jaringan.";
        console.error("Error:", err);
    }
});

// Form Verifikasi OTP
document.querySelector("#otpform").addEventListener("submit", async function(e) {
    e.preventDefault();

    const otp = document.querySelector("#otp").value;
    const alert = document.getElementById("alert-otp");
    const email = localStorage.getItem("reset_email");

    try {
        const response = await fetch("http://127.0.0.1:8000/api/verifikasii", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({
                otp: otp,
                email: email   // <-- WAJIB ADA
            })

        });

        const result = await response.json();
        console.log("Status:", response.status);
        console.log("Result:", result);

        if (response.ok) {
            localStorage.setItem("verif_otp", otp);
            document.getElementById("otpform").classList.add("d-none");
            document.getElementById("resetpassword").classList.remove("d-none");
            alert.classList.add("d-none");
        } else {
            alert.classList.remove("d-none");
            alert.innerText = result.message || "Verifikasi OTP gagal.";
        }
    } catch (err) {
        alert.classList.remove("d-none");
        alert.innerText = "Terjadi kesalahan jaringan.";
        console.error("Error:", err);
    }
});

// Form Reset Password
document.querySelector("#resetpassword").addEventListener("submit", async function(e) {
    e.preventDefault();

    const email = localStorage.getItem("reset_email");
    const otp = localStorage.getItem("verif_otp");
    const new_password = document.querySelector("#newpassword").value;
    const new_password_confirmation = document.querySelector("#confirmpassword").value;
    const alert = document.getElementById("alert-reset");

    try {
        const response = await fetch("http://127.0.0.1:8000/api/reset-password", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "Accept": "application/json",
            },
            body: JSON.stringify({
                email,
                otp,
                new_password,
                new_password_confirmation
            })
        });

        const result = await response.json();
        console.log("Status:", response.status);
        console.log("Result:", result);

        if (response.ok) {
            localStorage.removeItem("reset_email");
            localStorage.removeItem("verif_otp");
            alert.classList.add("d-none");
            window.location.href = "/";
        } else {
            alert.classList.remove("d-none");
            alert.innerText = result.message || "Reset Password gagal.";
        }
    } catch (err) {
        alert.classList.remove("d-none");
        alert.innerText = "Terjadi kesalahan jaringan.";
        console.error("Error:", err);
    }
});
function maskEmail(email) {
    if (!email || !email.includes('@')) return '';
    const [user, domain] = email.split('@');
    const maskedUser = user[0] + '*'.repeat(Math.max(0, user.length - 2)) + user.slice(-1);
    return maskedUser + '@' + domain;
}

</script>
