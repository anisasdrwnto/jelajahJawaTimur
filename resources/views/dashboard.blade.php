<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Jelajah Jawa Timur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

    <style>
        :root {
            --primary:        #1B84FF;
            --primary-light:  #EEF6FF;
            --primary-active: #056EE9;
            --success:        #17C653;
            --success-light:  #DFFFEA;
            --warning:        #F6C000;
            --warning-light:  #FFF8DD;
            --danger:         #F8285A;
            --danger-light:   #FFEEF3;
            --info:           #7239EA;
            --info-light:     #F8F5FF;
            --dark:           #1E2129;
            --gray-100:       #F9F9F9;
            --gray-200:       #F1F1F4;
            --gray-300:       #DBDFE9;
            --gray-400:       #B5B5C3;
            --gray-500:       #99A1B7;
            --gray-600:       #78829D;
            --gray-700:       #4B5675;
            --gray-800:       #252F4A;
            --sidebar-w:      265px;
            --topbar-h:       70px;
            --radius:         10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--gray-100);
            color: var(--gray-800);
            font-size: 13.5px;
        }

        /* ── SIDEBAR ─────────────────────────────────── */
        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: var(--sidebar-w);
            background: #fff;
            border-right: 1px solid var(--gray-200);
            display: flex;
            flex-direction: column;
            z-index: 200;
            overflow: hidden;
        }

        .sb-brand {
            height: var(--topbar-h);
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 24px;
            border-bottom: 1px solid var(--gray-200);
            flex-shrink: 0;
        }

        .sb-brand-logo {
            width: 32px; height: 32px;
            background: var(--primary);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: 14px;
            letter-spacing: -0.5px;
        }

        .sb-brand-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--dark);
            letter-spacing: -0.2px;
        }

        .sb-brand-name small {
            display: block;
            font-size: 11px;
            font-weight: 400;
            color: var(--gray-500);
            letter-spacing: 0;
        }

        .sb-scroll {
            flex: 1;
            overflow-y: auto;
            padding: 12px 0 16px;
        }

        .sb-scroll::-webkit-scrollbar { width: 4px; }
        .sb-scroll::-webkit-scrollbar-track { background: transparent; }
        .sb-scroll::-webkit-scrollbar-thumb { background: var(--gray-200); border-radius: 99px; }

        .sb-section {
            padding: 16px 24px 4px;
            font-size: 10.5px;
            font-weight: 600;
            letter-spacing: 0.07em;
            text-transform: uppercase;
            color: var(--gray-400);
        }

        .sb-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 14px 8px 24px;
            margin: 1px 12px;
            color: var(--gray-600);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 8px;
            transition: background 0.15s, color 0.15s;
        }

        .sb-link:hover { background: var(--gray-100); color: var(--dark); }

        .sb-link.active {
            background: var(--primary-light);
            color: var(--primary);
            font-weight: 600;
        }

        .sb-link i { font-size: 16px; width: 22px; text-align: center; flex-shrink: 0; }

        .sb-badge {
            margin-left: auto;
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 99px;
            background: var(--primary-light);
            color: var(--primary);
        }

        .sb-footer {
            padding: 14px 16px;
            border-top: 1px solid var(--gray-200);
            flex-shrink: 0;
        }

        .sb-user {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 10px;
            cursor: pointer;
            transition: background 0.15s;
        }

        .sb-user:hover { background: var(--gray-100); }

        .sb-avatar {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: var(--primary-light);
            color: var(--primary);
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            flex-shrink: 0;
        }

        .sb-user-info { flex: 1; min-width: 0; }
        .sb-user-name { font-size: 13px; font-weight: 600; color: var(--dark); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-user-role {
            font-size: 11px; color: var(--gray-500);
            display: inline-flex; align-items: center; gap: 4px;
        }
        .sb-user-role::before {
            content: '';
            width: 6px; height: 6px;
            border-radius: 50%;
            background: var(--success);
            display: inline-block;
        }

        /* ── TOPBAR ──────────────────────────────────── */
        .topbar {
            position: fixed;
            top: 0; left: var(--sidebar-w); right: 0;
            height: var(--topbar-h);
            background: #fff;
            border-bottom: 1px solid var(--gray-200);
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 8px;
            z-index: 100;
        }

        .topbar-breadcrumb {
            flex: 1;
        }

        .topbar-breadcrumb h1 {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            line-height: 1;
            margin-bottom: 3px;
        }

        .topbar-breadcrumb nav {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--gray-500);
        }

        .topbar-breadcrumb nav span { color: var(--primary); font-weight: 500; }

        .tb-btn {
            width: 38px; height: 38px;
            border-radius: 9px;
            background: var(--gray-100);
            border: 1px solid var(--gray-200);
            display: flex; align-items: center; justify-content: center;
            color: var(--gray-600);
            font-size: 15px;
            cursor: pointer;
            transition: all 0.15s;
            position: relative;
            text-decoration: none;
        }

        .tb-btn:hover { background: var(--primary-light); border-color: var(--primary-light); color: var(--primary); }

        .tb-dot {
            position: absolute;
            top: 5px; right: 5px;
            width: 7px; height: 7px;
            background: var(--danger);
            border: 2px solid #fff;
            border-radius: 50%;
        }

        .tb-avatar {
            width: 38px; height: 38px;
            border-radius: 9px;
            background: var(--primary);
            color: #fff;
            font-size: 14px;
            font-weight: 700;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer;
            border: 2px solid transparent;
            transition: border-color 0.15s;
        }

        .tb-avatar:hover { border-color: var(--primary-light); }

        .tb-divider {
            width: 1px;
            height: 24px;
            background: var(--gray-200);
            margin: 0 4px;
        }

        .tb-date {
            font-size: 12px;
            color: var(--gray-500);
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        /* ── MAIN ────────────────────────────────────── */
        .main {
            margin-left: var(--sidebar-w);
            margin-top: var(--topbar-h);
            padding: 28px;
            min-height: calc(100vh - var(--topbar-h));
        }

        /* ── CARDS ───────────────────────────────────── */
        .card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 22px;
            border-bottom: 1px solid var(--gray-200);
            background: #fff;
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-title i {
            font-size: 16px;
            color: var(--primary);
        }

        .card-body { padding: 20px 22px; }

        /* ── STAT CARD ───────────────────────────────── */
        .stat-card {
            background: #fff;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius);
            padding: 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 12px;
            transition: box-shadow 0.2s, transform 0.2s;
        }

        .stat-card:hover {
            box-shadow: 0 6px 24px rgba(0,0,0,0.07);
            transform: translateY(-1px);
        }

        .stat-header { display: flex; align-items: center; justify-content: space-between; }

        .stat-icon {
            width: 46px; height: 46px;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .stat-menu {
            color: var(--gray-400);
            font-size: 18px;
            cursor: pointer;
            line-height: 1;
        }

        .stat-value {
            font-size: 28px;
            font-weight: 800;
            color: var(--dark);
            letter-spacing: -1px;
            line-height: 1;
        }

        .stat-label {
            font-size: 12.5px;
            color: var(--gray-500);
            font-weight: 500;
            margin-top: 2px;
        }

        .stat-footer {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            padding-top: 10px;
            border-top: 1px solid var(--gray-200);
        }

        .stat-badge {
            font-size: 11px;
            font-weight: 600;
            padding: 3px 8px;
            border-radius: 99px;
            display: inline-flex;
            align-items: center;
            gap: 2px;
        }

        /* ── TABLE ───────────────────────────────────── */
        .data-table { width: 100%; border-collapse: collapse; }

        .data-table thead tr {
            background: var(--gray-100);
        }

        .data-table thead th {
            padding: 11px 16px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            color: var(--gray-500);
            border-bottom: 1px solid var(--gray-200);
            white-space: nowrap;
        }

        .data-table tbody td {
            padding: 13px 16px;
            vertical-align: middle;
            border-bottom: 1px solid var(--gray-200);
        }

        .data-table tbody tr:last-child td { border-bottom: none; }

        .data-table tbody tr:hover td { background: var(--gray-100); }

        .event-name { font-weight: 600; color: var(--dark); font-size: 13px; }
        .event-sub { font-size: 11.5px; color: var(--gray-500); margin-top: 1px; }

        .location-dot {
            display: inline-flex; align-items: center; gap: 5px;
            color: var(--gray-600); font-size: 12.5px;
        }

        .location-dot i { font-size: 12px; color: var(--gray-400); }

        /* ── BADGES ──────────────────────────────────── */
        .badge {
            font-size: 11.5px;
            font-weight: 600;
            padding: 4px 11px;
            border-radius: 99px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .badge::before {
            content: '';
            width: 5px; height: 5px;
            border-radius: 50%;
        }

        .badge-success { background: var(--success-light); color: #007B2E; }
        .badge-success::before { background: var(--success); }

        .badge-primary { background: var(--primary-light); color: var(--primary-active); }
        .badge-primary::before { background: var(--primary); }

        .badge-warning { background: var(--warning-light); color: #9E7F00; }
        .badge-warning::before { background: var(--warning); }

        .badge-danger { background: var(--danger-light); color: var(--danger); }
        .badge-danger::before { background: var(--danger); }

        /* ── MAP ─────────────────────────────────────── */
        #mapJatim {
            height: 310px;
            border-radius: 8px;
        }

        /* ── CALENDAR overrides ──────────────────────── */
        .fc { font-size: 12.5px; }
        .fc .fc-toolbar-title { font-size: 13px; font-weight: 700; }
        .fc .fc-button-primary {
            background: var(--primary) !important;
            border-color: var(--primary) !important;
            font-size: 11.5px !important;
            padding: 4px 10px !important;
            border-radius: 7px !important;
            box-shadow: none !important;
        }
        .fc .fc-button-primary:hover { background: var(--primary-active) !important; }
        .fc .fc-daygrid-day-number { font-size: 12px; color: var(--gray-700); }
        .fc .fc-daygrid-day.fc-day-today { background: var(--primary-light) !important; }
        .fc .fc-col-header-cell-cushion { font-size: 11.5px; font-weight: 600; color: var(--gray-500); text-transform: uppercase; letter-spacing: 0.04em; }
        .fc .fc-event { font-size: 10.5px; border: none; border-radius: 5px; padding: 1px 5px; }
        .fc thead .fc-scrollgrid-section th { border: none; }
        .fc .fc-scrollgrid { border: none !important; }
        .fc .fc-scrollgrid-section-body td { border: none; }
        .fc td, .fc th { border-color: var(--gray-200) !important; }

        /* ── BTN overrides ───────────────────────────── */
        .btn-sm-action {
            font-size: 12px;
            font-weight: 500;
            padding: 6px 14px;
            border-radius: 8px;
            border: 1px solid var(--gray-200);
            background: var(--gray-100);
            color: var(--gray-600);
            cursor: pointer;
            transition: all 0.15s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .btn-sm-action:hover { background: var(--primary-light); border-color: var(--primary-light); color: var(--primary); }

        .btn-primary-sm {
            font-size: 12px;
            font-weight: 600;
            padding: 7px 16px;
            border-radius: 8px;
            background: var(--primary);
            color: #fff;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.15s;
        }

        .btn-primary-sm:hover { background: var(--primary-active); }

        /* ── PROGRESS ────────────────────────────────── */
        .progress-bar-wrap { height: 6px; background: var(--gray-200); border-radius: 99px; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 99px; }

        /* ── QUICK STATS MINI ────────────────────────── */
        .mini-stat {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
        }

        .mini-stat + .mini-stat { border-top: 1px solid var(--gray-200); }

        .mini-stat-icon {
            width: 36px; height: 36px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 15px;
            flex-shrink: 0;
        }

        .mini-stat-info { flex: 1; }
        .mini-stat-label { font-size: 12px; color: var(--gray-500); }
        .mini-stat-val { font-size: 15px; font-weight: 700; color: var(--dark); }

        /* ── ENGAGEMENT RING ─────────────────────────── */
        .ring-wrap { position: relative; width: 120px; height: 120px; margin: 0 auto; }
        .ring-wrap canvas { position: absolute; inset: 0; }
        .ring-label {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .ring-label .val { font-size: 22px; font-weight: 800; color: var(--dark); line-height: 1; }
        .ring-label .sub { font-size: 10px; color: var(--gray-500); }

        /* ── LOGOUT form hidden ──────────────────────── */
        #logoutForm { display: none; }

        @media (max-width: 991px) {
            .sidebar { transform: translateX(-100%); }
            .topbar, .main { left: 0; margin-left: 0; }
        }
    </style>
</head>
<body>

{{-- ════════════════════ SIDEBAR ════════════════════ --}}
<aside class="sidebar">
    <div class="sb-brand">
        <div class="sb-brand-logo">JJ</div>
        <div class="sb-brand-name">
            Jelajah Jatim
            <small>Admin Panel v2.0</small>
        </div>
    </div>

    <div class="sb-scroll">
        <div class="sb-section">Utama</div>
        <a href="{{ route('dashboard') }}" class="sb-link active">
            <i class="bi bi-speedometer2"></i>
            Dashboard
        </a>

        <div class="sb-section">Manajemen</div>
        <a href="{{ route('admin.event.index') }}" class="sb-link">
            <i class="bi bi-calendar-event"></i>
            Event
            <span class="sb-badge">{{ $totalEvent ?? 0 }}</span>
        </a>
        <a href="#" class="sb-link">
            <i class="bi bi-geo-alt"></i>
            Lokasi
        </a>
        <a href="#" class="sb-link">
            <i class="bi bi-people"></i>
            Pengguna
        </a>
        <a href="#" class="sb-link">
            <i class="bi bi-ticket-perforated"></i>
            Tiket
        </a>

        <div class="sb-section">Analitik</div>
        <a href="#" class="sb-link">
            <i class="bi bi-bar-chart-line"></i>
            Statistik
        </a>
        <a href="#" class="sb-link">
            <i class="bi bi-file-earmark-bar-graph"></i>
            Laporan
        </a>

        <div class="sb-section">Sistem</div>
        <a href="#" class="sb-link">
            <i class="bi bi-shield-check"></i>
            Izin & Akses
        </a>
        <a href="#" class="sb-link">
            <i class="bi bi-gear"></i>
            Pengaturan
        </a>
    </div>

    <div class="sb-footer">
        <div class="sb-user" onclick="document.getElementById('logoutForm').submit()">
            <div class="sb-avatar">
                {{ strtoupper(substr(Auth::user()->mus_name ?? 'U', 0, 1)) }}
            </div>
            <div class="sb-user-info">
                <div class="sb-user-name">{{ Auth::user()->mus_name ?? 'User' }}</div>
                <div class="sb-user-role">{{ Auth::user()->mus_role ?? 'USR' }}</div>
            </div>
            <i class="bi bi-box-arrow-right" style="color:var(--gray-400); font-size:16px;"></i>
        </div>
        <form id="logoutForm" method="POST" action="{{ route('logout') }}">@csrf</form>
    </div>
</aside>

{{-- ════════════════════ TOPBAR ════════════════════ --}}
<header class="topbar">
    <div class="topbar-breadcrumb">
        <h1>Dashboard</h1>
        <nav>
            <i class="bi bi-house-door" style="font-size:11px;"></i>
            <i class="bi bi-chevron-right" style="font-size:9px;"></i>
            <span>Dashboard</span>
        </nav>
    </div>

    <div class="tb-date">
        <i class="bi bi-calendar3" style="color:var(--gray-400);"></i>
        {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
    </div>

    <div class="tb-divider"></div>

    <a href="#" class="tb-btn" title="Pencarian">
        <i class="bi bi-search"></i>
    </a>

    <a href="#" class="tb-btn" title="Notifikasi">
        <i class="bi bi-bell"></i>
        <span class="tb-dot"></span>
    </a>

    <a href="#" class="tb-btn" title="Pesan">
        <i class="bi bi-envelope"></i>
    </a>

    <div class="tb-divider"></div>

    <div class="tb-avatar" title="{{ Auth::user()->mus_name ?? 'User' }}">
        {{ strtoupper(substr(Auth::user()->mus_name ?? 'U', 0, 1)) }}
    </div>
</header>

{{-- ════════════════════ MAIN ════════════════════ --}}
<main class="main">

    {{-- Greeting bar --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h5 style="font-size:18px; font-weight:800; color:var(--dark); margin-bottom:3px;">
                Selamat datang kembali, {{ Auth::user()->mus_name ?? 'Admin' }} 👋
            </h5>
            <p style="font-size:12.5px; color:var(--gray-500); margin:0;">
                Berikut ringkasan aktivitas Jelajah Jawa Timur hari ini.
            </p>
        </div>
        <button class="btn-primary-sm">
            <i class="bi bi-plus-lg"></i> Tambah Event
        </button>
    </div>

    {{-- ── Stat Cards ── --}}
    <div class="row g-3 mb-4">

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background:var(--primary-light); color:var(--primary);">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                    <span class="stat-menu"><i class="bi bi-three-dots-vertical"></i></span>
                </div>
                <div>
                    <div class="stat-value">{{ $totalEvent }}</div>
                    <div class="stat-label">Total Event</div>
                </div>
                <div class="stat-footer">
                    <span class="stat-badge" style="background:var(--success-light); color:#007B2E;">
                        <i class="bi bi-arrow-up-short"></i>+12%
                    </span>
                    <span style="color:var(--gray-400);">dibanding bulan lalu</span>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background:var(--info-light); color:var(--info);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <span class="stat-menu"><i class="bi bi-three-dots-vertical"></i></span>
                </div>
                <div>
                    <div class="stat-value">{{ $totalPengguna }}</div>
                    <div class="stat-label">Total Pengguna</div>
                </div>
                <div class="stat-footer">
                    <span class="stat-badge" style="background:var(--success-light); color:#007B2E;">
                        <i class="bi bi-arrow-up-short"></i>+8%
                    </span>
                    <span style="color:var(--gray-400);">dibanding bulan lalu</span>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background:var(--warning-light); color:#9E7F00;">
                        <i class="bi bi-ticket-perforated-fill"></i>
                    </div>
                    <span class="stat-menu"><i class="bi bi-three-dots-vertical"></i></span>
                </div>
                <div>
                    <div class="stat-value">{{ $tiketTerjual }}</div>
                    <div class="stat-label">Tiket Terjual</div>
                </div>
                <div class="stat-footer">
                    <span class="stat-badge" style="background:var(--success-light); color:#007B2E;">
                        <i class="bi bi-arrow-up-short"></i>+5%
                    </span>
                    <span style="color:var(--gray-400);">dibanding bulan lalu</span>
                </div>
            </div>
        </div>

        <div class="col-sm-6 col-xl-3">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon" style="background:var(--danger-light); color:var(--danger);">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <span class="stat-menu"><i class="bi bi-three-dots-vertical"></i></span>
                </div>
                <div>
                    <div class="stat-value">{{ $lokasiAktif }}</div>
                    <div class="stat-label">Lokasi Aktif</div>
                </div>
                <div class="stat-footer">
                    <span class="stat-badge" style="background:var(--danger-light); color:var(--danger);">
                        <i class="bi bi-arrow-down-short"></i>-2%
                    </span>
                    <span style="color:var(--gray-400);">dibanding bulan lalu</span>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Chart + Calendar ── --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-8">
            <div class="card h-100">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bi bi-bar-chart-line-fill"></i>
                        Statistik Event per Bulan
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        <select class="form-select form-select-sm" style="width:auto; font-size:12px; border-radius:7px; border-color:var(--gray-200);">
                            <option>2025</option>
                            <option>2024</option>
                        </select>
                        <a href="#" class="btn-sm-action">Export <i class="bi bi-download"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chartEvent" height="105"></canvas>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card h-100">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bi bi-calendar3"></i>
                        Kalender Event
                    </div>
                </div>
                <div style="padding:14px 16px;">
                    <div id="calendarEvent"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Table + Map ── --}}
    <div class="row g-3 mb-4">

        <div class="col-xl-7">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bi bi-table"></i>
                        Event Terbaru
                    </div>
                    <a href="#" class="btn-sm-action">
                        Lihat semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
                <div style="overflow-x:auto;">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th style="padding-left:22px;">#</th>
                                <th>Nama Event</th>
                                <th>Lokasi</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th style="text-align:center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td style="padding-left:22px; color:var(--gray-400); font-size:12px;">01</td>
                                <td>
                                    <div class="event-name">Festival Bromo 2025</div>
                                    <div class="event-sub">Wisata Alam • 520 tiket</div>
                                </td>
                                <td><span class="location-dot"><i class="bi bi-geo-alt"></i>Probolinggo</span></td>
                                <td style="color:var(--gray-600); font-size:12.5px;">12 Jun 2025</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td style="text-align:center;">
                                    <a href="#" class="tb-btn" style="width:30px;height:30px;font-size:13px; display:inline-flex;"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:22px; color:var(--gray-400); font-size:12px;">02</td>
                                <td>
                                    <div class="event-name">Ijen Jazz Festival</div>
                                    <div class="event-sub">Musik • 310 tiket</div>
                                </td>
                                <td><span class="location-dot"><i class="bi bi-geo-alt"></i>Banyuwangi</span></td>
                                <td style="color:var(--gray-600); font-size:12.5px;">20 Jun 2025</td>
                                <td><span class="badge badge-primary">Akan Datang</span></td>
                                <td style="text-align:center;">
                                    <a href="#" class="tb-btn" style="width:30px;height:30px;font-size:13px; display:inline-flex;"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:22px; color:var(--gray-400); font-size:12px;">03</td>
                                <td>
                                    <div class="event-name">Pameran Batik Madura</div>
                                    <div class="event-sub">Budaya • 180 tiket</div>
                                </td>
                                <td><span class="location-dot"><i class="bi bi-geo-alt"></i>Pamekasan</span></td>
                                <td style="color:var(--gray-600); font-size:12.5px;">25 Jun 2025</td>
                                <td><span class="badge badge-warning">Draft</span></td>
                                <td style="text-align:center;">
                                    <a href="#" class="tb-btn" style="width:30px;height:30px;font-size:13px; display:inline-flex;"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:22px; color:var(--gray-400); font-size:12px;">04</td>
                                <td>
                                    <div class="event-name">Konser Surabaya Night</div>
                                    <div class="event-sub">Musik • 740 tiket</div>
                                </td>
                                <td><span class="location-dot"><i class="bi bi-geo-alt"></i>Surabaya</span></td>
                                <td style="color:var(--gray-600); font-size:12.5px;">30 Jun 2025</td>
                                <td><span class="badge badge-success">Aktif</span></td>
                                <td style="text-align:center;">
                                    <a href="#" class="tb-btn" style="width:30px;height:30px;font-size:13px; display:inline-flex;"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-left:22px; color:var(--gray-400); font-size:12px;">05</td>
                                <td>
                                    <div class="event-name">Food Festival Malang</div>
                                    <div class="event-sub">Kuliner • 425 tiket</div>
                                </td>
                                <td><span class="location-dot"><i class="bi bi-geo-alt"></i>Malang</span></td>
                                <td style="color:var(--gray-600); font-size:12.5px;">5 Jul 2025</td>
                                <td><span class="badge badge-primary">Akan Datang</span></td>
                                <td style="text-align:center;">
                                    <a href="#" class="tb-btn" style="width:30px;height:30px;font-size:13px; display:inline-flex;"><i class="bi bi-eye"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-5">
            <div class="card h-100">
                <div class="card-header">
                    <div class="card-title">
                        <i class="bi bi-map"></i>
                        Peta Lokasi — Jawa Timur
                    </div>
                    <a href="#" class="btn-sm-action">Perbesar <i class="bi bi-arrows-fullscreen"></i></a>
                </div>
                <div class="card-body">
                    <div id="mapJatim"></div>
                </div>
            </div>
        </div>

    </div>

    {{-- ── Bottom Row: Progress + Mini Stats ── --}}
    <div class="row g-3">

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-pie-chart-fill"></i> Kategori Event</div>
                </div>
                <div class="card-body" style="display:flex; flex-direction:column; gap:14px;">

                    <div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:12.5px;">
                            <span style="color:var(--gray-700); font-weight:500;">Wisata Alam</span>
                            <span style="color:var(--dark); font-weight:700;">42%</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:42%; background:var(--primary);"></div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:12.5px;">
                            <span style="color:var(--gray-700); font-weight:500;">Musik & Hiburan</span>
                            <span style="color:var(--dark); font-weight:700;">28%</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:28%; background:var(--info);"></div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:12.5px;">
                            <span style="color:var(--gray-700); font-weight:500;">Kuliner</span>
                            <span style="color:var(--dark); font-weight:700;">18%</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:18%; background:var(--warning);"></div>
                        </div>
                    </div>

                    <div>
                        <div class="d-flex justify-content-between mb-1" style="font-size:12.5px;">
                            <span style="color:var(--gray-700); font-weight:500;">Budaya & Seni</span>
                            <span style="color:var(--dark); font-weight:700;">12%</span>
                        </div>
                        <div class="progress-bar-wrap">
                            <div class="progress-bar-fill" style="width:12%; background:var(--success);"></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-lightning-charge-fill"></i> Aktivitas Cepat</div>
                </div>
                <div class="card-body">
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="background:var(--primary-light); color:var(--primary);">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <div class="mini-stat-info">
                            <div class="mini-stat-label">Event Berlangsung</div>
                            <div class="mini-stat-val">8 Event</div>
                        </div>
                        <span class="badge badge-success" style="font-size:10.5px;">Live</span>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="background:var(--warning-light); color:#9E7F00;">
                            <i class="bi bi-hourglass-split"></i>
                        </div>
                        <div class="mini-stat-info">
                            <div class="mini-stat-label">Menunggu Verifikasi</div>
                            <div class="mini-stat-val">14 Draft</div>
                        </div>
                        <a href="#" class="btn-sm-action" style="font-size:11px; padding:4px 10px;">Review</a>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="background:var(--success-light); color:#007B2E;">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="mini-stat-info">
                            <div class="mini-stat-label">Selesai Bulan Ini</div>
                            <div class="mini-stat-val">23 Event</div>
                        </div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-icon" style="background:var(--danger-light); color:var(--danger);">
                            <i class="bi bi-exclamation-triangle"></i>
                        </div>
                        <div class="mini-stat-info">
                            <div class="mini-stat-label">Keluhan Masuk</div>
                            <div class="mini-stat-val">3 Laporan</div>
                        </div>
                        <span class="badge badge-danger" style="font-size:10.5px;">Baru</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title"><i class="bi bi-graph-up-arrow"></i> Target Bulanan</div>
                </div>
                <div class="card-body" style="display:flex; flex-direction:column; align-items:center; gap:16px;">
                    <div class="ring-wrap">
                        <canvas id="ringChart"></canvas>
                        <div class="ring-label">
                            <div class="val">74%</div>
                            <div class="sub">Tercapai</div>
                        </div>
                    </div>
                    <div style="width:100%; display:flex; flex-direction:column; gap:8px;">
                        <div class="d-flex justify-content-between" style="font-size:12.5px;">
                            <span style="color:var(--gray-600);">Target Event</span>
                            <span style="font-weight:700; color:var(--dark);">128 / 170</span>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size:12.5px;">
                            <span style="color:var(--gray-600);">Target Tiket</span>
                            <span style="font-weight:700; color:var(--dark);">892 / 1.200</span>
                        </div>
                        <div class="d-flex justify-content-between" style="font-size:12.5px;">
                            <span style="color:var(--gray-600);">Pengguna Baru</span>
                            <span style="font-weight:700; color:var(--dark);">3.4K / 4K</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

</main>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// ── Bar + Line Chart ──────────────────────────────────────────────────────
const ctx = document.getElementById('chartEvent').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
        datasets: [
            {
                label: 'Event Aktif',
                data: [8,12,10,15,18,22,20,17,14,19,16,12],
                backgroundColor: 'rgba(27,132,255,0.85)',
                borderRadius: 6,
                borderSkipped: false,
                barPercentage: 0.55,
            },
            {
                label: 'Tiket Terjual',
                data: [40,65,55,80,95,110,100,88,72,95,82,60],
                type: 'line',
                borderColor: '#17C653',
                backgroundColor: 'rgba(23,198,83,0.08)',
                pointBackgroundColor: '#17C653',
                pointRadius: 4,
                pointHoverRadius: 6,
                fill: true,
                tension: 0.4,
                yAxisID: 'y1',
                borderWidth: 2,
            }
        ]
    },
    options: {
        responsive: true,
        interaction: { mode: 'index', intersect: false },
        plugins: {
            legend: {
                labels: {
                    font: { size: 12, family: 'Inter' },
                    usePointStyle: true,
                    pointStyleWidth: 8,
                    color: '#78829D',
                }
            },
            tooltip: {
                backgroundColor: '#fff',
                titleColor: '#1E2129',
                bodyColor: '#78829D',
                borderColor: '#DBDFE9',
                borderWidth: 1,
                padding: 12,
                boxPadding: 4,
            }
        },
        scales: {
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#99A1B7' } },
            y: { beginAtZero: true, grid: { color: '#F1F1F4' }, ticks: { font: { size: 11 }, color: '#99A1B7' }, border: { dash: [4,4] } },
            y1: { beginAtZero: true, position: 'right', grid: { display: false }, ticks: { font: { size: 11 }, color: '#99A1B7' } }
        }
    }
});

// ── Donut Ring ────────────────────────────────────────────────────────────
const ringCtx = document.getElementById('ringChart').getContext('2d');
new Chart(ringCtx, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [74, 26],
            backgroundColor: ['#1B84FF', '#F1F1F4'],
            borderWidth: 0,
            hoverOffset: 0,
        }]
    },
    options: {
        cutout: '78%',
        plugins: { legend: { display: false }, tooltip: { enabled: false } },
        animation: { animateRotate: true, duration: 1200 }
    }
});

