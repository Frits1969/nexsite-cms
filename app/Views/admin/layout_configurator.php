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
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Configurator | Fritsion CMS</title>
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
            --preview-bg: #cbd5e1;
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

        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            height: 100vh;
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
            z-index: 90;
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
        }

        .config-section {
            margin-bottom: 40px;
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
        }

        .col-item {
            background: #fff;
            padding: 10px;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px dashed #cbd5e1;
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

        /* Right: Live Preview */
        .preview-panel {
            padding: 40px;
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
            min-height: 1000px;
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
            display: flex;
            gap: 10px;
            background: #f8fafc;
            height: 60px;
            align-items: center;
        }

        .pv-main {
            flex: 1;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .pv-footer {
            padding: 20px;
            border-top: 1px solid #eee;
            display: flex;
            gap: 10px;
            background: #f8fafc;
            min-height: 80px;
            margin-top: auto;
        }

        .pv-section-block {
            background: #e2e8f0;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            position: relative;
            overflow: hidden;
        }

        .pv-section-block::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.1) 75%, transparent 75%, transparent);
            background-size: 20px 20px;
            opacity: 0.1;
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
        }

        .pv-col-type {
            font-size: 0.65rem;
            font-weight: 800;
            color: #475569;
        }

        .pv-col-icon {
            font-size: 1.5rem;
        }

        .save-bar {
            position: absolute;
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
            transition: transform 0.2s;
        }

        .btn-save:hover {
            transform: translateY(-3px);
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
                <?= $nav_templates ?> / Homepage Configurator
            </div>
        </header>

        <div class="config-container">
            <!-- Form Side -->
            <div class="config-panel" id="configPanel">
                <div class="config-section">
                    <h2><span>🎨</span> Header</h2>
                    <div class="form-group">
                        <label class="form-label">Aantal vlakken</label>
                        <input type="number" class="form-input" id="headerCount" min="1" max="5"
                            onchange="updateHeaderCount(this.value)">
                    </div>
                    <div id="headerSections"></div>
                </div>

                <div class="config-section">
                    <h2><span>📄</span> Middenstuk</h2>
                    <div id="mainRows"></div>
                    <button class="btn-add" onclick="addRow()"><span>➕</span> Rij toevoegen</button>
                </div>

                <div class="config-section">
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

        <form action="/backoffice/templates/homepage/save" method="POST" id="layoutForm">
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
                    <select class="form-select" onchange="updateSectionType('header', ${i}, this.value)">
                        ${renderOptions(sec.type, ['logo', 'menu', 'text', 'cta', 'image', 'socials'])}
                    </select>
                </div>`;
            });
            document.getElementById('headerSections').innerHTML = hHtml;

            // Main Rows
            let mHtml = '';
            state.main.rows.forEach((row, ri) => {
                mHtml += `<div class="row-item">
                    <button class="btn-remove" onclick="removeRow(${ri})">✖</button>
                    <div class="form-group">
                        <label class="form-label">Rij ${ri + 1} kolommen</label>
                        <select class="form-select" onchange="updateColCount(${ri}, this.value)">
                            ${[1, 2, 3, 4].map(n => `<option value="${n}" ${row.columns.length == n ? 'selected' : ''}>${n} Kolom${n > 1 ? 'men' : ''}</option>`).join('')}
                        </select>
                    </div>
                    <div class="cols-container">
                        ${row.columns.map((col, ci) => `
                            <div class="col-item">
                                <label class="form-label" style="font-size: 0.75rem;">Kolom ${ci + 1} type</label>
                                <select class="form-select" onchange="updateColType(${ri}, ${ci}, this.value)">
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
                    <select class="form-select" onchange="updateSectionType('footer', ${i}, this.value)">
                        ${renderOptions(sec.type, ['text', 'menu', 'socials', 'cta', 'logo'])}
                    </select>
                </div>`;
            });
            document.getElementById('footerSections').innerHTML = fHtml;
        }

        function renderOptions(selected, filter = []) {
            return contentTypes
                .filter(ct => filter.length === 0 || filter.includes(ct.id))
                .map(ct => `<option value="${ct.id}" ${ct.id === selected ? 'selected' : ''}>${ct.icon} ${ct.name}</option>`)
                .join('');
        }

        function renderPreview() {
            // Header Preview
            document.getElementById('pvHeader').innerHTML = state.header.sections.map(sec => {
                let info = contentTypes.find(ct => ct.id === sec.type);
                return `<div class="pv-section-block" style="flex: 1; height: 100%;">${info.icon}</div>`;
            }).join('');

            // Main Preview
            document.getElementById('pvMain').innerHTML = state.main.rows.map(row => {
                return `<div class="pv-row" style="grid-template-columns: repeat(${row.columns.length}, 1fr);">
                    ${row.columns.map(col => {
                    let info = contentTypes.find(ct => ct.id === col.type);
                    return `<div class="pv-col">
                            <span class="pv-col-icon">${info.icon}</span>
                            <span class="pv-col-type">${info.name}</span>
                        </div>`;
                }).join('')}
                </div>`;
            }).join('');

            // Footer Preview
            document.getElementById('pvFooter').innerHTML = state.footer.sections.map(sec => {
                let info = contentTypes.find(ct => ct.id === sec.type);
                return `<div class="pv-section-block" style="flex: 1; height: 100%; min-height: 40px;">${info.icon}</div>`;
            }).join('');
        }

        function saveLayout() {
            document.getElementById('layoutJsonInput').value = JSON.stringify(state);
            document.getElementById('layoutForm').submit();
        }

        window.onload = init;
    </script>
</body>

</html>