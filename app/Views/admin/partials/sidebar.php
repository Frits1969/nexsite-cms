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
<aside class="sidebar">
    <div class="sidebar-header">
        <img src="/assets/logo/logo_fritsion_cms.png" alt="Logo">
    </div>

    <nav class="sidebar-nav">
        <a href="/backoffice" class="nav-item <?= $uri === '/backoffice' ? 'active' : '' ?>">
            <span><?= $nav_dashboard ?></span>
        </a>
        <a href="/backoffice/pages" class="nav-item <?= strpos($uri, '/backoffice/pages') === 0 ? 'active' : '' ?>">
            <span><?= $nav_pages ?></span>
        </a>
        <a href="/backoffice/media" class="nav-item <?= $uri === '/backoffice/media' ? 'active' : '' ?>">
            <span><?= $nav_media ?></span>
        </a>
        
        <a href="/backoffice/templates" class="nav-item <?= strpos($uri, '/backoffice/templates') === 0 ? 'active' : '' ?>">
            <span><?= $nav_templates ?></span>
        </a>
        <?php if (strpos($uri, '/backoffice/templates') === 0): ?>
            <div class="submenu">
                <a href="/backoffice/templates/homepage" class="submenu-item <?= $uri === '/backoffice/templates/homepage' ? 'active' : '' ?>">
                   &nbsp; &nbsp; &bull; Alleen homepage
                </a>
            </div>
        <?php endif; ?>

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
        <p style="font-size: 0.8rem; color: var(--text-muted);">v<?= \Fritsion\App::VERSION ?></p>
    </div>
</aside>

<style>
    .submenu {
        margin-top: -5px;
        margin-bottom: 10px;
    }
    .submenu-item {
        display: block;
        padding: 10px 15px;
        color: #64748b;
        text-decoration: none;
        font-size: 0.85rem;
        border-radius: 8px;
        transition: all 0.2s;
        margin-left: 10px;
    }
    .submenu-item:hover, .submenu-item.active {
        color: var(--accent-pink);
        background: rgba(232, 24, 106, 0.03);
    }
    .submenu-item.active {
        font-weight: 700;
        background: rgba(232, 24, 106, 0.06);
    }
</style>
