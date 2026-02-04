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
        .lang-select a {
            margin: 0 10px;
            font-size: 18px;
            text-decoration: none;
            color: #0077cc;
        }
    </style>
</head>
<body>

    <img src="/assets/logo/nexsite-logo.png" alt="NexSite Logo">

    <div class="text"><?= $lang['welcome']; ?></div>

    <div class="lang-select">
        <a href="?lang=nl">NL</a>
        <a href="?lang=en">EN</a>
    </div>

</body>
</html>