// ── FullCalendar ──────────────────────────────────────────────────────────
const calendarEl = document.getElementById('calendarEvent');
const calendar = new FullCalendar.Calendar(calendarEl, {
    initialView: 'dayGridMonth',
    headerToolbar: { left: 'prev', center: 'title', right: 'next' },
    height: 'auto',
    events: [
        { title: 'Festival Bromo',  date: '2025-06-12', color: '#1B84FF' },
        { title: 'Ijen Jazz',       date: '2025-06-20', color: '#7239EA' },
        { title: 'Pameran Batik',   date: '2025-06-25', color: '#F6C000' },
        { title: 'Konser Surabaya', date: '2025-06-30', color: '#17C653' },
        { title: 'Food Festival',   date: '2025-07-05', color: '#1B84FF' },
    ]
});
calendar.render();

// ── Leaflet Map ───────────────────────────────────────────────────────────
const map = L.map('mapJatim').setView([-7.536, 112.238], 8);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

const events = [
    { name: 'Festival Bromo',  lat: -7.942, lng: 112.953, color: '#1B84FF' },
    { name: 'Ijen Jazz',       lat: -8.058, lng: 114.242, color: '#7239EA' },
    { name: 'Pameran Batik',   lat: -7.157, lng: 113.472, color: '#F6C000' },
    { name: 'Konser Surabaya', lat: -7.257, lng: 112.752, color: '#17C653' },
    { name: 'Food Festival',   lat: -7.966, lng: 112.632, color: '#1B84FF' },
];

events.forEach(ev => {
    const icon = L.divIcon({
        className: '',
        html: `<div style="width:13px;height:13px;border-radius:50%;background:${ev.color};border:2.5px solid #fff;box-shadow:0 2px 6px rgba(0,0,0,0.25);"></div>`,
        iconSize: [13, 13],
        iconAnchor: [6.5, 6.5],
    });
    L.marker([ev.lat, ev.lng], { icon })
        .addTo(map)
        .bindPopup(`<strong style="font-family:Inter,sans-serif;font-size:12.5px;">${ev.name}</strong>`);
});
</script>
</body>
</html>