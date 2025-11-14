<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kode OTP</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #0d1b2a, #1b263b);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: "Segoe UI", Arial, sans-serif;
        }

        .email-container {
            width: 100%;
            max-width: 600px;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            margin: 20px auto;
            transition: 0.3s ease-in-out;
        }

        .header {
            background: linear-gradient(135deg, #1b263b, #415a77);
            padding: 30px;
            text-align: center;
            color: #f5f5f5;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: 1px;
            border-bottom: 2px solid #e0c27b;
        }

        .content {
            padding: 35px;
            font-size: 16px;
            line-height: 1.7;
            color: #222;
            text-align: center;
        }

        .otp-code {
            font-size: 40px;
            font-weight: bold;
            color: #c59d3f;
            margin: 25px 0;
            letter-spacing: 7px;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.25);
        }

        .footer {
            font-size: 14px;
            color: #444;
            text-align: center;
            padding: 22px;
            background-color: #f5f5f5;
            border-top: 1px solid #ddd;
        }

        @media screen and (max-width: 600px) {
            .email-container {
                width: 92% !important;
            }
            .header,
            .content {
                padding: 25px;
            }
            .content {
                font-size: 15px;
            }
            .otp-code {
                font-size: 30px;
                letter-spacing: 5px;
            }
        }
    </style>

</head>

<body>

<div class="email-container">
    <div class="header">
        Kode OTP Anda
    </div>
    <div class="content">
       <p>Kami telah mengirimkan kode ke email Anda:</p>
        <p><strong>{{ $email }}</strong></p>
        <p>Gunakan kode OTP berikut untuk verifikasi Anda. Kode ini berlaku selama {{ $expired_in }}:</p>
        <div class="otp-code">
            {{ $otp }}
        </div>
        <p>Jangan berikan kode ini kepada siapa pun. Jika Anda tidak meminta OTP, abaikan email ini.</p>
    </div>

    <div class="footer">
        &copy; 2025 PT. Nusantara Teknologi Solusi
    </div>
</div>

</body>

</html>
