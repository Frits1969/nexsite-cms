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

        /* Setup Form Styles */
        .setup-container {
            display: none;
            opacity: 0;
            width: 100%;
            max-width: 500px;
            text-align: left;
            margin: 50px auto 50px auto;
            position: relative;
            background-color: #F0951B;
            /* Puzzle Orange */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            color: #fff;
            animation: fadeIn 0.5s ease forwards;
            animation-delay: 0.3s;
        }

        /* Puzzle "Outies" (Knobs) */
        .setup-container::before {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            background-color: #F0951B;
            border-radius: 50%;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            box-shadow: 0 -1px 0 #F0951B;
        }

        .setup-container::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            background-color: #F0951B;
            border-radius: 50%;
            left: -30px;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: -1px 0 0 #F0951B;
        }

        /* "Innies" (Holes) */
        .puzzle-hole-right {
            position: absolute;
            width: 60px;
            height: 60px;
            background-color: #ffffff;
            border-radius: 50%;
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1;
        }

        .puzzle-hole-bottom {
            position: absolute;
            width: 60px;
            height: 60px;
            background-color: #ffffff;
            border-radius: 50%;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
        }

        body.selected-mode .setup-container {
            display: block;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
            }
        }

        .form-group {
            margin-bottom: 25px;
            position: relative;
            z-index: 2;
        }

        .form-group label {
            font-weight: bold;
            display: block;
            margin-bottom: 8px;
            color: #fff;
            font-size: 16px;
            text-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .tip {
            font-size: 14px;
            color: #333;
            margin-bottom: 12px;
            line-height: 1.4;
            background: rgba(255, 255, 255, 0.95);
            padding: 10px;
            border-left: 4px solid #333;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .form-input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        .form-input:focus {
            border-color: #007bff;
            outline: none;
        }

        textarea.form-input {
            resize: vertical;
            min-height: 80px;
        }

        .input-group {
            margin-bottom: 10px;
        }

        .submit-btn {
            background-color: #333;
            color: white;
            padding: 14px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            font-size: 18px;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            margin-top: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .submit-btn:hover {
            background-color: #000;
            transform: translateY(-2px);
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

    <div class="setup-container">
        <!-- Visual "Holes" for the puzzle piece -->
        <div class="puzzle-hole-right"></div>
        <div class="puzzle-hole-bottom"></div>

        <form action="/install" method="POST">
            <!-- Question 1 -->
            <div class="form-group">
                <label><?= $lang['site_name_label'] ?></label>
                <div class="tip"><?= $lang['site_name_tip'] ?></div>
                <input type="text" name="site_name" class="form-input" required>
            </div>

            <!-- Question 2 -->
            <div class="form-group">
                <label><?= $lang['site_desc_label'] ?></label>
                <div class="tip"><?= $lang['site_desc_tip'] ?></div>
                <textarea name="site_desc" class="form-input" required></textarea>
            </div>

            <!-- Question 3 -->
            <div class="form-group">
                <label><?= $lang['admin_account_label'] ?></label>
                <div class="tip"><?= $lang['admin_account_tip'] ?></div>

                <div class="input-group">
                    <input type="text" name="username" placeholder="<?= $lang['username_label'] ?>" class="form-input"
                        required>
                </div>
                <div class="input-group">
                    <input type="email" name="email" placeholder="<?= $lang['email_label'] ?>" class="form-input"
                        required>
                </div>
                <div class="input-group">
                    <input type="password" name="password" placeholder="<?= $lang['password_label'] ?>"
                        class="form-input" required>
                </div>
                <div class="input-group">
                    <input type="password" name="password_repeat" placeholder="<?= $lang['password_repeat_label'] ?>"
                        class="form-input" required>
                </div>
            </div>

            <button type="submit" class="submit-btn"><?= $lang['start_install'] ?></button>
        </form>
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