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
            <svg class="flag-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 900 600">
                <rect fill="#AE1C28" width="900" height="200" />
                <rect fill="#fff" y="200" width="900" height="200" />
                <rect fill="#21468B" y="400" width="900" height="200" />
            </svg>
        </a>
        <a href="?lang=en" title="English">
            <svg class="flag-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 30">
                <clipPath id="t">
                    <path d="M30,15 h30 v15 z v15 h-30 z h-30 v-15 z v-15 h30 z" />
                </clipPath>
                <path d="M0,0 v30 h60 v-30 z" fill="#012169" />
                <path d="M0,0 L60,30 M60,0 L0,30" stroke="#fff" stroke-width="6" />
                <path d="M0,0 L60,30 M60,0 L0,30" clip-path="url(#t)" stroke="#C8102E" stroke-width="4" />
                <path d="M30,0 v30 M0,15 h60" stroke="#fff" stroke-width="10" />
                <path d="M30,0 v30 M0,15 h60" stroke="#C8102E" stroke-width="6" />
            </svg>
        </a>
    </div>

</body>

</html>