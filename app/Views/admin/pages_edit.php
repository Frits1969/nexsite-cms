<!DOCTYPE html>
<html lang="<?= $_SESSION['lang'] ?? 'nl' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= ($mode === 'edit' ? $btn_edit : $btn_add_page) ?> | Fritsion CMS</title>
    <link rel="icon" type="image/png" href="/assets/logo/logo_fritsion_cms_favicon.png">
    <link rel="shortcut icon" href="/assets/logo/logo_fritsion_cms_favicon.ico">
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

        /* Sidebar Styling */
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

        .form-card {
            background: var(--secondary-bg);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.02);
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            color: var(--text-muted);
            font-size: 0.95rem;
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: 12px 15px;
            background: #F8FAFC;
            border: 1px solid var(--glass-border);
            border-radius: 10px;
            color: var(--text-main);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--accent-pink);
            background: rgba(232, 24, 106, 0.05);
        }

        textarea.form-control {
            min-height: 300px;
            resize: vertical;
            font-family: inherit;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%2394a3b8' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 18px;
            padding-right: 45px;
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
            box-shadow: 0 4px 15px rgba(232, 24, 106, 0.3);
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(232, 24, 106, 0.45);
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

        .user-widget {
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .editor-container {
            display: grid;
            grid-template-columns: 450px 1fr;
            gap: 30px;
            align-items: flex-start;
        }

        .blocks-container {
            margin-top: 30px;
            padding-top: 30px;
            border-top: 2px solid #f1f5f9;
        }

        .block-item {
            background: #f8fafc;
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }

        .block-item:hover {
            border-color: var(--accent-pink);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }

        .block-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 15px;
            font-weight: 700;
            color: var(--accent-purple);
        }

        .block-icon {
            font-size: 1.2rem;
        }

        /* Preview Panel */
        .preview-panel {
            position: sticky;
            top: 100px;
            background: #fff;
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
            height: calc(100vh - 140px);
            display: flex;
            flex-direction: column;
        }

        .preview-header {
            padding: 15px 20px;
            background: #f8fafc;
            border-bottom: 1px solid var(--glass-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: #e2e8f0;
        }

        .preview-content {
            flex: 1;
            overflow-y: auto;
            padding: 0;
            background: #f1f5f9;
        }

        .preview-frame {
            width: 100%;
            height: 100%;
            border: none;
            background: #fff;
        }

        .empty-template {
            padding: 40px;
            text-align: center;
            color: var(--text-muted);
        }

        .section-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        .dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        .dropzone:hover,
        .dropzone.dragover {
            border-color: var(--accent-pink);
            background: rgba(232, 24, 106, 0.05);
        }

        .dropzone-text {
            font-size: 0.85rem;
            color: #64748b;
            font-weight: 500;
        }

        .dropzone-icon {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .dropzone img {
            max-width: 100%;
            max-height: 150px;
            border-radius: 8px;
            display: block;
        }

        .dropzone input[type="file"] {
            display: none;
        }

        .upload-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 4px;
            background: var(--accent-gradient);
            width: 0%;
            transition: width 0.3s;
        }

        @media (max-width: 1200px) {
            .editor-container {
                grid-template-columns: 1fr;
            }

            .preview-panel {
                position: relative;
                top: 0;
                height: 500px;
            }
        }
    </style>
</head>

<body>
    <?php include __DIR__ . '/partials/sidebar.php'; ?>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);"><?= $backoffice_title ?> / <?= $pages_title ?> /
                <?= ($mode === 'edit' ? $btn_edit : $btn_add_page) ?>
            </div>

            <div class="topbar-actions">
                <a href="/backoffice/pages"
                    style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;"><?= $nav_back_to_dashboard ?></a>

                <div class="user-widget" id="user-widget">
                    <div class="user-avatar"
                        style="width: 32px; height: 32px; background: var(--accent-gradient); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.85rem; color: white;">
                        <?php
                        $name = $_SESSION['username'] ?? 'Admin';
                        echo strtoupper(substr($name, 0, 1) . (strlen($name) > 1 ? substr($name, 1, 1) : ''));
                        ?>
                    </div>
                    <div class="user-info" style="display: flex; flex-direction: column; margin-left: 10px;">
                        <span class="user-name"
                            style="font-size: 0.9rem; font-weight: 600;"><?= $_SESSION['username'] ?? 'Admin' ?></span>
                        <span class="user-role"
                            style="font-size: 0.75rem; color: var(--text-muted);"><?= $role_super_admin ?></span>
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
            <?php if (isset($error) && $error): ?>
                <div class="alert alert-error"><span>⚠️</span> <?= $error ?></div>
            <?php endif; ?>

            <?php if (isset($success) && $success): ?>
                <div class="alert alert-success"><span>✅</span> <?= $success ?></div>
            <?php endif; ?>

            <div class="header-section">
                <div>
                    <h1><?= ($mode === 'edit' ? $btn_edit : $btn_add_page) ?></h1>
                    <p><?= ($mode === 'edit' ? $success_page_updated : $pages_desc) ?></p>
                </div>
            </div>

            <div class="editor-container">
                <div class="form-card">
                    <form method="POST" id="pageForm">
                        <div class="form-group">
                            <label for="template_id"><?= $label_template ?? 'Template' ?></label>
                            <select id="template_id" name="template_id" class="form-control"
                                onchange="handleTemplateChange(this.value)">
                                <option value=""><?= $label_select_template ?? '-- Selecteer Template --' ?></option>
                                <?php foreach ($templates as $tpl): ?>
                                    <option value="<?= $tpl['id'] ?>" data-type="<?= $tpl['type'] ?>"
                                        <?= ($page['template_id'] ?? '') == $tpl['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($tpl['name']) ?> (<?= ucfirst($tpl['type']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="title"><?= $label_title ?></label>
                            <input type="text" id="title" name="title" class="form-control"
                                value="<?= htmlspecialchars($page['title'] ?? '') ?>" required>
                        </div>

                        <div class="form-group">
                            <label for="slug"><?= $label_slug ?></label>
                            <input type="text" id="slug" name="slug" class="form-control"
                                value="<?= htmlspecialchars($page['slug'] ?? '') ?>" required>
                            <small
                                style="display: block; margin-top: 5px; color: var(--text-muted); font-size: 0.8rem;">
                                De 'slug' is het deel van de URL dat na de domeinnaam komt (bijv. /over-ons).
                            </small>
                        </div>

                        <div class="form-group">
                            <label for="status"><?= $label_status ?></label>
                            <select id="status" name="status" class="form-control">
                                <option value="draft" <?= ($page['status'] ?? '') === 'draft' ? 'selected' : '' ?>>
                                    <?= $status_draft ?>
                                </option>
                                <option value="published" <?= ($page['status'] ?? '') === 'published' ? 'selected' : '' ?>>
                                    <?= $status_published ?>
                                </option>
                            </select>
                        </div>

                        <!-- Dynamic Blocks Section -->
                        <div id="dynamic-blocks" class="blocks-container">
                            <div class="empty-template">Selecteer een template om blokken te bewerken.</div>
                        </div>

                        <input type="hidden" name="content" id="content-json">

                        <div
                            style="display: flex; gap: 20px; align-items: center; justify-content: flex-end; margin-top: 30px;">
                            <button type="submit" class="btn-save"><?= $btn_save ?></button>
                            <a href="/backoffice/pages" class="btn-secondary"><?= $btn_cancel ?></a>
                        </div>
                    </form>
                </div>

                <!-- Preview Panel -->
                <div class="preview-panel">
                    <div class="preview-header">
                        <div style="display: flex; gap: 6px;">
                            <div class="preview-dot"></div>
                            <div class="preview-dot"></div>
                            <div class="preview-dot"></div>
                        </div>
                        <div style="font-size: 0.75rem; font-weight: 600; color: var(--text-muted);">LIVE PREVIEW</div>
                        <div style="width: 40px;"></div>
                    </div>
                    <div class="preview-content">
                        <iframe id="preview-frame" class="preview-frame"></iframe>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const dynamicBlocksContainer = document.getElementById('dynamic-blocks');
        const previewFrame = document.getElementById('preview-frame');
        const contentJsonInput = document.getElementById('content-json');

        let currentTemplate = null;
        let pageData = <?= json_encode(json_decode($page['content'] ?? '{}', true)) ?>;

        const blockDefinitions = {
            'text': { name: 'Tekst', icon: '📝', fields: [{ name: 'title', type: 'text', label: 'Titel' }, { name: 'text', type: 'textarea', label: 'Inhoud' }] },
            'image': { name: 'Afbeelding', icon: '🖼️', fields: [{ name: 'url', type: 'image', label: 'Afbeelding' }, { name: 'alt', type: 'text', label: 'Alt tekst' }] },
            'cta': { name: 'Call to Action', icon: '🎯', fields: [{ name: 'title', type: 'text', label: 'Titel' }, { name: 'button_text', type: 'text', label: 'Button tekst' }, { name: 'url', type: 'text', label: 'Link' }] },
            'logo': { name: 'Logo', icon: '✨', fields: [{ name: 'url', type: 'image', label: 'Logo' }] },
            'menu': { name: 'Menu', icon: '☰', fields: [{ name: 'items', type: 'text', label: 'Menu items (komma gescheiden)' }] },
            'socials': { name: 'Socials', icon: '📱', fields: [{ name: 'facebook', type: 'text', label: 'Facebook URL' }, { name: 'instagram', type: 'text', label: 'Instagram URL' }] },
            'usps': { name: 'USP\'s', icon: '🚀', fields: [{ name: 'usp_1', type: 'text', label: 'USP 1' }, { name: 'usp_2', type: 'text', label: 'USP 2' }, { name: 'usp_3', type: 'text', label: 'USP 3' }] },
            'video': { name: 'Video', icon: '🎬', fields: [{ name: 'url', type: 'text', label: 'YouTube/Video URL' }] },
            'html': { name: 'Custom HTML', icon: '💻', fields: [{ name: 'code', type: 'textarea', label: 'HTML/Embed Code' }] },
            'map': { name: 'Kaart', icon: '📍', fields: [{ name: 'address', type: 'text', label: 'Adres' }] }
        };

        async function handleTemplateChange(templateId) {
            if (!templateId) {
                dynamicBlocksContainer.innerHTML = '<div class="empty-template">Selecteer een template om blokken te bewerken.</div>';
                updatePreview();
                return;
            }

            try {
                const response = await fetch(`/backoffice/templates/get/${templateId}`);
                const template = await response.json();
                currentTemplate = template;

                const layout = JSON.parse(template.layout_json);
                renderBlockFields(layout);

                // Specific Homepage logic
                if (template.type === 'homepage') {
                    slugInput.value = '/';
                    slugInput.readOnly = true;
                } else {
                    slugInput.readOnly = false;
                }

                updatePreview();
            } catch (error) {
                console.error('Error fetching template:', error);
            }
        }

        function renderBlockFields(layout) {
            dynamicBlocksContainer.innerHTML = '';

            // Render Header Sections
            if (layout.header && layout.header.sections) {
                appendSectionLabel('Header');
                layout.header.sections.forEach((section, index) => {
                    appendBlockField(`header.sections.${index}`, section.type);
                });
            }

            // Render Main Rows/Cols
            if (layout.main && layout.main.rows) {
                appendSectionLabel('Inhoud');
                layout.main.rows.forEach((row, rowIndex) => {
                    row.columns.forEach((col, colIndex) => {
                        appendBlockField(`main.rows.${rowIndex}.columns.${colIndex}`, col.type);
                    });
                });
            }

            // Render Footer Sections
            if (layout.footer && layout.footer.sections) {
                appendSectionLabel('Footer');
                layout.footer.sections.forEach((section, index) => {
                    appendBlockField(`footer.sections.${index}`, section.type);
                });
            }
        }

        function appendSectionLabel(text) {
            const label = document.createElement('div');
            label.className = 'section-label';
            label.textContent = text;
            dynamicBlocksContainer.appendChild(label);
        }

        function appendBlockField(path, type) {
            const def = blockDefinitions[type] || { name: type, icon: '📦', fields: [{ name: 'value', type: 'text', label: 'Waarde' }] };
            const blockDiv = document.createElement('div');
            blockDiv.className = 'block-item';

            let fieldsHtml = `<div class="block-header"><span class="block-icon">${def.icon}</span> ${def.name}</div>`;

            def.fields.forEach(field => {
                const value = getDeepValue(pageData, `${path}.${field.name}`) || '';

                if (field.type === 'image') {
                    fieldsHtml += `
                        <div class="form-group" style="margin-bottom: 10px;">
                            <label style="font-size: 0.8rem;">${field.label}</label>
                            <div class="dropzone" id="dropzone_${path.replace(/\./g, '_')}_${field.name}" onclick="document.getElementById('file_${path.replace(/\./g, '_')}_${field.name}').click()">
                                <div class="dropzone-icon">☁️</div>
                                <div class="dropzone-text">Sleep afbeelding hiernaartoe of klik om te uploaden</div>
                                ${value ? `<img src="${value}" alt="Preview">` : ''}
                                <div class="upload-progress" id="progress_${path.replace(/\./g, '_')}_${field.name}"></div>
                                <input type="file" id="file_${path.replace(/\./g, '_')}_${field.name}" accept="image/*" onchange="handleFileUpload(this, '${path}.${field.name}')">
                            </div>
                            <input type="text" class="form-control" style="margin-top: 10px; font-size: 0.8rem;" value="${value}" oninput="updateData('${path}.${field.name}', this.value)" placeholder="Of voer een URL in...">
                        </div>
                    `;
                } else {
                    fieldsHtml += `
                        <div class="form-group" style="margin-bottom: 10px;">
                            <label style="font-size: 0.8rem;">${field.label}</label>
                            ${field.type === 'textarea'
                            ? `<textarea class="form-control" style="min-height: 80px;" oninput="updateData('${path}.${field.name}', this.value)">${value}</textarea>`
                            : `<input type="text" class="form-control" value="${value}" oninput="updateData('${path}.${field.name}', this.value)">`
                        }
                        </div>
                    `;
                }
            });

            blockDiv.innerHTML = fieldsHtml;
            dynamicBlocksContainer.appendChild(blockDiv);

            // Setup drag and drop for any dropzones in this block
            blockDiv.querySelectorAll('.dropzone').forEach(dz => {
                dz.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    dz.classList.add('dragover');
                });
                dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
                dz.addEventListener('drop', (e) => {
                    e.preventDefault();
                    dz.classList.remove('dragover');
                    const file = e.dataTransfer.files[0];
                    if (file && file.type.startsWith('image/')) {
                        // Extract path from ID
                        const pathId = dz.id.replace('dropzone_', '');
                        // Map back to dotted path
                        // This is a bit tricky, let's use a data attribute instead next time
                        // For now we assume the ID structure is consistent
                        const dottedPath = dz.querySelector('input[type="file"]').onchange.toString().match(/'([^']+)'/)[1];
                        performUpload(file, dottedPath, dz);
                    }
                });
            });
        }

        function handleFileUpload(input, path) {
            const file = input.files[0];
            const dz = input.closest('.dropzone');
            if (file) {
                performUpload(file, path, dz);
            }
        }

        function performUpload(file, path, dz) {
            const formData = new FormData();
            formData.append('file', file);

            const progress = dz.querySelector('.upload-progress');
            progress.style.width = '0%';

            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/backoffice/media/upload', true);

            xhr.upload.onprogress = (e) => {
                if (e.lengthComputable) {
                    const percent = (e.loaded / e.total) * 100;
                    progress.style.width = percent + '%';
                }
            };

            xhr.onload = () => {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        updateData(path, response.url);
                        // Update preview image in dropzone
                        let img = dz.querySelector('img');
                        if (!img) {
                            img = document.createElement('img');
                            dz.appendChild(img);
                        }
                        img.src = response.url;
                        dz.querySelector('.dropzone-text').textContent = 'Upload voltooid!';
                        setTimeout(() => progress.style.width = '0%', 1000);
                    } else {
                        alert('Fout bij uploaden: ' + response.message);
                    }
                } else {
                    alert('Server fout bij uploaden.');
                }
            };

            xhr.send(formData);
        }

        function updateData(path, value) {
            setDeepValue(pageData, path, value);
            updatePreview();
        }

        function updatePreview() {
            if (!currentTemplate) return;

            const layout = JSON.parse(currentTemplate.layout_json);

            // Build premium preview HTML
            let html = `
                <html>
                <head>
                    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Outfit:wght@700&display=swap" rel="stylesheet">
                    <style>
                        body { font-family: 'Inter', sans-serif; margin: 0; color: #1a1336; background: #fff; overflow-x: hidden; }
                        header { padding: 0 40px; height: 80px; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fff; }
                        footer { padding: 60px 40px; border-top: 1px solid #f1f5f9; background: #1a1336; color: white; margin-top: 60px; }
                        .container { max-width: 1000px; margin: 0 auto; padding: 40px 20px; }
                        .row { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 40px; margin-bottom: 60px; align-items: center; }
                        .block { padding: 10px; border-radius: 12px; }
                        h1 { font-family: 'Outfit', sans-serif; font-size: 2.5rem; margin-bottom: 20px; color: #E8186A; }
                        p { font-size: 1.1rem; line-height: 1.6; color: #64748b; }
                        .cta-button { display: inline-block; padding: 14px 30px; background: linear-gradient(135deg, #E8186A 0%, #F0961B 100%); color: white; border-radius: 50px; text-decoration: none; font-weight: 700; margin-top: 20px; box-shadow: 0 10px 20px rgba(232, 24, 106, 0.2); }
                        img { max-width: 100%; border-radius: 20px; box-shadow: 0 15px 35px rgba(0,0,0,0.05); }
                        .usp-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
                        .usp-card { padding: 20px; background: #f8fafc; border-radius: 16px; font-weight: 600; text-align: center; }
                        .logo { max-height: 40px; }
                        .nav-placeholder { color: #64748b; font-weight: 500; display: flex; gap: 20px; }
                    </style>
                </head>
                <body>
                    <header>
                        ${renderLayoutSection(layout.header, 'header')}
                    </header>
                    <div class="container">
                        ${renderLayoutSection(layout.main, 'main')}
                    </div>
                    <footer>
                        ${renderLayoutSection(layout.footer, 'footer')}
                    </footer>
                </body>
                </html>
            `;

            const doc = previewFrame.contentDocument || previewFrame.contentWindow.document;
            doc.open();
            doc.write(html);
            doc.close();
        }

        function renderLayoutSection(section, type) {
            if (!section) return '';
            let html = '';

            if (type === 'header' || type === 'footer') {
                html += '<div style="display:flex; gap:30px; align-items:center; width:100%;">';
                section.sections.forEach((s, i) => {
                    html += `<div style="flex:1;">${renderBlock(s.type, `${type}.sections.${i}`)}</div>`;
                });
                html += '</div>';
            } else if (type === 'main') {
                section.rows.forEach((row, ri) => {
                    html += `<div class="row">`;
                    row.columns.forEach((col, ci) => {
                        html += `<div class="col">${renderBlock(col.type, `main.rows.${ri}.columns.${ci}`)}</div>`;
                    });
                    html += `</div>`;
                });
            }
            return html;
        }

        function renderBlock(type, path) {
            const data = getDeepValue(pageData, path) || {};
            switch (type) {
                case 'text': return `<div>${data.title ? `<h2>${data.title}</h2>` : ''}<p>${(data.text || 'Tekstblok...').replace(/\n/g, '<br>')}</p></div>`;
                case 'image': return data.url ? `<img src="${data.url}" alt="${data.alt || ''}">` : `<div style="background:#f1f5f9; height:200px; display:flex; align-items:center; justify-content:center; border-radius:20px; color:#cbd5e1;">Afbeelding</div>`;
                case 'cta': return `<div><h3>${data.title || 'Klaar om te starten?'}</h3><a href="#" class="cta-button">${data.button_text || 'Registeer nu'}</a></div>`;
                case 'logo': return data.url ? `<img src="${data.url}" class="logo">` : `<img src="/assets/logo/logo_fritsion_cms.png" class="logo">`;
                case 'menu': return `<div class="nav-placeholder">${(data.items || 'Home, Over ons, Producten, Contact').split(',').map(i => `<span>${i.trim()}</span>`).join('')}</div>`;
                case 'usps': return `<div class="usp-grid"><div class="usp-card">🚀 ${data.usp_1 || 'Snelle Levering'}</div><div class="usp-card">🛡️ ${data.usp_2 || 'Veilig Betalen'}</div><div class="usp-card">💎 ${data.usp_3 || 'Top Kwaliteit'}</div></div>`;
                case 'socials': return `<div style="display:flex; gap:15px; font-size:0.9rem;">${data.facebook ? 'FB ' : ''}${data.instagram ? 'IG ' : ''}</div>`;
                case 'video': return `<div style="background:#000; height:250px; border-radius:20px; display:flex; align-items:center; justify-content:center; color:white;">▶ Play Video</div>`;
                case 'html': return data.code || '<pre>&lt;Custom HTML&gt;</pre>';
                case 'map': return `<div style="background:#e0f2fe; height:200px; border-radius:20px; display:flex; align-items:center; justify-content:center; color:#0369a1;">📍 Kaart: ${data.address || 'Locatie'}</div>`;
                default: return `<div style="border:1px dashed #eee; padding:10px;">Blok: ${type}</div>`;
            }
        }

        // Helper functions
        function getDeepValue(obj, path) {
            return path.split('.').reduce((p, c) => p && p[c], obj);
        }

        function setDeepValue(obj, path, value) {
            const parts = path.split('.');
            const last = parts.pop();
            const target = parts.reduce((p, c) => {
                if (!p[c]) p[c] = {};
                return p[c];
            }, obj);
            target[last] = value;
        }

        // Form Submission
        document.getElementById('pageForm').addEventListener('submit', (e) => {
            contentJsonInput.value = JSON.stringify(pageData);
        });

        // Slug generation
        titleInput.addEventListener('input', () => {
            if ("<?= $mode ?>" === 'add' && !slugInput.readOnly) {
                const slug = titleInput.value
                    .toLowerCase()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_]+/g, '-')
                    .replace(/^-+|-+$/g, '');
                slugInput.value = slug;
            }
            updatePreview();
        });

        // Initialize state
        document.addEventListener('DOMContentLoaded', () => {
            const initialTplId = document.getElementById('template_id').value;
            if (initialTplId) {
                handleTemplateChange(initialTplId);
            }
        });

        // UI Handlers
        const userWidget = document.getElementById('user-widget');
        const userMenu = document.getElementById('user-menu');
        const langSwitcher = document.getElementById('lang-switcher');

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

        function handleFlagClick(event, lang) {
            const currentLang = '<?= $_SESSION['lang'] ?? 'nl' ?>';
            if (currentLang === lang) {
                event.preventDefault();
                langSwitcher.classList.toggle('expanded');
                return;
            }
        }
    </script>
</body>

</html>