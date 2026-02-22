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
    <title><?= $pageType === 'content' ? 'Contentpagina Layout' : 'Homepage Layout' ?> | Fritsion CMS</title>
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
            --preview-bg: #cbd5e1;
            --highlight-color: rgba(232, 24, 106, 0.2);
            --highlight-border: #E8186A;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--primary-bg);
            color: var(--text-main);
            display: flex;
            overflow: hidden;
        }

        /* Sidebar Styling (Identical to Dashboard) */
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
            border-top: 1px solid var(--glass-border);
            text-align: center;
        }

        .sidebar-footer p {
            font-size: 0.8rem;
            color: #64748b;
            font-weight: 500;
        }

        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            height: 100vh;
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
            z-index: 90;
            flex-shrink: 0;
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

        @media (max-width: 1024px) {
            .sidebar {
                width: 80px;
            }

            .sidebar-header img {
                max-width: 40px;
            }

            .nav-item span,
            .user-info {
                display: none;
            }

            .main-wrapper {
                margin-left: 80px;
            }

            .sidebar-header,
            .nav-item {
                justify-content: center;
            }
        }

        .config-container {
            flex: 1;
            display: grid;
            grid-template-columns: 450px 1fr;
            overflow: hidden;
        }

        /* Left: Config Panel */
        .config-panel {
            padding: 30px;
            overflow-y: auto;
            background: #fff;
            border-right: 1px solid var(--glass-border);
            scroll-behavior: smooth;
        }

        .config-section {
            margin-bottom: 40px;
            border-radius: 16px;
            transition: all 0.3s;
        }

        .config-section.highlighted {
            background: rgba(232, 24, 106, 0.03);
            box-shadow: 0 0 0 10px rgba(232, 24, 106, 0.03);
        }

        .config-section h2 {
            font-size: 1.25rem;
            margin-bottom: 20px;
            color: var(--accent-pink);
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-group {
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .form-group.highlighted {
            background: var(--highlight-color);
            border: 1px solid var(--highlight-border);
        }

        .form-label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            margin-bottom: 8px;
            color: #475569;
        }

        .form-select,
        .form-input {
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-family: inherit;
            font-size: 0.9rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .form-select:focus,
        .form-input:focus {
            border-color: var(--accent-pink);
        }

        .row-item {
            background: #f8fafc;
            padding: 15px;
            border-radius: 12px;
            margin-bottom: 15px;
            border: 1px solid #e2e8f0;
            position: relative;
            transition: all 0.3s;
        }

        .row-item.highlighted {
            background: var(--highlight-color);
            border: 1px solid var(--highlight-border);
        }

        .col-item {
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px dashed #cbd5e1;
            transition: all 0.3s;
        }

        .col-item.highlighted {
            background: rgba(232, 24, 106, 0.1);
            border-style: solid;
            border-color: var(--accent-pink);
        }

        .btn-add {
            background: #f1f5f9;
            border: none;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            cursor: pointer;
            color: #475569;
            display: flex;
            align-items: center;
            gap: 5px;
            margin-top: 10px;
            transition: all 0.2s;
        }

        .btn-add:hover {
            background: #e2e8f0;
            color: var(--text-main);
        }

        .btn-remove {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            color: #ef4444;
            cursor: pointer;
            font-size: 1rem;
            opacity: 0.5;
            transition: opacity 0.2s;
        }

        .btn-remove:hover {
            opacity: 1;
        }

        .row-actions {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 5px;
            align-items: center;
        }

        .btn-action {
            background: #fff;
            border: 1px solid #e2e8f0;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            color: #64748b;
            transition: all 0.2s;
        }

        .btn-action:hover:not(:disabled) {
            background: #f1f5f9;
            color: var(--text-main);
            border-color: #cbd5e1;
        }

        .btn-action:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .btn-action.remove {
            color: #ef4444;
            border-color: #fca5a5;
        }

        .btn-action.remove:hover {
            background: #fee2e2;
        }

        /* Right: Live Preview */
        .preview-panel {
            padding: 40px 40px 100px 40px;
            background: #f1f5f9;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            overflow-y: auto;
        }

        .preview-canvas {
            background: #fff;
            width: 100%;
            max-width: 900px;
            min-height: 400px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            position: relative;
            transition: all 0.3s;
        }

        .pv-header {
            padding: 15px;
            border-bottom: 1px solid #eee;
            display: grid;
            gap: 10px;
            background: #f8fafc;
            min-height: 80px;
            align-items: center;
        }

        .pv-main {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .pv-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: grid;
            gap: 10px;
            background: #f8fafc;
            min-height: 100px;
            margin-top: auto;
        }

        .pv-row {
            display: grid;
            gap: 10px;
            min-height: 100px;
        }

        .pv-col {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 10px;
            min-height: 80px;
            flex-direction: column;
            gap: 5px;
            color: #94a3b8;
            background: #fff;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }

        .pv-col:hover {
            border-color: var(--accent-pink);
            background: rgba(232, 24, 106, 0.05);
            transform: scale(1.02);
            z-index: 10;
        }

        .pv-col.highlighted {
            border-color: var(--accent-pink);
            background: rgba(232, 24, 106, 0.05);
            border-style: solid;
            box-shadow: 0 0 15px rgba(232, 24, 106, 0.2);
            z-index: 11;
        }

        .pv-col.pv-compact {
            min-height: 60px;
            padding: 5px;
        }

        .pv-col-type {
            font-size: 0.65rem;
            font-weight: 800;
            color: #475569;
        }

        .pv-col-icon {
            font-size: 1.5rem;
        }

        .pv-compact .pv-col-icon {
            font-size: 1.1rem;
        }

        .pv-compact .pv-col-type {
            font-size: 0.55rem;
        }

        .save-bar {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 100;
        }

        .btn-save {
            background: var(--accent-gradient);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(232, 24, 106, 0.3);
            transition: all 0.3s;
        }

        .btn-save:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(232, 24, 106, 0.4);
        }

        .alert-toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: #10b981;
            color: white;
            padding: 12px 30px;
            border-radius: 100px;
            font-weight: 600;
            display: none;
            z-index: 200;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);">
                <?= $nav_templates ?> / <?= $pageType === 'content' ? 'Contentpagina' : 'Homepage' ?>
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

        <div class="config-container">
            <!-- Form Side -->
            <div class="config-panel" id="configPanel">
                <div class="config-section" id="section-header">
                    <h2><span>🎨</span> Header</h2>
                    <div class="form-group">
                        <label class="form-label">Aantal vlakken</label>
                        <input type="number" class="form-input" id="headerCount" min="1" max="5"
                            onchange="updateHeaderCount(this.value)">
                    </div>
                    <div id="headerSections"></div>
                </div>

                <div class="config-section" id="section-main">
                    <h2><span>📄</span> Middenstuk</h2>
                    <div id="mainRows"></div>
                    <button class="btn-add" onclick="addRow()"><span>➕</span> Rij toevoegen</button>
                </div>

                <div class="config-section" id="section-footer">
                    <h2><span>🏁</span> Footer</h2>
                    <div class="form-group">
                        <label class="form-label">Aantal vlakken</label>
                        <input type="number" class="form-input" id="footerCount" min="1" max="5"
                            onchange="updateFooterCount(this.value)">
                    </div>
                    <div id="footerSections"></div>
                </div>
            </div>

            <!-- Preview Side -->
            <div class="preview-panel">
                <div class="preview-canvas">
                    <div class="pv-header" id="pvHeader"></div>
                    <div class="pv-main" id="pvMain"></div>
                    <div class="pv-footer" id="pvFooter"></div>
                </div>
            </div>
        </div>

        <form action="/backoffice/templates/<?= $pageType === 'content' ? 'content' : 'homepage' ?>/save" method="POST"
            id="layoutForm">
            <input type="hidden" name="layout_json" id="layoutJsonInput">
            <div class="save-bar">
                <button type="button" class="btn-save" onclick="saveLayout()">Configuratie Opslaan</button>
            </div>
        </form>
    </div>

    <div class="alert-toast" id="saveToast">Layout succesvol opgeslagen!</div>

    <script>
        let state = <?= $layoutJson ?>;

        const contentTypes = [
            { id: 'text', name: 'Tekst', icon: '📝' },
            { id: 'image', name: 'Afbeelding', icon: '🖼️' },
            { id: 'video', name: 'Video', icon: '🎬' },
            { id: 'form', name: 'Formulier', icon: '📩' },
            { id: 'cta', name: 'Call to Action', icon: '🎯' },
            { id: 'usps', name: 'USP\'s', icon: '🚀' },
            { id: 'blog', name: 'Blogoverzicht', icon: '✍️' },
            { id: 'products', name: 'Productoverzicht', icon: '🛍️' },
            { id: 'map', name: 'Kaart', icon: '📍' },
            { id: 'html', name: 'Custom HTML', icon: '💻' },
            { id: 'logo', name: 'Logo', icon: '✨' },
            { id: 'menu', name: 'Menu', icon: '☰' },
            { id: 'socials', name: 'Social Icons', icon: '📱' }
        ];

        function init() {
            document.getElementById('headerCount').value = state.header.sections.length;
            document.getElementById('footerCount').value = state.footer.sections.length;
            renderConfig();
            renderPreview();
        }

        // --- Interactive Preview Handling ---
        function handlePreviewClick(path, elementId) {
            // 1. Highlight in preview
            document.querySelectorAll('.pv-col').forEach(el => el.classList.remove('highlighted'));
            const pvElement = document.getElementById(`pv-${elementId}`);
            if (pvElement) pvElement.classList.add('highlighted');

            // 2. Find and highlight in config panel
            const configElement = document.getElementById(`config-${elementId}`);
            if (configElement) {
                // Remove existing highlights
                document.querySelectorAll('.form-group, .row-item, .col-item, .config-section').forEach(el => el.classList.remove('highlighted'));

                // Add highlight to the specific input container
                const container = configElement.closest('.form-group') || configElement.closest('.col-item') || configElement.closest('.row-item');
                if (container) {
                    container.classList.add('highlighted');

                    // Scroll into view
                    container.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        }

        // --- State Management ---
        function updateHeaderCount(val) {
            val = parseInt(val);
            while (state.header.sections.length < val) state.header.sections.push({ type: 'text' });
            while (state.header.sections.length > val) state.header.sections.pop();
            renderConfig();
            renderPreview();
        }

        function updateFooterCount(val) {
            val = parseInt(val);
            while (state.footer.sections.length < val) state.footer.sections.push({ type: 'text' });
            while (state.footer.sections.length > val) state.footer.sections.pop();
            renderConfig();
            renderPreview();
        }

        function updateSectionType(area, index, type) {
            state[area].sections[index].type = type;
            renderPreview();
        }

        function addRow() {
            state.main.rows.push({ columns: [{ type: 'text' }] });
            renderConfig();
            renderPreview();
        }

        function removeRow(index) {
            state.main.rows.splice(index, 1);
            renderConfig();
            renderPreview();
        }

        function moveRow(index, direction) {
            const newIndex = index + direction;
            if (newIndex < 0 || newIndex >= state.main.rows.length) return;

            // Swap rows
            const temp = state.main.rows[index];
            state.main.rows[index] = state.main.rows[newIndex];
            state.main.rows[newIndex] = temp;

            renderConfig();
            renderPreview();

            // Re-highlight the moved row
            setTimeout(() => {
                handlePreviewClick(`content[${newIndex}][0]`, `row-${newIndex}-col-0`);
            }, 100);
        }

        function updateColCount(rowIndex, count) {
            count = parseInt(count);
            let row = state.main.rows[rowIndex];
            while (row.columns.length < count) row.columns.push({ type: 'text' });
            while (row.columns.length > count) row.columns.pop();
            renderConfig();
            renderPreview();
        }

        function updateColType(rowIndex, colIndex, type) {
            state.main.rows[rowIndex].columns[colIndex].type = type;
            renderPreview();
        }

        // --- Rendering ---
        function renderConfig() {
            // Header Sections
            let hHtml = '';
            state.header.sections.forEach((sec, i) => {
                hHtml += `<div class="form-group">
                    <label class="form-label">Vlak ${i + 1} content</label>
                    <select class="form-select" id="config-header-${i}" onchange="updateSectionType('header', ${i}, this.value)">
                        ${renderOptions(sec.type)}
                    </select>
                </div>`;
            });
            document.getElementById('headerSections').innerHTML = hHtml;

            // Main Rows
            let mHtml = '';
            state.main.rows.forEach((row, ri) => {
                const isFirst = ri === 0;
                const isLast = ri === state.main.rows.length - 1;

                mHtml += `<div class="row-item" id="config-row-${ri}">
                    <div class="row-actions">
                        <button class="btn-action" title="Omhoog" onclick="moveRow(${ri}, -1)" ${isFirst ? 'disabled' : ''}>↑</button>
                        <button class="btn-action" title="Omlaag" onclick="moveRow(${ri}, 1)" ${isLast ? 'disabled' : ''}>↓</button>
                        <button class="btn-action remove" title="Verwijderen" onclick="removeRow(${ri})">✖</button>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Rij ${ri + 1} kolommen</label>
                        <select class="form-select" onchange="updateColCount(${ri}, this.value)">
                            ${[1, 2, 3, 4].map(n => `<option value="${n}" ${row.columns.length == n ? 'selected' : ''}>${n} Kolom${n > 1 ? 'men' : ''}</option>`).join('')}
                        </select>
                    </div>
                    <div class="cols-container">
                        ${row.columns.map((col, ci) => `
                            <div class="col-item" id="config-container-row-${ri}-col-${ci}">
                                <label class="form-label" style="font-size: 0.75rem;">Kolom ${ci + 1} type</label>
                                <select class="form-select" id="config-row-${ri}-col-${ci}" onchange="updateColType(${ri}, ${ci}, this.value)">
                                    ${renderOptions(col.type)}
                                </select>
                            </div>
                        `).join('')}
                    </div>
                </div>`;
            });
            document.getElementById('mainRows').innerHTML = mHtml;

            // Footer Sections
            let fHtml = '';
            state.footer.sections.forEach((sec, i) => {
                fHtml += `<div class="form-group">
                    <label class="form-label">Vlak ${i + 1} content</label>
                    <select class="form-select" id="config-footer-${i}" onchange="updateSectionType('footer', ${i}, this.value)">
                        ${renderOptions(sec.type)}
                    </select>
                </div>`;
            });
            document.getElementById('footerSections').innerHTML = fHtml;
        }

        function renderOptions(selected) {
            return contentTypes
                .map(ct => `<option value="${ct.id}" ${ct.id === selected ? 'selected' : ''}>${ct.icon} ${ct.name}</option>`)
                .join('');
        }

        function renderPreview() {
            // Header Preview
            let hEl = document.getElementById('pvHeader');
            hEl.style.gridTemplateColumns = `repeat(${state.header.sections.length}, 1fr)`;
            hEl.innerHTML = state.header.sections.map((sec, i) => {
                let info = contentTypes.find(ct => ct.id === sec.type);
                return `<div class="pv-col pv-compact" id="pv-header-${i}" onclick="handlePreviewClick('header[${i}]', 'header-${i}')">
                        <span class="pv-col-icon">${info.icon}</span>
                        <span class="pv-col-type">${info.name}</span>
                    </div>`;
            }).join('');

            // Main Preview
            document.getElementById('pvMain').innerHTML = state.main.rows.map((row, ri) => {
                return `<div class="pv-row" style="grid-template-columns: repeat(${row.columns.length}, 1fr);">
                    ${row.columns.map((col, ci) => {
                    let info = contentTypes.find(ct => ct.id === col.type);
                    return `<div class="pv-col" id="pv-row-${ri}-col-${ci}" onclick="handlePreviewClick('content[${ri}][${ci}]', 'row-${ri}-col-${ci}')">
                            <span class="pv-col-icon">${info.icon}</span>
                            <span class="pv-col-type">${info.name}</span>
                        </div>`;
                }).join('')}
                </div>`;
            }).join('');

            // Footer Preview
            let fEl = document.getElementById('pvFooter');
            fEl.style.gridTemplateColumns = `repeat(${state.footer.sections.length}, 1fr)`;
            fEl.innerHTML = state.footer.sections.map((sec, i) => {
                let info = contentTypes.find(ct => ct.id === sec.type);
                return `<div class="pv-col pv-compact" id="pv-footer-${i}" onclick="handlePreviewClick('footer[${i}]', 'footer-${i}')">
                        <span class="pv-col-icon">${info.icon}</span>
                        <span class="pv-col-type">${info.name}</span>
                    </div>`;
            }).join('');
        }

        function saveLayout() {
            document.getElementById('layoutJsonInput').value = JSON.stringify(state);
            document.getElementById('layoutForm').submit();
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
            if (e.target.closest('.preview-canvas') === null && e.target.closest('.config-panel') === null) {
                // Clear highlights if clicking outside
                document.querySelectorAll('.pv-col, .form-group, .row-item, .col-item').forEach(el => el.classList.remove('highlighted'));
            }
        });

        window.onload = init;
    </script>
</body>

</html>