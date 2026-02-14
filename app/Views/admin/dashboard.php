<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | NexSite CMS</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #0f172a;
            --secondary-bg: #1e293b;
            --accent-color: #0183D6;
            --accent-green: #0B9C70;
            --accent-orange: #F0961B;
            --accent-gradient: linear-gradient(135deg, #0183D6 0%, #0B9C70 50%, #F0961B 100%);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
            overflow-x: hidden;
            display: flex;
        }

        /* Sidebar Styling */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--secondary-bg);
            border-right: 1px solid var(--glass-border);
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-header img {
            max-width: 40px;
            height: auto;
        }

        .sidebar-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 15px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(1, 131, 214, 0.1);
            color: var(--accent-color);
        }

        .nav-item i {
            font-size: 1.2rem;
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--glass-border);
        }

        /* Main Content Styling */
        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Topbar Styling */
        .topbar {
            height: 70px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .search-box {
            position: relative;
            width: 300px;
        }

        .search-box input {
            width: 100%;
            padding: 10px 15px 10px 40px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: var(--text-main);
            outline: none;
            transition: all 0.3s;
        }

        .search-box input:focus {
            border-color: var(--accent-color);
            background: rgba(255, 255, 255, 0.08);
        }

        .user-widget {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 5px 10px;
            border-radius: 50px;
            transition: background 0.3s;
        }

        .user-widget:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .user-avatar {
            width: 35px;
            height: 35px;
            background: var(--accent-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 0.8rem;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 0.9rem;
            font-weight: 600;
        }

        .user-role {
            font-size: 0.75rem;
            color: var(--text-muted);
        }

        /* User Menu Dropdown */
        .user-menu {
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 200px;
            background: var(--secondary-bg);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 10px;
            display: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            z-index: 110;
        }

        .user-menu.active {
            display: block;
            animation: slideUp 0.3s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.9rem;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-main);
        }

        .menu-item.logout {
            color: #ef4444;
        }

        .menu-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        /* Content Area Area */
        .content {
            padding: 40px;
        }

        .welcome-card {
            background: var(--accent-gradient);
            padding: 40px;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
            margin-bottom: 40px;
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .welcome-card h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }

        .welcome-card p {
            font-size: 1.1rem;
            opacity: 0.9;
            max-width: 600px;
            line-height: 1.6;
            position: relative;
            z-index: 1;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
        }

        .stat-card {
            background: var(--glass-bg);
            border: 1px solid var(--glass-border);
            padding: 25px;
            border-radius: 15px;
            transition: transform 0.3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            color: var(--accent-color);
            font-size: 1.5rem;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }
            .sidebar-header h2, .sidebar-header h2 + p, .nav-item span, .user-info {
                display: none;
            }
            .main-wrapper {
                margin-left: 80px;
            }
            .sidebar-header {
                justify-content: center;
            }
            .nav-item {
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="/assets/logo/nexsite-logo.png" alt="Logo">
            <h2>NexSite</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="/backoffice" class="nav-item active">
                <span>Dashboard</span>
            </a>
            <a href="/backoffice/pages" class="nav-item">
                <span>Pagina's</span>
            </a>
            <a href="/backoffice/media" class="nav-item">
                <span>Media</span>
            </a>
            <a href="/backoffice/settings" class="nav-item">
                <span>Instellingen</span>
            </a>
            <a href="/" target="_blank" class="nav-item">
                <span>Bezoek Website</span>
            </a>
        </nav>
        <div class="sidebar-footer">
            <p style="font-size: 0.8rem; color: var(--text-muted);">v0.0.5</p>
        </div>
    </aside>

    <div class="main-wrapper">
        <!-- Topbar -->
        <header class="topbar">
            <div class="search-box">
                <input type="text" placeholder="Zoeken in NexSite...">
            </div>

            <div class="user-widget" id="user-widget">
                <div class="user-avatar">
                    <?php 
                        $name = $_SESSION['username'] ?? 'Admin';
                        echo strtoupper(substr($name, 0, 1) . (strlen($name) > 1 ? substr($name, 1, 1) : '')); 
                    ?>
                </div>
                <div class="user-info">
                    <span class="user-name"><?= $_SESSION['username'] ?? 'Admin' ?></span>
                    <span class="user-role">Super Admin</span>
                </div>
                <!-- User Menu Dropdown -->
                <div class="user-menu" id="user-menu">
                    <a href="/backoffice/profile" class="menu-item">Profiel</a>
                    <a href="/backoffice/settings" class="menu-item">Account Instellingen</a>
                    <hr style="margin: 10px 0; border: none; border-top: 1px solid var(--glass-border);">
                    <a href="/backoffice/logout" class="menu-item logout">Uitloggen</a>
                </div>
            </div>
        </header>

        <!-- Main Content Area -->
        <main class="content">
            <section class="welcome-card">
                <h1>Welkom terug, <?= $_SESSION['username'] ?? 'Admin' ?>!</h1>
                <p>Je website is succesvol geïnstalleerd en klaar voor gebruik. Begin met het maken van prachtige pagina's of pas je instellingen aan in de sidebar.</p>
            </section>

            <section class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">📄</div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Pagina's</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">🖼️</div>
                    <div class="stat-value">0</div>
                    <div class="stat-label">Media Bestanden</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">👥</div>
                    <div class="stat-value">1</div>
                    <div class="stat-label">Gebruikers</div>
                </div>
                <div class="stat-card">
                    <div class="stat-icon">⚡</div>
                    <div class="stat-value">Actief</div>
                    <div class="stat-label">Systeem Status</div>
                </div>
            </section>

            <section class="dashboard-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; margin-top: 40px;">
                <!-- Content Overview -->
                <div class="stat-card" style="min-height: 300px;">
                    <h3 style="margin-bottom: 20px; font-weight: 600; display: flex; align-items: center; gap: 10px;">
                        <span style="color: var(--accent-green);">📄</span> Laatste Pagina's
                    </h3>
                    <div style="background: rgba(255, 255, 255, 0.03); border-radius: 12px; padding: 15px;">
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 10px; border-bottom: 1px solid var(--glass-border);">
                            <div>
                                <span style="font-weight: 500;">Tijdelijke Home</span>
                                <br><small style="color: var(--text-muted);">/ (Root)</small>
                            </div>
                            <a href="/" target="_blank" style="color: var(--accent-orange); text-decoration: none; font-size: 0.85rem; font-weight: 600;">Bekijken</a>
                        </div>
                        <div style="padding: 20px; text-align: center; color: var(--text-muted); font-size: 0.9rem;">
                            Geen andere pagina's gevonden.
                        </div>
                    </div>
                </div>

                <!-- System Actions -->
                <div class="stat-card">
                    <h3 style="margin-bottom: 20px; font-weight: 600;">System Actions</h3>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 25px;">Kritieke systeemacties. Wees voorzichtig met deze opties.</p>
                    
                    <a href="/reset_install.php" class="btn-reset" style="display: inline-block; width: 100%; padding: 15px; background: rgba(239, 68, 68, 0.1); color: #ef4444; text-decoration: none; border-radius: 12px; font-weight: 600; text-align: center; border: 1px solid rgba(239, 68, 68, 0.2); transition: all 0.3s;">
                        ⚠️ Reset Installatie
                    </a>
                    
                    <style>
                        .btn-reset:hover {
                            background: #ef4444 !important;
                            color: white !important;
                            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.2);
                        }
                    </style>
                </div>
            </section>
        </main>
    </div>

    <script>
        // Toggle User Menu
        const userWidget = document.getElementById('user-widget');
        const userMenu = document.getElementById('user-menu');

        userWidget.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('active');
        });

        document.addEventListener('click', () => {
            userMenu.classList.remove('active');
        });
    </script>
</body>

</html>