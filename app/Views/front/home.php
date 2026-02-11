<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($settings['site_name'] ?? 'NexSite CMS') ?>
    </title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        header {
            background: #333;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }

        footer {
            margin-top: 2rem;
            border-top: 1px solid #ccc;
            padding-top: 1rem;
            text-align: center;
            font-size: 0.8rem;
        }
    </style>
</head>

<body>
    <header>
        <h1>
            <?= htmlspecialchars($settings['site_name'] ?? 'NexSite CMS') ?>
        </h1>
        <p>
            <?= htmlspecialchars($settings['site_description'] ?? '') ?>
        </p>
    </header>

    <main>
        <p>Welkom op je nieuwe website! Dit is de standaard startpagina.</p>
        <p>Je kunt inloggen op de backoffice via <a href="/admin">/admin</a>.</p>
    </main>

    <footer>
        &copy;
        <?= date('Y') ?>
        <?= htmlspecialchars($settings['site_name'] ?? 'NexSite CMS') ?>. Powered by NexSite CMS.
    </footer>
</body>

</html>