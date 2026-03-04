<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Library Book Request') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #F1F4F9;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* --- TOP BAR --- */
        .topbar {
            background-color: #003366; /* Biru UNAIR */
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            z-index: 10;
        }
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .topbar-left img {
            width: 50px;
        }
        .topbar-title {
            line-height: 1.2;
        }
        .topbar-right {
            text-align: right;
            font-size: 13px;
            color: #E2E8F0;
        }
        .user-info {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 5px;
            font-size: 16px;
            color: white;
            font-weight: 500;
        }
        .profile-icon {
            width: 35px;
            height: 35px;
            background-color: #E2E8F0;
            border-radius: 50%;
        }
        /* Container untuk dropdown */
        .user-dropdown {
            position: relative;
            cursor: pointer;
        }

        /* Menu yang tadinya sembunyi */
        .dropdown-menu {
            position: absolute;
            top: 100%;
            right: 0;
            background-color: white;
            min-width: 160px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.1);
            border-radius: 8px;
            margin-top: 10px;
            display: none; /* Sembunyi dulu */
            z-index: 1000;
        }

        .dropdown-menu a, .dropdown-menu button {
            color: #333;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            font-size: 14px;
            text-align: left;
            width: 100%;
            border: none;
            background: none;
            cursor: pointer;
        }

        .dropdown-menu a:hover, .dropdown-menu button:hover {
            background-color: #f1f1f1;
        }

        .dropdown-menu .logout-item {
            color: #ef4444 !important; /* Warna merah teks default */
            font-weight: 600;
            transition: all 0.2s;
            border-top: 1px solid #eee; /* Kasih pemisah dikit biar rapi */
            margin-top: 5px;
        }

        /* Pas kursor di atas tombol (Hover) */
        .dropdown-menu .logout-item:hover {
            background-color: #fef2f2 !important; /* Merah sangat muda */
            color: #b91c1c !important; /* Merah lebih gelap */
        }

        /* Pas tombol diklik (Active) */
        .dropdown-menu .logout-item:active {
            background-color: #ef4444 !important; /* Merah solid */
            color: white !important; /* Teks jadi putih biar kebaca */
        }

        .dropdown-menu a, .dropdown-menu .logout-item {
            display: flex !important;
            align-items: center;
            gap: 12px; /* Jarak antara ikon dan teks */
            padding: 12px 20px !important;
            font-size: 14px;
            font-weight: 500;
            color: #475569;
            transition: all 0.2s ease;
            border: none;
            width: 100%;
            text-align: left;
            box-sizing: border-box;
        }

        /* Hover untuk Edit Profil */
        .dropdown-menu a:hover {
            background-color: #F1F5F9;
            color: #003366;
        }

        /* Khusus untuk Logout */
        .dropdown-menu .logout-item {
            color: #ef4444 !important;
            border-top: 1px solid #f1f1f1;
            margin-top: 5px;
        }

        /* Sesuai request: Hover background merah muda */
        .dropdown-menu .logout-item:hover {
            background-color: #FEF2F2 !important;
            color: #dc2626 !important;
        }

        /* Sesuai request: Klik/Active background merah solid, teks putih */
        .dropdown-menu .logout-item:active {
            background-color: #ef4444 !important;
            color: white !important;
        }

        /* Tampilkan menu pas diklik (kita kontrol via JS) */
        .show {
            display: block;
        }

        /* --- MAIN LAYOUT (Sidebar + Content) --- */
        .main-wrapper {
            display: flex;
            flex: 1;
        }

        /* --- SIDEBAR --- */
        .sidebar {
            width: 250px;
            background-color: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #64748B;
            text-decoration: none;
            font-weight: 500;
            border-left: 4px solid transparent;
            transition: all 0.2s;
        }
        .sidebar-menu li a:hover, 
        .sidebar-menu li.active a {
            background-color: #F8FAFC;
            color: #003366;
            border-left-color: #003366;
        }
        /* Tombol Logout khusus di sidebar */
        .logout-btn {
            background: none;
            border: none;
            width: 100%;
            text-align: left;
            padding: 15px 25px;
            color: #ef4444;
            font-weight: 500;
            cursor: pointer;
            font-family: inherit;
        }
        .logout-btn:hover {
            background-color: #FEF2F2;
        }

        /* --- CONTENT AREA --- */
        .content-area {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
    </style>
</head>
<body>

    <header class="topbar">
        <div class="topbar-left">
            <img src="{{ asset('images/logo-unair.png') }}" alt="Logo">
            <div class="topbar-title">
                <div style="font-weight: bold; font-size: 18px;">LIBRARY BOOK REQUEST</div>
                <div style="font-size: 12px;">PERPUSTAKAAN UNIVERSITAS AIRLANGGA</div>
            </div>
        </div>
        <div class="topbar-right">
            <div id="realtime-clock"></div>
            <div class="user-dropdown" onclick="toggleDropdown()">
                <div class="user-info">
                    <div class="profile-icon"></div>
                    <div>{{ Auth::user()->name }} ▾</div>
                </div>
                
                <div id="myDropdown" class="dropdown-menu">
                    <a href="{{ route('profile.edit') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        Edit Profil
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="logout-item">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <div class="main-wrapper">
        
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li class="{{ request()->routeIs('permintaan.index') ? 'active' : '' }}">
                    <a href="{{ route('permintaan.index') }}">Permintaan Buku</a>
                </li>
                <li class="{{ request()->routeIs('profile') ? 'active' : '' }}">
                    <a href="{{ route('profile') }}">Profil</a>
                </li>
            </ul>

            <div style="margin-top: auto; border-top: 1px solid #eee;">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout-btn">
                        Keluar
                    </button>
                </form>
            </div>
        </aside>

        <main class="content-area">
            {{ $slot }}
        </main>

    </div>
    <script>
        function updateClock() {
            const now = new Date();
            
            // Format Hari dan Tanggal ala Indonesia
            const optionsDate = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            const dateString = now.toLocaleDateString('id-ID', optionsDate);
            
            // Format Jam (HH:MM:SS)
            const timeString = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            
            // Gabungkan jadi satu dan tampilkan ke layar
            document.getElementById('realtime-clock').textContent = `${dateString}, ${timeString}`;
        }
        
        // Jalankan fungsinya setiap 1 detik (1000 milidetik)
        setInterval(updateClock, 1000);
        updateClock(); // Panggil sekali di awal biar gak nunggu 1 detik dulu

        function toggleDropdown() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Klik di luar menu buat nutup
        window.onclick = function(event) {
            if (!event.target.closest('.user-dropdown')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
    
</body>
</html>

