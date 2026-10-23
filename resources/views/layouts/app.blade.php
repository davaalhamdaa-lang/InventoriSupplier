<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'MBG Inventory')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/global.css') }}">
</head>
<body>

    <!-- MOBILE OVERLAY -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">

        <!-- BRAND -->
        <div class="brand">

            <div class="brand-logo">
                <svg viewBox="0 0 24 24">
                    <path d="M3 7L12 2L21 7V17L12 22L3 17V7Z"></path>
                </svg>
            </div>

            <div class="brand-content">
                <strong>MBG Inventory</strong>
                <small>Inventory System</small>
            </div>

        </div>

        <nav>

            <!-- DASHBOARD -->
            <a href="{{ url('/dashboard') }}"
               class="{{ request()->is('dashboard') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="5"></rect>
                    <rect x="14" y="12" width="7" height="9"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>

                <span>Dashboard</span>
            </a>

            <!-- MASTER DATA -->
            <div class="menu-title">
                Master Data
            </div>

            <!-- KATEGORI -->
            <a href="{{ url('/kategori') }}"
               class="{{ request()->is('kategori') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24">
                    <rect x="3" y="3" width="8" height="8"></rect>
                    <rect x="13" y="3" width="8" height="8"></rect>
                    <rect x="3" y="13" width="8" height="8"></rect>
                    <rect x="13" y="13" width="8" height="8"></rect>
                </svg>

                <span>Data Kategori</span>
            </a>

            <!-- BARANG -->
            <a href="{{ url('/barang') }}"
               class="{{ request()->is('barang') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24">
                    <path d="M21 8L12 3L3 8"></path>
                    <path d="M3 8V16L12 21L21 16V8"></path>
                    <path d="M12 21V12"></path>
                </svg>

                <span>Data Barang</span>
            </a>

            <!-- KLIEN -->
            <a href="{{ url('/klien') }}"
               class="{{ request()->is('klien') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24">
                    <rect x="4" y="3" width="16" height="18"></rect>
                    <path d="M8 7H16"></path>
                    <path d="M8 11H16"></path>
                    <path d="M8 15H12"></path>
                </svg>

                <span>Data Klien</span>
            </a>

            <!-- OPERASIONAL -->
            <div class="menu-title">
                Operasional
            </div>

            <!-- TRANSAKSI -->
            <a href="{{ url('/transaksi') }}"
               class="{{ request()->is('transaksi') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24">
                    <path d="M7 7H21"></path>
                    <path d="M17 3L21 7L17 11"></path>

                    <path d="M17 17H3"></path>
                    <path d="M7 13L3 17L7 21"></path>
                </svg>

                <span>Distribusi Mutasi</span>
            </a>

            <!-- LAPORAN -->
            <a href="{{ url('/laporan') }}"
               class="{{ request()->is('laporan') ? 'active' : '' }}">

                <svg viewBox="0 0 24 24">
                    <path d="M7 8H17"></path>
                    <path d="M7 12H17"></path>
                    <path d="M7 16H13"></path>

                    <rect x="5" y="3" width="14" height="18"></rect>
                </svg>

                <span>Laporan & Export</span>
            </a>

            @if(auth()->user()->role === 'ADMIN')

                <div class="menu-title">
                    Sistem Admin
                </div>

                <a href="{{ url('/users') }}"
                   class="{{ request()->is('users') ? 'active' : '' }}">

                    <svg viewBox="0 0 24 24">
                        <circle cx="9" cy="8" r="3"></circle>
                        <circle cx="17" cy="8" r="3"></circle>

                        <path d="M3 20C3 16.5 6 14 9 14"></path>
                        <path d="M21 20C21 16.5 18 14 15 14"></path>
                    </svg>

                    <span>Manajemen Operator</span>
                </a>

            @endif

        </nav>

       <!-- LOGOUT -->
        <div class="logout-wrapper">
            <form method="POST" action="{{ url('/logout') }}">
                @csrf
                <a href="{{ url('/logout') }}" class="logout-link" 
                   onclick="event.preventDefault(); this.closest('form').submit();">
                    
                    <svg viewBox="0 0 24 24">
                        <path d="M9 21H5C3.9 21 3 20.1 3 19V5C3 3.9 3.9 3 5 3H9"></path>
                        <path d="M16 17L21 12L16 7"></path>
                        <path d="M21 12H9"></path>
                    </svg>

                    <span>Keluar Akun</span>

                </a>
            </form>
        </div>

    </aside>

    <!-- MAIN CONTENT -->
    <main class="main-content" id="mainContent">

        <!-- TOPBAR -->
        <div class="topbar">

            <div class="topbar-left">

                <button class="menu-toggle" id="menuToggle">

                    <svg viewBox="0 0 24 24">
                        <path d="M3 6H21"></path>
                        <path d="M3 12H21"></path>
                        <path d="M3 18H21"></path>
                    </svg>

                </button>

                <div>
                    <h2>@yield('title', 'Dashboard')</h2>

                    <div class="subtitle">
                        Sistem Inventori & Distribusi MBG
                    </div>
                </div>

            </div>

            <div class="user-avatar">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>

        </div>

        @yield('content')

    </main>

    <!-- SIDEBAR SCRIPT -->
    <script>

        const sidebar =
            document.getElementById('sidebar');

        const mainContent =
            document.getElementById('mainContent');

        const toggle =
            document.getElementById('menuToggle');

        const overlay =
            document.getElementById('sidebarOverlay');

        toggle.addEventListener('click', () => {

            if(window.innerWidth <= 768){

                sidebar.classList.toggle('show');

                if(sidebar.classList.contains('show')){
                    overlay.style.display = 'block';
                }else{
                    overlay.style.display = 'none';
                }

            }else{

                sidebar.classList.toggle('collapsed');

                mainContent.classList.toggle('expanded');

            }

        });

        overlay.addEventListener('click', () => {

            sidebar.classList.remove('show');

            overlay.style.display = 'none';

        });

    </script>

</body>
</html>

