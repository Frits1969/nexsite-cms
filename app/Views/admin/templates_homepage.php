<?php
$uri = strtok($_SERVER['REQUEST_URI'] ?? '/backoffice', '?');
$lang = $GLOBALS['lang'] ?? [];
$nav_dashboard = $lang['nav_dashboard'] ?? 'Dashboard';
$nav_pages = $lang['nav_pages'] ?? 'Pagina\'s';
$nav_media = $lang['nav_media'] ?? 'Media';
$nav_templates = $lang['nav_templates'] ?? 'Templates';
$nav_themes = $lang['nav_themes'] ?? 'Thema\'s';
$nav_settings = $lang['nav_settings'] ?? 'Instellingen';
$nav_visit_site = $lang['nav_visit_site'] ?? 'Website bekijken';
$backoffice_title = $lang['backoffice_title'] ?? 'Fritsion Backoffice';
$role_super_admin = $lang['role_super_admin'] ?? 'Super Admin';
$nav_profile = $lang['nav_profile'] ?? 'Profiel';
$nav_logout = $lang['nav_logout'] ?? 'Uitloggen';
$nav_back_to_dashboard = $lang['nav_back_to_dashboard'] ?? 'Terug naar Dashboard';
?>
<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'nl' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage Templates | Fritsion CMS</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="icon" type="image/png" href="/assets/logo/logo_fritsion_cms_favicon.png">
    <style>
        :root {
            --primary-bg: #F1F4F9;
            --secondary-bg: #FFFFFF;
            --accent-pink: #E8186A;
            --accent-orange: #F0961B;
            --accent-gradient: linear-gradient(135deg, #E8186A 0%, #C41257 40%, #F0961B 100%);
            --text-main: #1A1336;
            --text-muted: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.8);
            --glass-border: rgba(0, 0, 0, 0.05);
            --sidebar-width: 260px;
            --wf-bg: #e2e8f0;
            --wf-hero: #cbd5e1;
            --wf-block: #94a3b8;
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
            display: flex;
        }

        /* Sidebar Styling stays the same as dashboard for consistency */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: #FFFFFF;
            border-right: 1px solid var(--glass-border);
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
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

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        /* User Widget */
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
            background: rgba(232, 24, 106, 0.05);
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: var(--accent-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
            color: white;
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
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            z-index: 110;
        }

        .user-menu.active {
            display: block;
            animation: slideUp 0.3s ease;
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
        }

        .menu-item:hover {
            background: rgba(232, 24, 106, 0.05);
            color: var(--text-main);
        }

        .menu-item.logout {
            color: #ef4444;
        }

        /* Language Switcher */
        .lang-select {
            display: flex;
            position: relative;
            align-items: center;
            gap: 10px;
            background: #f8fafc;
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
            width: 32px;
            height: 22px;
            border-radius: 3px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.2s;
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

        .content {
            padding: 40px;
            flex: 1;
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        .header-section {
            margin-bottom: 40px;
        }

        .header-section h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .header-section p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .template-card {
            background: var(--secondary-bg);
            border-radius: 24px;
            padding: 25px;
            border: 2px solid transparent;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
            border: 1px solid var(--glass-border);
        }

        .template-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            border-color: rgba(232, 24, 106, 0.2);
        }

        .template-card.selected {
            border-color: var(--accent-pink);
            background: rgba(232, 24, 106, 0.01);
            box-shadow: 0 10px 30px rgba(232, 24, 106, 0.08);
        }

        /* Wireframe Styles */
        .preview-container {
            width: 100%;
            height: 140px;
            background: var(--wf-bg);
            border-radius: 12px;
            margin-bottom: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            padding: 8px;
            gap: 4px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .wf-rect {
            border-radius: 3px;
            background: var(--wf-block);
            opacity: 0.6;
        }

        .wf-header {
            height: 8px;
            width: 40%;
            background: var(--wf-block);
            margin-bottom: 4px;
        }

        .wf-hero {
            flex: 1;
            background: var(--wf-hero);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .wf-hero::after {
            content: 'HERO';
            font-size: 8px;
            font-weight: 800;
            color: #fff;
            opacity: 0.5;
        }

        .wf-grid {
            display: grid;
            gap: 4px;
            padding-top: 4px;
        }

        .wf-footer {
            height: 6px;
            width: 100%;
            background: var(--wf-block);
            opacity: 0.3;
            margin-top: auto;
        }

        .template-info {
            flex: 1;
        }

        .template-card h3 {
            font-size: 1.25rem;
            margin-bottom: 10px;
            color: var(--text-main);
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 700;
        }

        .template-card p {
            font-size: 0.95rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .selected-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--accent-pink);
            color: white;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 800;
            display: none;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .template-card.selected .selected-badge {
            display: block;
        }

        .save-bar {
            position: sticky;
            bottom: 0;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            padding: 20px 40px;
            border-top: 1px solid var(--glass-border);
            display: flex;
            justify-content: flex-end;
            z-index: 100;
        }

        .btn-save {
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 14px 40px;
            border-radius: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(232, 24, 106, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(232, 24, 106, 0.4);
        }

        .alert {
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 12px;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <?php
    function renderPreview($type)
    {
        $html = '<div class="preview-container">';
        $html .= '<div class="wf-header"></div>';

        switch ($type) {
            case 'usps':
                $html .= '<div class="wf-hero"></div>';
                $html .= '<div class="wf-grid" style="grid-template-columns: repeat(3, 1fr);">';
                $html .= '<div class="wf-rect" style="height: 20px;"></div><div class="wf-rect" style="height: 20px;"></div><div class="wf-rect" style="height: 20px;"></div>';
                $html .= '</div>';
                break;
            case 'cta_image':
                $html .= '<div class="wf-hero" style="display: flex; gap: 4px; padding: 4px;">';
                $html .= '<div style="flex: 1; background: rgba(255,255,255,0.2); height: 100%;"></div>';
                $html .= '<div style="flex: 1; background: var(--wf-block); height: 100%; border-radius: 4px;"></div>';
                $html .= '</div>';
                break;
            case 'services':
                $html .= '<div class="wf-hero" style="height: 30px; flex: none;"></div>';
                $html .= '<div class="wf-grid" style="grid-template-columns: repeat(3, 1fr); flex: 1;">';
                $html .= '<div class="wf-rect"></div><div class="wf-rect"></div><div class="wf-rect"></div>';
                $html .= '</div>';
                break;
            case 'blog':
                $html .= '<div class="wf-hero" style="height: 30px; flex: none;"></div>';
                $html .= '<div class="wf-grid" style="grid-template-columns: 1fr 1fr; flex: 1;">';
                $html .= '<div class="wf-rect"></div><div class="wf-rect"></div>';
                $html .= '</div>';
                break;
            case 'video':
                $html .= '<div class="wf-hero"><div style="width: 20px; height: 20px; border-radius: 50%; border: 2px solid #fff; display: flex; align-items: center; justify-content: center; font-size: 8px;">▶</div></div>';
                $html .= '<div class="wf-grid" style="grid-template-columns: 1fr 1fr;">';
                $html .= '<div class="wf-rect" style="height: 15px; opacity: 0.3;"></div><div class="wf-rect" style="height: 15px; opacity: 0.3;"></div>';
                $html .= '</div>';
                break;
            case 'split':
                $html .= '<div style="display: flex; flex: 1; gap: 0; margin: -8px; margin-top: 0;">';
                $html .= '<div style="flex: 1; padding: 10px; display: flex; flex-direction: column; gap: 4px;"><div class="wf-rect" style="height: 6px; width: 80%;"></div><div class="wf-rect" style="height: 6px; width: 60%;"></div></div>';
                $html .= '<div style="flex: 1; background: var(--wf-hero);"></div>';
                $html .= '</div>';
                break;
        }

        $html .= '<div class="wf-footer"></div>';
        $html .= '</div>';
        return $html;
    }
    ?>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);">
                <?= $nav_templates ?> / Homepage
            </div>

            <div class="topbar-actions">
                <a href="/backoffice"
                    style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;"><?= $nav_back_to_dashboard ?></a>

                <div class="user-widget" id="user-widget">
                    <div class="user-avatar">
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
            <?php if (isset($_GET['saved'])): ?>
                <div class="alert">✅ Homepage structuur succesvol opgeslagen!</div>
            <?php endif; ?>

            <div class="header-section">
                <h1>Kies uw Homepage Structuur</h1>
                <p>Selecteer de gewenste layout voor uw startpagina. Elke structuur is geoptimaliseerd voor een
                    specifiek doel.</p>
            </div>

            <form action="/backoffice/templates/homepage/save" method="POST" id="templateForm">
                <input type="hidden" name="template" id="selectedTemplateInput" value="<?= $currentTemplate ?>">
                <div class="template-grid">
                    <?php foreach ($templates as $tpl): ?>
                        <div class="template-card <?= $currentTemplate === $tpl['id'] ? 'selected' : '' ?>"
                            onclick="selectTemplate('<?= $tpl['id'] ?>', this)">
                            <span class="selected-badge">Actief</span>

                            <?= renderPreview($tpl['preview_type'] ?? 'usps') ?>

                            <div class="template-info">
                                <h3><span>
                                        <?= $tpl['icon'] ?>
                                    </span>
                                    <?= $tpl['name'] ?>
                                </h3>
                                <p>
                                    <?= $tpl['description'] ?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>
        </main>

        <div class="save-bar">
            <button type="button" class="btn-save" onclick="document.getElementById('templateForm').submit()">Layout
                Opslaan</button>
        </div>
    </div>

    <script>
        function selectTemplate(id, element) {
            document.querySelectorAll('.template-card').forEach(card => card.classList.remove('selected'));
            element.classList.add('selected');
            document.getElementById('selectedTemplateInput').value = id;
        }

        const userWidget = document.getElementById('user-widget');
        const userMenu = document.getElementById('user-menu');
        const langSwitcher = document.getElementById('lang-switcher');

        function handleFlagClick(event, lang) {
            const currentLang = '<?= $_SESSION['lang'] ?? 'nl' ?>';

            if (currentLang === lang) {
                event.preventDefault();
                langSwitcher.classList.toggle('expanded');
                return;
            }
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