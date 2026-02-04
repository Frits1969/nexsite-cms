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
        }

        img {
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
        }

        .lang-select a {
            text-decoration: none;
            display: block;
            transition: transform 0.2s ease;
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
    </style>
</head>

<body>

    <img src="/assets/logo/nexsite-logo.png" alt="NexSite Logo">

    <div class="text"><?= $lang['welcome']; ?></div>

    <div class="lang-select">
        <a href="?lang=nl" title="Nederlands">
            <img src="/assets/flags/nl.svg" alt="Nederlands" class="flag-icon">
        </a>
        <a href="?lang=en" title="English">
            <img src="/assets/flags/en.svg" alt="English" class="flag-icon">
        </a>
    </div>

</body>

</html>