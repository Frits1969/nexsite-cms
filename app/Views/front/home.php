<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($settings['site_name'] ?? 'Fritsion Website') ?></title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Outfit:wght@700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary-color: #3B2A8C;
            --accent-pink: #E8186A;
            --accent-orange: #F0961B;
            --text-color: #333;
            --bg-color: #f8f9fa;
        }

        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        header {
            padding: 2rem;
            display: flex;
            align-items: flex-start;
        }

        .logo {
            max-height: 60px;
            width: auto;
        }

        main {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 2rem;
        }

        .intro-text {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 0.5rem;
        }

        .site-name {
            font-family: 'Outfit', sans-serif;
            font-size: 4rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 0;
            background: linear-gradient(135deg, #E8186A 0%, #C41257 40%, #F0961B 100%);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body>

    <header>
        <?php if (file_exists(__DIR__ . '/../../../public/assets/logo/logo_fritsion_cms.png')): ?>
            <img src="/assets/logo/logo_fritsion_cms.png" alt="Fritsion Logo" class="logo">
        <?php else: ?>
            <!-- Fallback if logo is missing, though we confirmed it exists -->
            <strong>Fritsion</strong>
        <?php endif; ?>
    </header>

    <main>
        <div class="intro-text">Hier komt de website:</div>
        <h1 class="site-name"><?= htmlspecialchars($settings['site_name'] ?? 'Mijn Website') ?></h1>

        <br><br>
        <a href="/reset_install.php"
            style="background-color: #ff6b6b; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Reset
            Installatie</a>
    </main>


</body>

</html>