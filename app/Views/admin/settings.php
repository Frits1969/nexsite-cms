<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'nl' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $settings_title ?> | NexSite CMS</title>
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

        .nav-item.active {
            position: relative;
            background: rgba(255, 255, 255, 0.03) !important;
        }

        .nav-item.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--accent-orange);
            border-radius: 3px 3px 0 0;
            z-index: 5;
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
            flex: 1;
            margin-left: 20px;
        }

        .setting-input {
            width: 100%;
            padding: 8px 12px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 8px;
            color: var(--text-main);
            font-size: 0.95rem;
            text-align: right;
            transition: all 0.3s;
        }

        .setting-input:focus {
            outline: none;
            border-color: var(--accent-color);
            background: rgba(255, 255, 255, 0.08);
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
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
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

        .btn-save {
            padding: 12px 25px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 10px;
            color: white;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(1, 131, 214, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(1, 131, 214, 0.4);
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-muted);
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            cursor: pointer;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            border-color: var(--text-muted);
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
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.9rem;
            position: relative;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.05);
            color: var(--text-main);
        }

        .menu-item.active {
            color: var(--text-main);
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px 8px 0 0;
        }

        .menu-item.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--accent-orange);
            border-radius: 3px 3px 0 0;
        }

        .menu-item.logout {
            color: #ef4444;
        }

        .menu-item.logout:hover {
            background: rgba(239, 68, 68, 0.1);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        /* Language Switcher Styling */
        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .lang-select {
            display: flex;
            position: relative;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.05);
            padding: 5px;
            border-radius: 10px;
            border: 1px solid var(--glass-border);
            height: 38px;
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            width: fit-content;
        }

        .lang-select a {
            display: none;
            line-height: 0;
            transition: all 0.3s ease;
        }

        .lang-select a.active {
            display: block;
        }

        .lang-select.expanded {
            height: 80px;
            flex-direction: column;
            gap: 8px;
            padding: 8px 5px;
            overflow: visible;
        }

        .lang-select.expanded a {
            display: block;
        }

        .flag-icon {
            width: 24px;
            height: 16px;
            object-fit: cover;
            border-radius: 2px;
        }

        .lang-select.expanded a {
            display: block;
        }

        .flag-icon {
            width: 32px;
            height: 22px;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: transform 0.2s;
        }

        .flag-icon:hover {
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <?php $uri = strtok($_SERVER['REQUEST_URI'] ?? '/backoffice', '?'); ?>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="/assets/logo/nexsite-logo.png" alt="Logo">
            <h2>NexSite</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="/backoffice" class="nav-item <?= $uri === '/backoffice' ? 'active' : '' ?>">
                <span><?= $nav_dashboard ?></span>
            </a>
            <a href="/backoffice/pages" class="nav-item <?= $uri === '/backoffice/pages' ? 'active' : '' ?>">
                <span><?= $nav_pages ?></span>
            </a>
            <a href="/backoffice/media" class="nav-item <?= $uri === '/backoffice/media' ? 'active' : '' ?>">
                <span><?= $nav_media ?></span>
            </a>
            <a href="/backoffice/templates" class="nav-item <?= $uri === '/backoffice/templates' ? 'active' : '' ?>">
                <span><?= $nav_templates ?></span>
            </a>
            <a href="/backoffice/themes" class="nav-item <?= $uri === '/backoffice/themes' ? 'active' : '' ?>">
                <span><?= $nav_themes ?></span>
            </a>
            <a href="/backoffice/settings" class="nav-item <?= $uri === '/backoffice/settings' ? 'active' : '' ?>">
                <span><?= $nav_settings ?></span>
            </a>
            <a href="/" target="_blank" class="nav-item">
                <span><?= $nav_visit_site ?></span>
            </a>
        </nav>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);"><?= $backoffice_title ?> / <?= $nav_settings ?></div>
            
            <div class="topbar-actions">
                <a href="/backoffice" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;"><?= $nav_back_to_dashboard ?></a>
                
                <div class="user-widget" id="user-widget" style="position: relative; display: flex; align-items: center; gap: 12px; cursor: pointer;">
                    <div class="user-avatar" style="width: 32px; height: 32px; background: var(--accent-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; color: white;">
                        <?php 
                            $name = $_SESSION['username'] ?? 'Admin';
                            echo strtoupper(substr($name, 0, 1) . (strlen($name) > 1 ? substr($name, 1, 1) : '')); 
                        ?>
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?= $_SESSION['username'] ?? 'Admin' ?></span>
                        <span class="user-role"><?= $role_super_admin ?></span>
                    </div>
                    <div class="user-menu" id="user-menu">
                        <a href="/backoffice/profile" class="menu-item"><?= $nav_profile ?></a>
                        <hr style="margin: 5px 0; border: none; border-top: 1px solid var(--glass-border);">
                        <a href="/backoffice/logout" class="menu-item logout"><?= $nav_logout ?></a>
                    </div>
                </div>

                <div class="lang-select" id="lang-switcher">
                    <?php $selectedLang = $_SESSION['lang'] ?? 'nl'; ?>
                    <a href="?lang=nl" class="<?= $selectedLang === 'nl' ? 'active' : '' ?>" onclick="handleFlagClick(event, 'nl')">
                        <img src="/assets/flags/nl.svg" alt="Nederlands" class="flag-icon">
                    </a>
                    <a href="?lang=en" class="<?= $selectedLang === 'en' ? 'active' : '' ?>" onclick="handleFlagClick(event, 'en')">
                        <img src="/assets/flags/en.svg" alt="English" class="flag-icon">
                    </a>
                </div>
            </div>
        </header>

        <main class="content">
            <?php if (isset($error) && $error): ?>
                <div class="alert alert-error">
                    <span>⚠️</span> <?= $error ?>
                </div>
            <?php endif; ?>

            <?php if (isset($success) && $success): ?>
                <div class="alert alert-success">
                    <span>✅</span> <?= $success ?>
                </div>
            <?php endif; ?>

            <form method="POST">
                <div class="header-section">
                    <div>
                        <h1><?= $settings_title ?></h1>
                        <p><?= $settings_desc ?></p>
                    </div>
                </div>

                <div class="settings-grid">
                    <!-- Site Configuration -->
                    <div class="settings-card">
                        <h3><span>🏠</span> <?= $site_config_title ?></h3>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_site_name ?></span>
                            <span class="setting-value">
                                <input type="text" name="site_name" class="setting-input" value="<?= htmlspecialchars($settings['site_name'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_site_desc ?></span>
                            <span class="setting-value">
                                <input type="text" name="site_desc" class="setting-input" value="<?= htmlspecialchars($settings['site_description'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_domain ?></span>
                            <span class="setting-value">
                                <input type="text" name="site_domain" class="setting-input" value="<?= htmlspecialchars($settings['site_domain'] ?? '') ?>" required>
                            </span>
                        </div>
                    </div>

                    <!-- Database & System -->
                    <div class="settings-card">
                        <h3><span>⚙️</span> <?= $system_db_title ?></h3>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_db_host ?></span>
                            <span class="setting-value" style="opacity: 0.7;"><?= htmlspecialchars($env['db_host'] ?? 'localhost') ?></span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_db_name ?></span>
                            <span class="setting-value" style="opacity: 0.7;"><?= htmlspecialchars($env['db_name'] ?? 'Niet ingesteld') ?></span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_db_user ?></span>
                            <span class="setting-value">
                                <input type="text" name="db_user" class="setting-input" value="<?= htmlspecialchars($env['db_user'] ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_db_pass ?></span>
                            <span class="setting-value">
                                <input type="password" name="db_pass" class="setting-input" value="<?= htmlspecialchars(\NexSite\Config::get('DB_PASSWORD') ?? '') ?>" required>
                            </span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_db_prefix ?></span>
                            <span class="setting-value"><code><?= htmlspecialchars($env['db_prefix'] ?? 'nscms_') ?></code></span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_install_date ?></span>
                            <span class="setting-value" style="opacity: 0.7;"><?= htmlspecialchars($settings['installed_at'] ?? 'Onbekend') ?></span>
                        </div>
                        <div class="setting-row">
                            <span class="setting-label"><?= $label_cms_version ?></span>
                            <span class="setting-value"><span class="badge badge-success">v<?= htmlspecialchars($env['version'] ?? '0.1.0') ?></span></span>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 30px; display: flex; gap: 20px; align-items: center; justify-content: flex-end;">
                    <button type="submit" class="btn-save"><?= $btn_save_apply ?></button>
                    <a href="/backoffice" class="btn-secondary"><?= $btn_cancel ?></a>
                </div>
            </form>
        </main>
    </div>

    <script>
        const userWidget = document.getElementById('user-widget');
        const userMenu = document.getElementById('user-menu');
        const langSwitcher = document.getElementById('lang-switcher');

        function handleFlagClick(event, lang) {
            const currentParams = new URLSearchParams(window.location.search);
            const currentLang = '<?= $_SESSION['lang'] ?? 'nl' ?>';

            if (currentLang === lang) {
                event.preventDefault();
                langSwitcher.classList.toggle('expanded');
                return;
            }
            // Allow default navigation to switch language
        }

        userWidget.addEventListener('click', (e) => {
            e.stopPropagation();
            userMenu.classList.toggle('active');
        });

        document.addEventListener('click', (e) => {
            if (userMenu && !userWidget.contains(e.target)) {
                userMenu.classList.remove('active');
            }
            if (langSwitcher && !langSwitcher.contains(e.target)) {
                langSwitcher.classList.remove('expanded');
            }
        });
    </script>
</body>

</html>
