<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <title>NexSite CMS</title>
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .logo-container,
        .text-container {
            transition: opacity 0.3s ease;
        }

        img.logo {
            max-width: 280px;
            margin-bottom: 20px;
        }

        .text {
            font-size: 20px;
            color: #333;
            margin-bottom: 20px;
        }

        .lang-select {
            display: flex;
            gap: 20px;
            transition: all 0.5s ease;
        }

        .lang-select a {
            text-decoration: none;
            display: block;
            transition: transform 0.2s ease, opacity 0.3s ease;
        }

        .lang-select a:hover {
            transform: scale(1.1);
        }

        .flag-icon {
            width: 50px;
            height: 35px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: block;
        }

        .version-footer {
            position: fixed;
            bottom: 10px;
            right: 15px;
            font-size: 12px;
            color: #ccc;
            font-family: monospace;
        }

        /* Selected State Styling */
        body.selected-mode {
            justify-content: flex-start;
            padding-top: 20px;
        }

        body.selected-mode .text-container {
            display: none;
            opacity: 0;
            pointer-events: none;
        }

        body.selected-mode .lang-select {
            position: absolute;
            top: 20px;
            right: 20px;
            flex-direction: column;
            /* Stack flags vertically when expanded or simple layout */
            gap: 10px;
        }

        body.selected-mode .lang-select a {
            display: none;
        }

        /* Always show active flag */
        body.selected-mode .lang-select a.active {
            display: block;
            opacity: 1;
            order: -1;
            /* Ensure active flag is top */
        }

        /* Show all flags when expanded */
        body.selected-mode .lang-select.expanded a {
            display: block;
            opacity: 0.8;
        }

        body.selected-mode .lang-select.expanded a:hover {
            opacity: 1;
        }
    </style>
</head>
<?php
$selectedLang = $_GET['lang'] ?? null;
$bodyClass = $selectedLang ? 'selected-mode' : '';
?>

<body class="<?= $bodyClass ?>">

    <div class="logo-container">
        <img src="/assets/logo/nexsite-logo.png" alt="NexSite Logo" class="logo">
    </div>

    <div class="text-container">
        <div class="text"><?= $lang['welcome']; ?></div>
    </div>

    <div class="lang-select">
        <a href="?lang=nl" class="<?= $selectedLang === 'nl' ? 'active' : '' ?>" onclick="handleFlagClick(event, 'nl')">
            <img src="/assets/flags/nl.svg" alt="Nederlands" class="flag-icon">
        </a>
        <a href="?lang=en" class="<?= $selectedLang === 'en' ? 'active' : '' ?>" onclick="handleFlagClick(event, 'en')">
            <img src="/assets/flags/en.svg" alt="English" class="flag-icon">
        </a>
    </div>

    <div class="version-footer">
        v<?= \NexSite\App::VERSION ?>
    </div>

    <script>
        function handleFlagClick(event, lang) {
            const currentParams = new URLSearchParams(window.location.search);
            const currentLang = currentParams.get('lang');

            // If user clicks the currently active flag
            if (currentLang === lang) {
                event.preventDefault(); // Prevent reload
                // Toggle the expanded class to show/hide other flags
                document.querySelector('.lang-select').classList.toggle('expanded');
            }
            // If user clicks another flag, let the href work naturally (reloads page with new lang)
        }
    </script>
</body>

</html>