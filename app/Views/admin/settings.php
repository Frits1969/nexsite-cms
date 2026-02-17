<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instellingen | NexSite CMS</title>
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
            max-width: 65px;
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

        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

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

        .content {
            padding: 40px;
            max-width: 1000px;
            margin: 0 auto;
            width: 100%;
        }

        .settings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(450px, 1fr));
            gap: 30px;
        }

        .settings-card {
            background: var(--secondary-bg);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .settings-card h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--accent-color);
        }

        .setting-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 0;
            border-bottom: 1px solid var(--glass-border);
        }

        .setting-row:last-child {
            border-bottom: none;
        }

        .setting-label {
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .setting-value {
            color: var(--text-main);
            font-weight: 600;
            text-align: right;
        }

        .badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-info {
            background: rgba(1, 131, 214, 0.1);
            color: var(--accent-color);
        }

        .badge-success {
            background: rgba(11, 156, 112, 0.1);
            color: var(--accent-green);
        }

        .header-section {
            margin-bottom: 40px;
        }

        .header-section h1 {
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .header-section p {
            color: var(--text-muted);
            font-size: 1.1rem;
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
            <a href="/backoffice" class="nav-item">
                <span>Dashboard</span>
            </a>
            <a href="/backoffice/pages" class="nav-item">
                <span>Pagina's</span>
            </a>
            <a href="/backoffice/media" class="nav-item">
                <span>Media</span>
            </a>
            <a href="/backoffice/settings" class="nav-item active">
                <span>Instellingen</span>
            </a>
            <a href="/" target="_blank" class="nav-item">
                <span>Bezoek Website</span>
            </a>
        </nav>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);">Backoffice / Instellingen</div>
            <a href="/backoffice" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Terug naar Dashboard</a>
        </header>

        <main class="content">
            <div class="header-section">
                <h1>Systeem Instellingen</h1>
                <p>Overzicht van de configuratie ingevoerd tijdens de installatie.</p>
            </div>

            <div class="settings-grid">
                <!-- Site Configuration -->
                <div class="settings-card">
                    <h3><span>🏠</span> Website Configuratie</h3>
                    <div class="setting-row">
                        <span class="setting-label">Website Naam</span>
                        <span class="setting-value"><?= htmlspecialchars($settings['site_name'] ?? 'Niet ingesteld') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">Beschrijving</span>
                        <span class="setting-value"><?= htmlspecialchars($settings['site_description'] ?? 'Niet ingesteld') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">Domein</span>
                        <span class="setting-value"><?= htmlspecialchars($settings['site_domain'] ?? 'Niet ingesteld') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">App URL</span>
                        <span class="setting-value"><?= htmlspecialchars($env['app_url'] ?? 'Niet ingesteld') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">Standaard Taal</span>
                        <span class="setting-value"><span class="badge badge-info"><?= strtoupper($env['language'] ?? 'NL') ?></span></span>
                    </div>
                </div>

                <!-- Database & System -->
                <div class="settings-card">
                    <h3><span>⚙️</span> Systeem & Database</h3>
                    <div class="setting-row">
                        <span class="setting-label">Database Host</span>
                        <span class="setting-value"><?= htmlspecialchars($env['db_host'] ?? 'localhost') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">Database Naam</span>
                        <span class="setting-value"><?= htmlspecialchars($env['db_name'] ?? 'Niet ingesteld') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">Database Gebruiker</span>
                        <span class="setting-value"><?= htmlspecialchars($env['db_user'] ?? 'Niet ingesteld') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">Tabel Prefix</span>
                        <span class="setting-value"><code><?= htmlspecialchars($env['db_prefix'] ?? 'nscms_') ?></code></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">Installatie Datum</span>
                        <span class="setting-value"><?= htmlspecialchars($settings['installed_at'] ?? 'Onbekend') ?></span>
                    </div>
                    <div class="setting-row">
                        <span class="setting-label">CMS Versie</span>
                        <span class="setting-value"><span class="badge badge-success">v<?= htmlspecialchars($env['version'] ?? '0.1.0') ?></span></span>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>
