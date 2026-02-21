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
            --sidebar-width: 280px;
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
            background: rgba(232, 24, 106, 0.1) !important;
            font-weight: 600;
        }

        .submenu {
            padding-left: 40px;
            margin-bottom: 10px;
        }

        .submenu-item {
            display: block;
            padding: 8px 0;
            color: #64748b;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.2s;
        }

        .submenu-item:hover,
        .submenu-item.active {
            color: var(--accent-pink);
        }

        .sidebar-footer {
            padding: 20px;
            border-top: 1px solid var(--glass-border);
            text-align: center;
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
            flex: 1;
        }

        .template-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 30px;
            margin-top: 30px;
        }

        .template-card {
            background: var(--secondary-bg);
            border-radius: 20px;
            padding: 30px;
            border: 2px solid transparent;
            transition: all 0.3s;
            cursor: pointer;
            position: relative;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .template-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
        }

        .template-card.selected {
            border-color: var(--accent-pink);
            background: rgba(232, 24, 106, 0.02);
        }

        .template-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            display: block;
        }

        .template-card h3 {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--text-main);
        }

        .template-card p {
            font-size: 0.9rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .selected-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--accent-pink);
            color: white;
            padding: 4px 12px;
            border-radius: 100px;
            font-size: 0.75rem;
            font-weight: 700;
            display: none;
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
        }

        .btn-save {
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-save:hover {
            transform: scale(1.02);
        }

        .alert {
            padding: 15px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            font-weight: 500;
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);">
                <?= $nav_templates ?> / Alleen homepage
            </div>
        </header>

        <main class="content">
            <?php if (isset($_GET['saved'])): ?>
                <div class="alert">Homepage structuur succesvol opgeslagen!</div>
            <?php endif; ?>

            <h1>Kies uw Homepage Structuur</h1>
            <p style="color: var(--text-muted); margin-top: 10px;">Selecteer de gewenste layout voor uw startpagina.
                Elke structuur is geoptimaliseerd voor een specifiek doel.</p>

            <form action="/backoffice/templates/homepage/save" method="POST" id="templateForm">
                <input type="hidden" name="template" id="selectedTemplateInput" value="<?= $currentTemplate ?>">
                <div class="template-grid">
                    <?php foreach ($templates as $tpl): ?>
                        <div class="template-card <?= $currentTemplate === $tpl['id'] ? 'selected' : '' ?>"
                            onclick="selectTemplate('<?= $tpl['id'] ?>', this)">
                            <span class="selected-badge">Geselecteerd</span>
                            <span class="template-icon">
                                <?= $tpl['icon'] ?>
                            </span>
                            <h3>
                                <?= $tpl['name'] ?>
                            </h3>
                            <p>
                                <?= $tpl['description'] ?>
                            </p>
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
    </script>
</body>

</html>