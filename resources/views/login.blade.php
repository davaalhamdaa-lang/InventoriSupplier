<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - MBG Inventory</title>

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">

    <style>

        body{
            background:var(--bg);

            display:flex;
            justify-content:center;
            align-items:center;

            min-height:100vh;

            padding:24px;
        }

        .login-wrapper{
            width:100%;
            max-width:1100px;

            display:grid;
            grid-template-columns:1fr 480px;

            background:white;

            border-radius:32px;

            overflow:hidden;

            box-shadow:
            0 20px 50px rgba(15,23,42,.08);
        }

        /* ==================================
           LEFT PANEL
        ================================== */

        .login-banner{

            background:var(--gradient);

            color:white;

            padding:60px;

            display:flex;
            flex-direction:column;
            justify-content:center;

            position:relative;

            overflow:hidden;
        }

        .login-banner::before{
            content:'';

            position:absolute;

            width:500px;
            height:500px;

            right:-200px;
            top:-100px;

            border-radius:50%;

            background:
            rgba(255,255,255,.08);
        }

        .login-logo{

            width:72px;
            height:72px;

            border-radius:22px;

            background:rgba(255,255,255,.15);

            display:flex;
            align-items:center;
            justify-content:center;

            margin-bottom:24px;

            backdrop-filter:blur(10px);
        }

        .login-logo svg{
            width:36px;
            height:36px;
            fill:white;
        }

        .login-banner h1{
            font-size:40px;
            font-weight:800;
            line-height:1.2;

            margin-bottom:16px;
        }

        .login-banner p{
            font-size:16px;
            line-height:1.7;

            opacity:.9;

            max-width:420px;
        }

        /* ==================================
           RIGHT PANEL
        ================================== */

        .login-card{
            padding:50px;
            background:white;

            display:flex;
            flex-direction:column;
            justify-content:center;
        }

        .login-header{
            margin-bottom:30px;
        }

        .login-header h2{
            font-size:30px;
            font-weight:800;
            color:var(--text);

            margin-bottom:8px;
        }

        .login-header p{
            color:var(--text-soft);
        }

        .alert{
            background:var(--danger-bg);

            border:1px solid var(--danger-border);

            color:var(--danger);

            padding:14px;

            border-radius:14px;

            margin-bottom:20px;

            font-size:14px;
            font-weight:600;
        }

        .form-group{
            margin-bottom:20px;
        }

        .form-group label{
            display:block;

            margin-bottom:8px;

            font-size:13px;
            font-weight:600;

            color:var(--text-soft);
        }

        .pin-input{
            text-align:center;

            letter-spacing:10px;

            font-size:26px !important;
            font-weight:700;
        }

        .helper-text{
            font-size:12px;
            color:var(--text-light);
            margin-top:6px;
        }

        .btn-login{
            width:100%;

            height:54px;

            border:none;

            border-radius:14px;

            background:var(--gradient);

            color:white;

            font-size:15px;
            font-weight:700;

            cursor:pointer;

            transition:.25s ease;

            box-shadow:
            0 10px 25px rgba(37,99,235,.25);
        }

        .btn-login:hover{
            transform:translateY(-2px);
        }

        .login-footer{
            margin-top:24px;

            text-align:center;

            font-size:12px;

            color:var(--text-soft);
        }

        .pin-wrapper {
    position: relative;
    display: block;
    width: 100%; /* Sesuaikan dengan desain layout Anda */
}

.pin-input {
    width: 100%;
    padding-right: 40px; /* Memberikan ruang di kanan agar teks tidak tertimpa ikon */
    /* Pertahankan style CSS .pin-input bawaan Anda di bawah sini */
}
/* Menyembunyikan icon mata bawaan browser (Edge) */
input.pin-input::-ms-reveal,
input.pin-input::-ms-clear {
    display: none;
}

.toggle-pin {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: transparent;
    border: none;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0;
}

.toggle-pin:hover svg {
    stroke: #374151; /* Warna ikon berubah sedikit lebih gelap saat di-hover */
}

        /* ==================================
           MOBILE
        ================================== */

        @media(max-width:900px){

            .login-wrapper{
                grid-template-columns:1fr;
                max-width:500px;
            }

            .login-banner{
                display:none;
            }

            .login-card{
                padding:32px;
            }

        }

    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pinInput = document.getElementById('pinInput');
            const togglePinBtn = document.getElementById('togglePinBtn');
            const eyeShow = document.getElementById('eyeShow');
            const eyeHide = document.getElementById('eyeHide');

            togglePinBtn.addEventListener('click', function() {
                if (pinInput.type === 'password') {
                    pinInput.type = 'text';
                    eyeShow.style.display = 'none';
                    eyeHide.style.display = 'block';
                } else {
                    pinInput.type = 'password';
                    eyeShow.style.display = 'block';
                    eyeHide.style.display = 'none';
                }
            });
        });</script>
</head>
<body>

<div class="login-wrapper">

    <!-- LEFT SIDE -->

    <div class="login-banner">

        <div class="login-logo">

            <svg viewBox="0 0 24 24">
                <path d="M3 7L12 2L21 7V17L12 22L3 17V7Z"/>
            </svg>

        </div>

        <h1>
            MBG Inventory System
        </h1>

        <p>
            Sistem Inventori dan Distribusi untuk pengelolaan stok,
            mutasi barang, serta monitoring operasional MBG secara
            terpusat dan real-time.
        </p>

    </div>

    <!-- RIGHT SIDE -->

    <div class="login-card">

        <div class="login-header">

            <h2>Masuk Sistem</h2>

            <p>
                Silakan masuk menggunakan PIN akses Anda.
            </p>

        </div>

        @if($errors->any())
            <div class="alert">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="/login" method="POST">

            @csrf

            <div class="form-group">

                <label>
                    PIN Akses (4 Digit)
                </label>

               <div class="pin-wrapper">
    <input 
        type="password" 
        name="pin" 
        id="pinInput"
        required 
        maxlength="4" 
        pattern="\d{4}" 
        placeholder="••••" 
        class="pin-input"
    >
    <button type="button" class="toggle-pin" id="togglePinBtn" tabindex="-1">
        <!-- Ikon Mata Terbuka (Default) -->
        <svg id="eyeShow" viewBox="0 0 24 24" width="20" height="20" stroke="#6b7280" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
            <circle cx="12" cy="12" r="3"></circle>
        </svg>
        <!-- Ikon Mata Tercoret (Tersembunyi by default) -->
        <svg id="eyeHide" viewBox="0 0 24 24" width="20" height="20" stroke="#6b7280" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" style="display: none;">
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
            <line x1="1" y1="1" x2="23" y2="23"></line>
        </svg>
    </button>
</div>

                <div class="helper-text">
                    Masukkan PIN operator atau administrator.
                </div>

            </div>

            <div class="form-group">

                <label>
                    Kata Sandi Admin
                </label>

                <input
                    type="password"
                    name="password"
                    placeholder="Kosongkan jika Operator">

                <div class="helper-text">
                    Hanya diperlukan untuk akun Administrator.
                </div>

            </div>

            <button type="submit" class="btn-login">
                Masuk ke Dashboard
            </button>

        </form>

        <div class="login-footer">
            MBG Inventory System © {{ date('Y') }}
        </div>

    </div>

</div>

</body>
</html>

