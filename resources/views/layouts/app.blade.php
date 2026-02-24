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
            <div class="user-info">
                <div class="profile-icon"></div>
                <div>{{ Auth::user()->name }}</div>
            </div>
        </div>
    </header>

    <div class="main-wrapper">
        
        <aside class="sidebar">
            <ul class="sidebar-menu">
                <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                </li>
                <li>
                    <a href="#">Permintaan Buku</a>
                </li>
                <li class="{{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                    <a href="{{ route('profile.edit') }}">Profil</a>
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
    </script>
</body>
</html>