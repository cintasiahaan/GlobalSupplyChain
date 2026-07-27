<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Global Risk Intelligence') — Supply Chain Risk Platform</title>

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <!-- Custom Enterprise Dashboard Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/custom-dashboard.css') }}">

    <script>
        // Early Theme Init to prevent page flicker
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark-mode');
            }
        })();

        function toggleTheme() {
            const currentTheme = document.documentElement.getAttribute('data-theme') || 'light';
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', newTheme);
            if (document.body) {
                document.body.classList.toggle('dark-mode', newTheme === 'dark');
            }
            document.documentElement.classList.toggle('dark-mode', newTheme === 'dark');
            localStorage.setItem('theme', newTheme);

            const iconBtn = document.getElementById('theme-toggle-icon');
            if (iconBtn) {
                iconBtn.innerText = newTheme === 'dark' ? '☀️' : '🌙';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark' && document.body) {
                document.body.classList.add('dark-mode');
            }
            const iconBtn = document.getElementById('theme-toggle-icon');
            if (iconBtn) {
                iconBtn.innerText = savedTheme === 'dark' ? '☀️' : '🌙';
            }
        });

        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar') || document.querySelector('.app-sidebar');
            const mainContent = document.querySelector('.main-content') || document.querySelector('.main-wrapper');
            if (sidebar) sidebar.classList.toggle('collapsed');
            if (mainContent) mainContent.classList.toggle('expanded');
        }
    </script>


    <style>
        :root {
            --font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --primary: #2563eb;
            --primary-hover: #1d4ed8;
            --primary-light: #eff6ff;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --sidebar-active: #2563eb;
            --sidebar-text: #94a3b8;
            --body-bg: #f8fafc;
            --card-bg: #ffffff;
            --text-dark: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --risk-low-bg: #dcfce7;
            --risk-low-text: #15803d;
            --risk-low-border: #86efac;
            --risk-medium-bg: #fef3c7;
            --risk-medium-text: #b45309;
            --risk-medium-border: #fde68a;
            --risk-high-bg: #fee2e2;
            --risk-high-text: #b91c1c;
            --risk-high-border: #fca5a5;
            --shadow-sm: 0 1px 3px rgba(15,23,42,0.06);
            --shadow-md: 0 4px 20px -2px rgba(15,23,42,0.08);
            --shadow-lg: 0 10px 30px -5px rgba(15,23,42,0.12);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-family);
            background: var(--bg-body, var(--body-bg));
            color: var(--text-main, var(--text-dark));
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }


        /* ==================================================
           SIDEBAR
        ================================================== */
        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 300px;
            height: 100vh;
            background: var(--sidebar-bg);
            color: white;
            padding: 24px 16px;
            overflow-y: auto;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-top {
            display: flex;
            flex-direction: column;
        }

        /* BRAND LOGO */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 14px;
            margin-bottom: 24px;
            text-decoration: none;
            color: white;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            padding-bottom: 20px;
        }

        .sidebar-brand-icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.4);
        }

        .sidebar-brand-text {
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -0.5px;
            line-height: 1.2;
        }

        .sidebar-brand-text span {
            display: block;
            font-size: 11px;
            color: var(--sidebar-text);
            font-weight: 500;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* SIDEBAR MENU */
        .menu-section-label {
            padding: 12px 14px 6px;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .sidebar-menu {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 16px;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .sidebar-menu a:hover {
            background: var(--sidebar-hover);
            color: #ffffff;
            transform: translateX(3px);
        }

        .sidebar-menu a.active {
            background: var(--primary);
            color: white;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }

        .menu-icon {
            width: 24px;
            text-align: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .menu-text {
            white-space: nowrap;
        }

        .admin-section {
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* SIDEBAR FOOTER USER CARD */
        .sidebar-user-card {
            background: rgba(30, 41, 59, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 14px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 20px;
        }

        .sidebar-avatar {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            background: linear-gradient(135deg, #6366f1, #3b82f6);
            color: white;
            font-weight: 700;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sidebar-user-info {
            flex-grow: 1;
            overflow: hidden;
        }

        .sidebar-user-name {
            font-size: 14px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .sidebar-user-role {
            font-size: 11px;
            color: #94a3b8;
            text-transform: capitalize;
        }

        .btn-logout-icon {
            background: rgba(239, 68, 68, 0.15);
            color: #f87171;
            border: none;
            padding: 8px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-logout-icon:hover {
            background: #ef4444;
            color: white;
        }

        /* ==================================================
           MAIN CONTENT & TOP HEADER
        ================================================== */
        .main-content {
            margin-left: 300px;
            min-height: 100vh;
            padding: 28px 36px;
            transition: all 0.3s ease;
        }

        .top-header {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 20px 28px;
            margin-bottom: 28px;
            box-shadow: var(--shadow-md);
            border: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .top-header-title h1 {
            font-size: 22px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .top-header-title p {
            color: var(--text-muted);
            font-size: 13px;
            margin-top: 2px;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 14px;
            background: #f1f5f9;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background: #22c55e;
            border-radius: 50%;
            box-shadow: 0 0 8px #22c55e;
        }

        .header-user-badge {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 6px 14px 6px 6px;
            background: #f8fafc;
            border: 1px solid var(--border-color);
            border-radius: 30px;
        }

        .header-avatar {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .header-user-name {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-dark);
        }

        .header-role-tag {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 10px;
            background: #e2e8f0;
            color: #475569;
        }

        /* ALERT NOTIFICATIONS */
        .alert-box {
            padding: 14px 20px;
            border-radius: 14px;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: var(--shadow-sm);
        }

        .alert-success {
            background: var(--risk-low-bg);
            color: var(--risk-low-text);
            border: 1px solid var(--risk-low-border);
        }

        .alert-error {
            background: var(--risk-high-bg);
            color: var(--risk-high-text);
            border: 1px solid var(--risk-high-border);
        }

        /* COMMON UI COMPONENTS */
        .page-header {
            margin-bottom: 24px;
        }

        .page-header h1 {
            font-size: 24px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -0.5px;
        }

        .page-header p {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 4px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-bottom: 24px;
        }

        .card {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 22px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            transition: all 0.25s ease;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
            transform: translateY(-2px);
        }

        .card-title {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .card-number {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            letter-spacing: -1px;
        }

        .table-container {
            background: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 24px;
        }

        .table-container h2 {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 16px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8fafc;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
        }

        td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: var(--text-dark);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #f8fafc;
        }

        /* BUTTONS */
        .btn-ui {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-ui-primary {
            background: var(--primary);
            color: white;
        }

        .btn-ui-primary:hover {
            background: var(--primary-hover);
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
        }

        .btn-ui-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-ui-warning:hover {
            background: #d97706;
        }

        .btn-ui-danger {
            background: #ef4444;
            color: white;
        }

        .btn-ui-danger:hover {
            background: #dc2626;
        }

        .btn-ui-secondary {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-ui-secondary:hover {
            background: #cbd5e1;
        }

        /* BADGES */
        .badge-risk {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-risk-low {
            background: var(--risk-low-bg);
            color: var(--risk-low-text);
            border: 1px solid var(--risk-low-border);
        }

        .badge-risk-medium {
            background: var(--risk-medium-bg);
            color: var(--risk-medium-text);
            border: 1px solid var(--risk-medium-border);
        }

        .badge-risk-high {
            background: var(--risk-high-bg);
            color: var(--risk-high-text);
            border: 1px solid var(--risk-high-border);
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .sidebar {
                width: 250px;
            }
            .main-content {
                margin-left: 250px;
                padding: 20px;
            }
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
            }
            .main-content {
                margin-left: 0;
                padding: 16px;
            }
            .top-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body>

    <!-- SIDEBAR NAVIGATION -->
    <aside class="sidebar">
        <div class="sidebar-top">
            <!-- BRAND -->
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                <div class="sidebar-brand-icon">🌐</div>
                <div class="sidebar-brand-text">
                    Global Supply
                    <span>Risk Intelligence</span>
                </div>
            </a>

            <!-- NAVIGATION -->
            <nav class="sidebar-menu">
                <div class="menu-section-label">Main Navigation</div>

                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">📊</span>
                    <span class="menu-text">Dashboard</span>
                </a>

                <a href="{{ route('countries.index') }}" class="{{ request()->routeIs('countries.index') || request()->routeIs('countries.show') ? 'active' : '' }}">
                    <span class="menu-icon">🌍</span>
                    <span class="menu-text">Country Monitoring</span>
                </a>

                <a href="{{ route('countries.compare') }}" class="{{ request()->routeIs('countries.compare') ? 'active' : '' }}">
                    <span class="menu-icon">⚔️</span>
                    <span class="menu-text">Country Comparison</span>
                </a>

                <div class="menu-section-label">Supply Chain Intelligence</div>

                <a href="{{ route('weather.index') }}" class="{{ request()->routeIs('weather.*') ? 'active' : '' }}">
                    <span class="menu-icon">🌦️</span>
                    <span class="menu-text">Weather Monitoring</span>
                </a>

                <a href="{{ route('currency-impact.index') }}" class="{{ request()->routeIs('currency-impact.*') ? 'active' : '' }}">
                    <span class="menu-icon">💱</span>
                    <span class="menu-text">Currency Impact</span>
                </a>

                <a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.*') ? 'active' : '' }}">
                    <span class="menu-icon">📰</span>
                    <span class="menu-text">News Intelligence</span>
                </a>

                <a href="{{ route('ports.index') }}" class="{{ request()->routeIs('ports.*') ? 'active' : '' }}">
                    <span class="menu-icon">⚓</span>
                    <span class="menu-text">Port Monitoring</span>
                </a>

                <a href="{{ route('analytics.index') }}" class="{{ request()->routeIs('analytics.*') ? 'active' : '' }}">
                    <span class="menu-icon">📈</span>
                    <span class="menu-text">Analytics</span>
                </a>

                <a href="{{ route('watchlist.index') }}" class="{{ request()->routeIs('watchlist.*') ? 'active' : '' }}">
                    <span class="menu-icon">⭐</span>
                    <span class="menu-text">Watchlist</span>
                </a>

                <!-- ADMIN SECTION -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="admin-section">
                        <div class="menu-section-label">Administrator</div>

                        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <span class="menu-icon">🛠️</span>
                            <span class="menu-text">Admin Control Panel</span>
                        </a>

                        <a href="{{ route('admin.user-logs.index') }}" class="{{ request()->routeIs('admin.user-logs.*') ? 'active' : '' }}">
                            <span class="menu-icon">🔐</span>
                            <span class="menu-text">User Login Logs</span>
                        </a>

                        <a href="{{ route('admin.risk-assessments.index') }}" class="{{ request()->routeIs('admin.risk-assessments.*') ? 'active' : '' }}">
                            <span class="menu-icon">📋</span>
                            <span class="menu-text">Risk Assessments</span>
                        </a>

                        <a href="{{ route('admin.articles.index') }}" class="{{ request()->routeIs('admin.articles.*') ? 'active' : '' }}">
                            <span class="menu-icon">📝</span>
                            <span class="menu-text">Kelola Artikel</span>
                        </a>

                        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                            <span class="menu-icon">⚙️</span>
                            <span class="menu-text">Settings</span>
                        </a>
                    </div>
                @endif
            </nav>

        </div>

        <!-- SIDEBAR FOOTER LOGOUT CARD -->
        @auth
            <div class="sidebar-user-card">
                <div class="sidebar-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name">{{ auth()->user()->name }}</div>
                    <div class="sidebar-user-role">{{ auth()->user()->role }}</div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="btn-logout-icon" title="Logout dari sistem">
                        🚪
                    </button>
                </form>
            </div>
        @endauth
    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content">
        <!-- TOP HEADER -->
        <header class="top-header">
            <div class="top-header-title" style="display: flex; align-items: center; gap: 12px;">
                <button class="btn-icon-square" onclick="toggleSidebar()" title="Toggle Navigation Sidebar" type="button" style="margin-right: 4px;">
                    ☰
                </button>
                <div>
                    <h1>Global Risk Intelligence</h1>
                    <p>International Supply Chain & Geo-Risk Monitoring Dashboard</p>
                </div>
            </div>

            <div class="header-actions">
                <button class="btn-icon-square" onclick="toggleTheme()" title="Toggle Dark / Light Theme" type="button">
                    <span id="theme-toggle-icon">🌙</span>
                </button>

                <div class="status-pill">
                    <div class="status-dot"></div> Live Monitoring Active
                </div>

                @auth
                    <div class="header-user-badge">
                        <div class="header-avatar">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="header-user-name">{{ auth()->user()->name }}</div>
                        </div>
                        <span class="header-role-tag">{{ auth()->user()->role }}</span>
                    </div>

                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-ui" style="background: rgba(239, 68, 68, 0.15); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.3); font-weight: 700; cursor: pointer; padding: 6px 12px; border-radius: 8px; font-size: 13px; display: inline-flex; align-items: center; gap: 6px;" title="Logout dari akun">
                            🚪 Logout
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn-ui btn-ui-primary">🔐 Login</a>
                    <a href="{{ route('register') }}" class="btn-ui btn-ui-secondary">✏️ Register</a>
                @endauth
            </div>

        </header>

        <!-- GLOBAL FLASH ALERTS -->
        @if(session('success'))
            <div class="alert-box alert-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-box alert-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        <!-- PAGE CONTENT -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </main>

</body>

</html>