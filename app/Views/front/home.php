<?php
$layout = $homepageLayout;
?>
<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_name'] ?? 'Fritsion Website') ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&family=Outfit:wght@700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            --primary: #3B2A8C;
            --accent: #E8186A;
            --text: #1A1336;
            --muted: #64748b;
            --bg: #f8fafc;
            --accent-gradient: linear-gradient(135deg, #E8186A 0%, #C41257 40%, #F0961B 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text);
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Dynamic Header */
        header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            sticky;
            top: 0;
            z-index: 100;
        }

        .header-inner {
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 40px;
        }

        .h-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logo {
            height: 40px;
        }

        /* Main Content */
        main {
            padding: 60px 0;
        }

        .row {
            display: grid;
            gap: 40px;
            margin-bottom: 80px;
            align-items: center;
        }

        .col {
            min-height: 100px;
        }

        /* Styles for content types */
        .content-block {
            padding: 20px 0;
        }

        .type-text h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 3.5rem;
            line-height: 1.1;
            margin-bottom: 20px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .type-text p {
            font-size: 1.25rem;
            color: var(--muted);
        }

        .type-image img {
            width: 100%;
            border-radius: 24px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .type-cta {
            background: var(--accent-gradient);
            color: white;
            padding: 15px 35px;
            border-radius: 50px;
            text-decoration: none;
            display: inline-block;
            font-weight: 700;
        }

        .type-usp-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .usp-card {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.02);
        }

        /* Footer */
        footer {
            background: #1A1336;
            color: white;
            padding: 80px 0;
        }

        .footer-inner {
            display: grid;
            gap: 40px;
        }

        @media (max-width: 768px) {
            .row {
                grid-template-columns: 1fr !important;
            }

            .type-text h1 {
                font-size: 2.5rem;
            }
        }
    </style>
</head>

<body>

    <?php if ($layout): ?>
        <!-- Header -->
        <header>
            <div class="container header-inner">
                <?php foreach ($layout['header']['sections'] as $sec): ?>
                    <div class="h-section">
                        <?php if ($sec['type'] === 'logo'): ?>
                            <img src="/assets/logo/logo_fritsion_cms.png" alt="Logo" class="logo">
                        <?php elseif ($sec['type'] === 'menu'): ?>
                            <nav>Menu Placeholder</nav>
                        <?php elseif ($sec['type'] === 'cta'): ?>
                            <a href="#" class="type-cta" style="padding: 10px 20px; font-size: 0.9rem;">Start Nu</a>
                        <?php else: ?>
                            <span><?= ucfirst($sec['type']) ?></span>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </header>

        <!-- Main -->
        <main class="container">
            <?php foreach ($layout['main']['rows'] as $row): ?>
                <div class="row" style="grid-template-columns: repeat(<?= count($row['columns']) ?>, 1fr);">
                    <?php foreach ($row['columns'] as $col): ?>
                        <div class="col type-<?= $col['type'] ?>">
                            <?php if ($col['type'] === 'text'): ?>
                                <h1>Welkom bij <?= $settings['site_name'] ?></h1>
                                <p><?= $settings['site_description'] ?></p>
                            <?php elseif ($col['type'] === 'image'): ?>
                                <img src="https://via.placeholder.com/600x400?text=Beeld+Placeholder" alt="Image">
                            <?php elseif ($col['type'] === 'cta'): ?>
                                <a href="#" class="type-cta">Klik hier</a>
                            <?php elseif ($col['type'] === 'usps'): ?>
                                <div class="type-usp-grid">
                                    <div class="usp-card">🚀 Snelheid</div>
                                    <div class="usp-card">🛡️ Veiligheid</div>
                                    <div class="usp-card">💎 Kwaliteit</div>
                                </div>
                            <?php else: ?>
                                <div style="background: #eee; padding: 40px; border-radius: 12px; text-align: center;">
                                    <strong><?= strtoupper($col['type']) ?></strong> Block
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </main>

        <!-- Footer -->
        <footer>
            <div class="container footer-inner"
                style="grid-template-columns: repeat(<?= count($layout['footer']['sections']) ?>, 1fr);">
                <?php foreach ($layout['footer']['sections'] as $sec): ?>
                    <div>
                        <h3><?= ucfirst($sec['type']) ?></h3>
                        <p>Informatie over <?= $sec['type'] ?>.</p>
                    </div>
                <?php endforeach; ?>
            </div>
        </footer>
    <?php else: ?>
        <div class="container" style="padding: 100px; text-align: center;">
            <h1>Geen layout geconfigureerd.</h1>
            <p>Ga naar de backoffice om uw homepage in te richten.</p>
        </div>
    <?php endif; ?>

</body>

</html>