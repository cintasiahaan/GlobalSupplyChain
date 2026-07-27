<aside class="sidebar">

    {{-- ==========================================
         SIDEBAR BRAND
    =========================================== --}}

    <div class="sidebar-brand">

        <span class="sidebar-brand-icon">
            🌍
        </span>

        <span>
            Global Risk
        </span>

    </div>


    {{-- ==========================================
         SIDEBAR MENU
    =========================================== --}}

    <nav class="sidebar-menu">


        {{-- DASHBOARD --}}

        <a
            href="{{ url('/') }}"
            class="{{ request()->is('/') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                📊
            </span>

            <span>
                Dashboard
            </span>

        </a>


        {{-- COUNTRY MONITORING --}}

        <a
            href="{{ url('/countries') }}"
            class="{{ request()->is('countries*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                🌎
            </span>

            <span>
                Country Monitoring
            </span>

        </a>


        {{-- WEATHER MONITORING --}}

        <a
            href="{{ url('/weather') }}"
            class="{{ request()->is('weather*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                🌦️
            </span>

            <span>
                Weather Monitoring
            </span>

        </a>


        {{-- CURRENCY IMPACT --}}

        <a
            href="{{ url('/currency') }}"
            class="{{ request()->is('currency*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                💱
            </span>

            <span>
                Currency Impact
            </span>

        </a>


        {{-- NEWS INTELLIGENCE --}}

        <a
            href="{{ url('/news') }}"
            class="{{ request()->is('news*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                📰
            </span>

            <span>
                News Intelligence
            </span>

        </a>


        {{-- PORT MONITORING --}}

        <a
            href="{{ url('/ports') }}"
            class="{{ request()->is('ports*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                ⚓
            </span>

            <span>
                Port Monitoring
            </span>

        </a>


        {{-- ANALYTICS --}}

        <a
            href="{{ url('/analytics') }}"
            class="{{ request()->is('analytics*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                📈
            </span>

            <span>
                Analytics
            </span>

        </a>


        {{-- WATCHLIST --}}

        <a
            href="{{ url('/watchlist') }}"
            class="{{ request()->is('watchlist*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                ⭐
            </span>

            <span>
                Watchlist
            </span>

        </a>


        {{-- SETTINGS --}}

        <a
            href="{{ url('/settings') }}"
            class="{{ request()->is('settings*') ? 'active' : '' }}"
        >

            <span class="sidebar-icon">
                ⚙️
            </span>

            <span>
                Settings
            </span>

        </a>


    </nav>

</aside>