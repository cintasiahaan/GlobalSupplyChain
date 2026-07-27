<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun — Global Supply Chain Risk Intelligence</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            min-height: 100vh;
            background: #0f172a;
            color: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        .ambient-glow {
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(37,99,235,0.25) 0%, rgba(15,23,42,0) 70%);
            top: -200px;
            left: -200px;
            border-radius: 50%;
            pointer-events: none;
        }

        .auth-container {
            width: 100%;
            max-width: 960px;
            background: #1e293b;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 24px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5);
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            position: relative;
            z-index: 10;
        }

        .auth-banner {
            background: linear-gradient(135deg, #1d4ed8, #0f172a);
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand-icon {
            width: 48px;
            height: 48px;
            background: rgba(255,255,255,0.15);
            backdrop-filter: blur(10px);
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            border: 1px solid rgba(255,255,255,0.2);
        }

        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: white;
            line-height: 1.2;
        }

        .brand-title span {
            display: block;
            font-size: 11px;
            color: #93c5fd;
            font-weight: 500;
            text-transform: uppercase;
        }

        .banner-content {
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .banner-content h2 {
            font-size: 28px;
            font-weight: 800;
            color: white;
            margin-bottom: 14px;
        }

        .banner-content p {
            color: #bfdbfe;
            font-size: 14px;
            line-height: 1.6;
        }

        /* FORM SIDE */
        .auth-form-side {
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #0f172a;
        }

        .form-header {
            margin-bottom: 24px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: white;
        }

        .form-header p {
            color: #94a3b8;
            font-size: 14px;
            margin-top: 6px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            padding: 12px 16px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            font-size: 14px;
            color: white;
            font-family: inherit;
        }

        input:focus {
            outline: none;
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        }

        .error-box {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: 1px solid rgba(239, 68, 68, 0.3);
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            border: none;
            border-radius: 12px;
            background: #2563eb;
            color: white;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
            margin-top: 8px;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        .auth-footer {
            text-align: center;
            margin-top: 24px;
            font-size: 13px;
            color: #94a3b8;
        }

        .auth-footer a {
            color: #60a5fa;
            font-weight: 700;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .auth-container {
                grid-template-columns: 1fr;
            }
            .auth-banner {
                display: none;
            }
            .auth-form-side {
                padding: 32px 24px;
            }
        }
    </style>
</head>

<body>

    <div class="ambient-glow"></div>

    <div class="auth-container">
        <!-- LEFT BANNER -->
        <div class="auth-banner">
            <div class="brand-header">
                <div class="brand-icon">🌐</div>
                <div class="brand-title">
                    Global Supply
                    <span>Risk Intelligence Platform</span>
                </div>
            </div>

            <div class="banner-content">
                <h2>Bergabung dengan Platform Monitoring Supply Chain</h2>
                <p>Buat akun Anda sekarang untuk memantau data risiko negara, kondisi cuaca ekstrem, dan port congestion secara real-time.</p>
            </div>
        </div>

        <!-- RIGHT FORM -->
        <div class="auth-form-side">
            <div class="form-header">
                <h1>Buat Akun Baru ✨</h1>
                <p>Isi formulir di bawah untuk mendaftar akun pengguna.</p>
            </div>

            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>❌ {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.process') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Nama lengkap Anda"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="email@domain.com"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Ulangi kata sandi"
                        required
                    >
                </div>

                <button type="submit" class="btn-submit">
                    Daftar Sekarang ➔
                </button>
            </form>

            <div class="auth-footer">
                Sudah memiliki akun?
                <a href="{{ route('login') }}">Masuk di sini</a>
            </div>
        </div>
    </div>

</body>

</html>