<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Global Supply Chain Risk Intelligence</title>

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

        /* Ambient Glow background */
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

        .ambient-glow-2 {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(99,102,241,0.2) 0%, rgba(15,23,42,0) 70%);
            bottom: -150px;
            right: -150px;
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
            background: linear-gradient(135deg, #1d4ed8, #1e1b4b);
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .auth-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 80% 20%, rgba(59,130,246,0.3) 0%, transparent 60%);
        }

        .brand-header {
            display: flex;
            align-items: center;
            gap: 14px;
            position: relative;
            z-index: 2;
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
            letter-spacing: 0.5px;
        }

        .banner-content {
            position: relative;
            z-index: 2;
            margin-top: 40px;
            margin-bottom: 40px;
        }

        .banner-content h2 {
            font-size: 28px;
            font-weight: 800;
            line-height: 1.3;
            color: white;
            margin-bottom: 14px;
        }

        .banner-content p {
            color: #bfdbfe;
            font-size: 14px;
            line-height: 1.6;
        }

        .feature-pills {
            display: flex;
            flex-direction: column;
            gap: 12px;
            position: relative;
            z-index: 2;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(8px);
            padding: 10px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.12);
            font-size: 13px;
            color: #e0f2fe;
            font-weight: 600;
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
            margin-bottom: 28px;
        }

        .form-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: white;
            letter-spacing: -0.5px;
        }

        .form-header p {
            color: #94a3b8;
            font-size: 14px;
            margin-top: 6px;
        }

        .demo-box {
            background: #1e293b;
            border: 1px dashed rgba(59, 130, 246, 0.4);
            border-radius: 14px;
            padding: 14px 16px;
            margin-bottom: 24px;
        }

        .demo-box-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #60a5fa;
            margin-bottom: 10px;
        }

        .demo-buttons {
            display: flex;
            gap: 10px;
        }

        .btn-demo {
            flex: 1;
            padding: 8px 12px;
            background: rgba(59, 130, 246, 0.15);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: #93c5fd;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s ease;
            text-align: center;
        }

        .btn-demo:hover {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: #cbd5e1;
        }

        input {
            width: 100%;
            padding: 14px 16px;
            background: #1e293b;
            border: 1px solid #334155;
            border-radius: 12px;
            font-size: 14px;
            color: white;
            font-family: inherit;
            transition: all 0.2s ease;
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
            font-weight: 600;
        }

        .success-box {
            background: rgba(34, 197, 94, 0.15);
            color: #4ade80;
            border: 1px solid rgba(34, 197, 94, 0.3);
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            font-weight: 600;
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
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.4);
        }

        .btn-submit:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
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

        .auth-footer a:hover {
            text-decoration: underline;
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
    <div class="ambient-glow-2"></div>

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
                <h2>Real-Time Supply Chain Monitoring & Risk Intelligence</h2>
                <p>Pantau risiko geopolitik, cuaca ekstrem, volatilitas mata uang, dan gangguan pelabuhan internasional dalam satu dasbor terpadu.</p>
            </div>

            <div class="feature-pills">
                <div class="feature-item">
                    <span>🗺️</span> Global Geo-Risk Mapping & Country Scorecards
                </div>
                <div class="feature-item">
                    <span>⚓</span> Port Congestion & Delay Tracking
                </div>
                <div class="feature-item">
                    <span>💱</span> Real-Time Currency Exchange Volatility Impact
                </div>
            </div>
        </div>

        <!-- RIGHT FORM -->
        <div class="auth-form-side">
            <div class="form-header">
                <h1>Selamat Datang Kembali 👋</h1>
                <p>Masukkan akun Anda untuk mengakses dasbor risiko.</p>
            </div>

            <!-- DEMO LOGIN QUICK FILL -->
            <div class="demo-box">
                <div class="demo-box-label">⚡ Demo Quick Fill (Pilih Akun):</div>
                <div class="demo-buttons">
                    <button type="button" class="btn-demo" onclick="fillCreds('admin@gmail.com', 'admin123')">
                        🛠️ Admin Account
                    </button>
                    <button type="button" class="btn-demo" onclick="fillCreds('user@gmail.com', 'user123')">
                        👤 User Account
                    </button>
                </div>
            </div>

            @if(session('success'))
                <div class="success-box">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="error-box">
                    @foreach($errors->all() as $error)
                        <div>❌ {{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="contoh: admin@gmail.com"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Kata Sandi</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="••••••••"
                        required
                    >
                </div>

                <button type="submit" class="btn-submit">
                    Masuk ke Sistem ➔
                </button>
            </form>

            <div class="auth-footer">
                Belum memiliki akun?
                <a href="{{ route('register') }}">Daftar Akun Baru</a>
            </div>
        </div>
    </div>

    <script>
        function fillCreds(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
        }
    </script>

</body>

</html>