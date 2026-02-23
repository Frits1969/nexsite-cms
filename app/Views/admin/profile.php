<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'nl' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="/assets/logo/logo_fritsion_cms_favicon.png">
    <link rel="shortcut icon" href="/assets/logo/logo_fritsion_cms_favicon.ico">
    <title><?= $profile_title ?> | Fritsion CMS</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #F1F4F9;
            --secondary-bg: #FFFFFF;
            --accent-color: #8B5CF6;
            --accent-purple: #3B2A8C;
            --accent-pink: #E8186A;
            --accent-orange: #F0961B;
            --accent-gradient: linear-gradient(135deg, #E8186A 0%, #C41257 40%, #F0961B 100%);
            --text-main: #1A1336;
            --text-muted: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(0, 0, 0, 0.05);
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

        /* Sidebar Styling (Simplified clone from dashboard) */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #FFFFFF;
            border-right: 1px solid rgba(0, 0, 0, 0.05);
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
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar-header img {
            max-width: 130px;
            height: auto;
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
            color: #475569;
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(232, 24, 106, 0.05);
            color: var(--accent-pink);
        }

        .nav-item.active {
            position: relative;
            background: rgba(232, 24, 106, 0.1) !important;
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

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .sidebar-footer p {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
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
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .profile-card {
            background: var(--secondary-bg);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            padding: 40px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--glass-border);
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: var(--accent-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(232, 24, 106, 0.25);
        }

        .profile-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-title p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .form-group input {
            width: 100%;
            padding: 14px 20px;
            background: #F8FAFC;
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-main);
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent-pink);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(232, 24, 106, 0.12);
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

        .btn-save {
            width: 100%;
            padding: 16px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(232, 24, 106, 0.3);
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
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
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

        .section-divider {
            margin: 40px 0 30px;
            padding-top: 30px;
            border-top: 1px solid var(--glass-border);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>
    <?php $uri = strtok($_SERVER['REQUEST_URI'] ?? '/backoffice', '?'); ?>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="/assets/logo/logo_fritsion_cms.png" alt="Logo">
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
        <div class="sidebar-footer">
            <p style="font-size: 0.8rem; color: #64748b;">v<?= \Fritsion\App::VERSION ?></p>
        </div>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);"><?= $backoffice_title ?> / <?= $nav_profile ?>
            </div>
            <div style="display: flex; align-items: center; gap: 20px;">
                <a href="/backoffice"
                    style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;"><?= $nav_back_to_dashboard ?></a>

                <div class="user-widget" id="user-widget"
                    style="position: relative; display: flex; align-items: center; gap: 12px; cursor: pointer;">
                    <div class="user-avatar"
                        style="width: 32px; height: 32px; background: var(--accent-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; color: white;">
                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                    </div>
                    <div class="user-info">
                        <span class="user-name"><?= $user['username'] ?? 'Admin' ?></span>
                        <span class="user-role"><?= $role_super_admin ?></span>
                    </div>
                    <!-- User Menu Dropdown -->
                    <div class="user-menu" id="user-menu">
                        <a href="/backoffice/profile" class="menu-item active"><?= $nav_profile ?></a>
                        <hr style="margin: 5px 0; border: none; border-top: 1px solid var(--glass-border);">
                        <a href="/backoffice/logout" class="menu-item logout"><?= $nav_logout ?></a>
                    </div>
                </div>

                <div class="lang-select" id="lang-switcher">
                    <?php $selectedLang = $_SESSION['lang'] ?? 'nl'; ?>
                    <a href="?lang=nl" class="<?= $selectedLang === 'nl' ? 'active' : '' ?>"
                        onclick="handleFlagClick(event, 'nl')">
                        <img src="/assets/flags/nl.svg" alt="Nederlands" class="flag-icon">
                    </a>
                    <a href="?lang=en" class="<?= $selectedLang === 'en' ? 'active' : '' ?>"
                        onclick="handleFlagClick(event, 'en')">
                        <img src="/assets/flags/en.svg" alt="English" class="flag-icon">
                    </a>
                </div>
            </div>
        </header>

        <main class="content">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                    </div>
                    <div class="profile-title">
                        <h1><?= $profile_title ?></h1>
                        <p><?= $profile_desc ?></p>
                    </div>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <span>⚠️</span> <?= $error ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <span>✅</span> <?= $success ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="username"><?= $username_label ?></label>
                        <input type="text" id="username" name="username"
                            value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email"><?= $email_label ?></label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>"
                            required>
                    </div>

                    <div class="section-divider">
                        <h3 class="section-title"><span>🔒</span> <?= $password_change_title ?></h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
                            <?= $password_change_tip ?>
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="new_password"><?= $label_new_password ?></label>
                        <input type="password" id="new_password" name="new_password" autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password"><?= $label_confirm_password ?></label>
                        <input type="password" id="confirm_password" name="confirm_password"
                            autocomplete="new-password">
                    </div>

                    <div class="section-divider">
                        <h3 class="section-title"><span>🛡️</span> <?= $confirm_changes_title ?></h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">
                            <?= $confirm_changes_tip ?>
                        </p>
                    </div>

                    <div class="form-group">
                        <label for="current_password"><?= $label_current_password ?></label>
                        <input type="password" id="current_password" name="current_password" required
                            autocomplete="current-password">
                    </div>

                    <div style="margin-top: 30px; display: flex; gap: 15px; align-items: center;">
                        <button type="submit" class="btn-save"
                            style="width: auto; padding: 12px 30px; margin-top: 0;"><?= $btn_save_profile ?></button>
                        <a href="/backoffice" class="btn-secondary"><?= $btn_cancel ?></a>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <script>
        const userWidget = document.querySelector('.user-avatar');
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