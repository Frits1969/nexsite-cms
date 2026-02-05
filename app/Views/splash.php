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

        /* Multi-step Logic Styles */
        .multistep-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 0;
            width: 100%;
            margin-top: 50px;
        }

        /* Puzzle Piece */
        .puzzle-piece {
            position: relative;
            padding: 40px;
            color: #fff;
            border-radius: 15px;
            width: 450px;
            flex-shrink: 0;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.5s ease;
        }

        /* Orange Piece (Step 1) */
        .puzzle-piece.orange {
            background-color: #F0961B;
            z-index: 2;
        }

        /* Green Piece (Step 2) */
        .puzzle-piece.green {
            background-color: #0B9C70;
            display: none;
            opacity: 0;
            z-index: 1;
        }

        /* Blue Piece (Step 3) */
        .puzzle-piece.blue {
            background-color: #0183D6;
            /* User requested #0183D6 */
            display: none;
            opacity: 0;
            z-index: 0;
        }

        /* Puzzle "Outies" (Knobs) */
        /* Orange Piece: Connection on Right */
        .puzzle-piece.orange::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            background-color: #F0961B;
            border-radius: 50%;
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: 1px 0 0 #F0961B;
            z-index: 2;
        }

        /* Green Piece: Left Hole */
        /* To create a "hole" feeling, we overlap with the Orange knob. */
        /* Since Orange is z-index 2 and Green is z-index 1, the Orange knob sits ON TOP of Green. */
        /* This visually looks like Orange fitting into Green. */
        /* We just need to ensure Green has NO other pseudos for Top/Bottom as requested. */

        /* Green Piece: Right Connection (Knob) */
        .puzzle-piece.green::after {
            content: '';
            position: absolute;
            width: 60px;
            height: 60px;
            background-color: #0B9C70;
            border-radius: 50%;
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
            box-shadow: 1px 0 0 #0B9C70;
            z-index: 2;
        }

        /* Ensure no other pseudos interfere (Left is handled by overlap) */
        .puzzle-piece.green::before {
            content: none;
        }

        /* Blue Piece: Left Hole handled by Overlap */
        /* No Right Connection as it's the last step for now, or maybe not? */
        /* User said: "In dit blauwe puzzelstukje ... knop voor installeren" */
        /* So it's probably the end. */
        .puzzle-piece.blue::before,
        .puzzle-piece.blue::after {
            content: none;
        }

        /* Animation States */
        body.step-2-mode .puzzle-piece.orange {
            width: 300px;
            opacity: 1;
            pointer-events: none;
        }

        body.step-2-mode .puzzle-piece.green {
            display: block;
            opacity: 1;
            animation: slideInRight 0.5s ease forwards;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(20px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .form-group.summary-item {
            margin-bottom: 30px;
        }

        .summary-label {
            font-size: 14px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: bold;
            word-break: break-word;
        }

        /* Setup Container Reset - Remove legacy styles that interfere with puzzle pieces */
        .setup-container {
            display: none;
            width: auto;
            max-width: none;
            background: transparent;
            box-shadow: none;
            padding: 0;
            margin: 0;
        }

        .setup-container::before,
        .setup-container::after {
            content: none;
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
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
        }

        .tip {
            font-size: 14px;
            color: #333;
            margin-bottom: 12px;
            line-height: 1.4;
            padding: 10px;
            border-left: 4px solid #333;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        /* Specific Tip Colors */
        .puzzle-piece.orange .tip {
            background-color: #fdebd1;
            border-left-color: #a86205;
        }

        .puzzle-piece.green .tip {
            background-color: #e6f5f1;
            border-left-color: #065c42;
        }

        .puzzle-piece.blue .tip {
            background-color: #E0F2FF;
            /* Light var of 0183D6 */
            border-left-color: #004F82;
            /* Darker var */
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

        .nav-buttons {
            display: flex;
            align-items: center;
            margin-top: 20px;
            position: relative;
            z-index: 10;
            /* Ensure buttons are above other elements */
        }

        .nav-buttons.single {
            justify-content: flex-end;
        }

        .nav-buttons.dual {
            justify-content: space-between;
        }

        .arrow-btn {
            background-color: #333;
            color: white;
            min-width: 120px;
            /* Pill shape */
            padding: 10px 20px;
            height: 50px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .arrow-btn:hover {
            background-color: #000;
            transform: scale(1.05);
        }

        .arrow-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none !important;
        }

        /* Adjust summary width */
        body.step-2-mode .puzzle-piece.green,
        body.step-3-mode .puzzle-piece.green,
        body.step-3-mode .puzzle-piece.orange {
            width: 300px;
            opacity: 1;
            pointer-events: none;
        }

        body.step-3-mode .puzzle-piece.blue {
            display: block;
            opacity: 1;
            animation: slideInRight 0.5s ease forwards;
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
        <form action="/install" method="POST" id="install-form">
            <div class="multistep-wrapper">

                <!-- Step 1: Site Info (Orange) -->
                <div class="puzzle-piece orange" id="step-1-piece">
                    <!-- Step 1 Content: Inputs -->
                    <div id="step-1-content">
                        <div class="form-group">
                            <label><?= $lang['site_name_label'] ?></label>
                            <div class="tip"><?= $lang['site_name_tip'] ?></div>
                            <input type="text" name="site_name" id="site_name" class="form-input" required>
                        </div>
                        <div class="form-group">
                            <label><?= $lang['site_desc_label'] ?></label>
                            <div class="tip"><?= $lang['site_desc_tip'] ?></div>
                            <textarea name="site_desc" id="site_desc" class="form-input" required></textarea>
                        </div>
                        <div class="nav-buttons single">
                            <button type="button" class="arrow-btn right"
                                onclick="goToStep2()"><span><?= $lang['btn_next'] ?></span> &#8594;
                            </button>
                        </div>
                    </div>

                    <!-- Step 1 Summary (Hidden initially) -->
                    <div id="step-1-summary" style="display: none;">
                        <div class="form-group summary-item">
                            <div class="summary-label"><?= $lang['site_name_label'] ?></div>
                            <div class="summary-value" id="summary-site-name"></div>
                        </div>
                        <div class="form-group summary-item">
                            <div class="summary-label"><?= $lang['site_desc_label'] ?></div>
                            <div class="summary-value" id="summary-site-desc"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 2: Admin Info (Green) -->
                <div class="puzzle-piece green" id="step-2-piece">
                    <!-- Overlap Connection: Orange Knob sits on top -->

                    <div id="step-2-content">
                        <div class="form-group">
                            <label><?= $lang['admin_account_label'] ?></label>
                            <div class="tip"><?= $lang['admin_account_tip'] ?></div>

                            <div class="input-group">
                                <input type="text" name="username" placeholder="<?= $lang['username_label'] ?>"
                                    class="form-input" required>
                            </div>
                            <div class="input-group">
                                <input type="email" name="email" placeholder="<?= $lang['email_label'] ?>"
                                    class="form-input" required>
                            </div>
                            <div class="input-group">
                                <input type="password" name="password" placeholder="<?= $lang['password_label'] ?>"
                                    class="form-input" required>
                            </div>
                            <div class="input-group">
                                <input type="password" name="password_repeat"
                                    placeholder="<?= $lang['password_repeat_label'] ?>" class="form-input" required>
                            </div>
                        </div>
                        <div class="nav-buttons dual">
                            <button type="button" class="arrow-btn left" onclick="goToStep1()">
                                &#8592; <span><?= $lang['btn_back'] ?></span>
                            </button>
                            <button type="button" class="arrow-btn right" onclick="goToStep3()">
                                <span><?= $lang['btn_next'] ?></span> &#8594;
                            </button>
                        </div>
                    </div>

                    <!-- Step 2 Summary (Hidden initially) -->
                    <div id="step-2-summary" style="display: none;">
                        <div class="form-group summary-item">
                            <div class="summary-label"><?= $lang['username_label'] ?></div>
                            <div class="summary-value" id="summary-username"></div>
                        </div>
                        <div class="form-group summary-item">
                            <div class="summary-label"><?= $lang['email_label'] ?></div>
                            <div class="summary-value" id="summary-email"></div>
                        </div>
                    </div>
                </div>

                <!-- Step 3: Database Config (Blue) -->
                <div class="puzzle-piece blue" id="step-3-piece">
                    <!-- Overlap Connection: Green Knob sits on top -->

                    <!-- Domain -->
                    <div class="form-group">
                        <label><?= $lang['site_domain_label'] ?></label>
                        <div class="tip"><?= $lang['site_domain_tip'] ?></div>
                        <input type="text" name="domain" class="form-input" placeholder="example.com" required>
                    </div>

                    <!-- DB Name -->
                    <div class="form-group">
                        <label><?= $lang['db_name_label'] ?></label>
                        <div class="tip"><?= $lang['db_name_tip'] ?></div>
                        <input type="text" name="db_name" class="form-input" required>
                    </div>

                    <!-- DB User -->
                    <div class="form-group">
                        <label><?= $lang['db_user_label'] ?></label>
                        <div class="tip"><?= $lang['db_user_tip'] ?></div>
                        <input type="text" name="db_user" class="form-input" required>
                    </div>

                    <!-- DB Pass -->
                    <div class="form-group">
                        <label><?= $lang['db_pass_label'] ?></label>
                        <div class="tip"><?= $lang['db_pass_tip'] ?></div>
                        <input type="password" name="db_pass" class="form-input" required>
                    </div>

                    <!-- DB Host -->
                    <div class="form-group">
                        <label><?= $lang['db_host_label'] ?></label>
                        <div class="tip"><?= $lang['db_host_tip'] ?></div>
                        <input type="text" name="db_host" class="form-input" value="localhost" required>
                    </div>

                    <div id="db-test-result" style="margin-bottom: 10px; font-weight: bold;"></div>

                    <div class="nav-buttons dual">
                        <!-- Back Button -->
                        <button type="button" class="arrow-btn left" onclick="goToStep2()">
                            &#8592; <span><?= $lang['btn_back'] ?></span>
                        </button>

                        <!-- Test Button -->
                        <button type="button" id="test-db-btn" class="arrow-btn" style="background-color: #f0ad4e;"
                            onclick="testDatabaseConnection()">
                            <span><?= $lang['btn_test_db'] ?></span>
                        </button>

                        <!-- Install Button (Hidden initially) -->
                        <button type="submit" id="install-btn" class="arrow-btn right" style="display:none;">
                            <span><?= $lang['start_install'] ?></span> &#8594;
                        </button>
                    </div>
                </div>

            </div>
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
            event.preventDefault(); // Always prevent default to handle logic manually behavior

            const currentParams = new URLSearchParams(window.location.search);
            const currentLang = currentParams.get('lang');

            // If user clicks the currently active flag (toggle menu)
            if (currentLang === lang) {
                document.querySelector('.lang-select').classList.toggle('expanded');
                return;
            }

            // If switching language -> Save State (Only Data, Reset Step)
            const state = {
                site_name: document.getElementById('site_name').value,
                site_desc: document.getElementById('site_desc').value,
                username: document.querySelector('input[name="username"]').value,
                email: document.querySelector('input[name="email"]').value,
                password: document.querySelector('input[name="password"]').value,
                password_repeat: document.querySelector('input[name="password_repeat"]').value,
                // Step is NOT saved, always restart chain at 1 as requested

                // DB Fields
                domain: document.querySelector('input[name="domain"]')?.value || '',
                db_name: document.querySelector('input[name="db_name"]')?.value || '',
                db_user: document.querySelector('input[name="db_user"]')?.value || '',
                db_pass: document.querySelector('input[name="db_pass"]')?.value || '',
                db_host: document.querySelector('input[name="db_host"]')?.value || ''
            };
            sessionStorage.setItem('nexsite_setup_state', JSON.stringify(state));

            // Navigate
            window.location.href = '?lang=' + lang;
        }

        // Restore State on Load
        document.addEventListener('DOMContentLoaded', () => {
            // Check if we are on a fresh visit (no lang param) -> Clear storage
            const currentParams = new URLSearchParams(window.location.search);
            if (!currentParams.has('lang')) {
                sessionStorage.removeItem('nexsite_setup_state');
                return; // Nothing to restore
            }

            const savedState = sessionStorage.getItem('nexsite_setup_state');
            if (savedState) {
                const state = JSON.parse(savedState);

                // Restore inputs
                if (state.site_name) document.getElementById('site_name').value = state.site_name;
                if (state.site_desc) document.getElementById('site_desc').value = state.site_desc;
                if (state.username) document.querySelector('input[name="username"]').value = state.username;
                if (state.email) document.querySelector('input[name="email"]').value = state.email;
                if (state.password) document.querySelector('input[name="password"]').value = state.password;
                if (state.password_repeat) document.querySelector('input[name="password_repeat"]').value = state.password_repeat;

                // Restore DB inputs
                if (state.domain) document.querySelector('input[name="domain"]').value = state.domain;
                if (state.db_name) document.querySelector('input[name="db_name"]').value = state.db_name;
                if (state.db_user) document.querySelector('input[name="db_user"]').value = state.db_user;
                if (state.db_pass) document.querySelector('input[name="db_pass"]').value = state.db_pass;
                if (state.db_host) document.querySelector('input[name="db_host"]').value = state.db_host;

                // Step is NOT restored automatically, user starts at Orange (Step 1)
            }
        });

        function goToStep2(skipValidation = false) {
            // Get inputs
            const siteName = document.getElementById('site_name').value;
            const siteDesc = document.getElementById('site_desc').value;

            // Validation
            if (!skipValidation && (!siteName || !siteDesc)) {
                alert('Vul alle velden in aub.');
                return;
            }

            // Populate summary for Step 1
            document.getElementById('summary-site-name').innerText = siteName;
            document.getElementById('summary-site-desc').innerText = siteDesc;

            // Adjust UI
            document.body.classList.remove('step-3-mode');
            document.body.classList.add('step-2-mode');

            // Step 1: Show Summary
            document.getElementById('step-1-content').style.display = 'none';
            document.getElementById('step-1-summary').style.display = 'block';

            // Step 2: Show Inputs (hide summary if coming back from 3)
            document.getElementById('step-2-content').style.display = 'block';
            document.getElementById('step-2-summary').style.display = 'none';
            document.getElementById('step-2-piece').style.display = '';

            // Focus on username
            setTimeout(() => {
                const usernameInput = document.querySelector('input[name="username"]');
                if (usernameInput) usernameInput.focus();
            }, 500); // Wait for animation
        }

        function goToStep1() {
            document.body.classList.remove('step-2-mode');
            document.body.classList.remove('step-3-mode');

            document.getElementById('step-1-content').style.display = 'block';
            document.getElementById('step-1-summary').style.display = 'none';
        }

        function goToStep3(skipValidation = false) {
            const user = document.querySelector('input[name="username"]').value;
            const email = document.querySelector('input[name="email"]').value;
            const pass = document.querySelector('input[name="password"]').value;
            const repeat = document.querySelector('input[name="password_repeat"]').value;

            if (!skipValidation) {
                if (!user || !email || !pass || !repeat) {
                    alert('Vul alle velden in aub.');
                    return;
                }
                if (pass !== repeat) {
                    alert('Wachtwoorden komen niet overeen.');
                    return;
                }
            }

            // Populate Summary for Step 2
            document.getElementById('summary-username').innerText = user;
            document.getElementById('summary-email').innerText = email;

            document.body.classList.add('step-3-mode');

            // Step 2: Hide Inputs, Show Summary
            document.getElementById('step-2-content').style.display = 'none';
            document.getElementById('step-2-summary').style.display = 'block';
        }

        function testDatabaseConnection() {
            const host = document.querySelector('input[name="db_host"]').value;
            const user = document.querySelector('input[name="db_user"]').value;
            const pass = document.querySelector('input[name="db_pass"]').value;
            const name = document.querySelector('input[name="db_name"]').value;
            const resultDiv = document.getElementById('db-test-result');
            const installBtn = document.getElementById('install-btn');

            resultDiv.innerText = 'Testing...';
            resultDiv.style.color = 'blue';
            installBtn.style.display = 'none';

            const formData = new FormData();
            formData.append('action', 'test_db');
            formData.append('host', host);
            formData.append('user', user);
            formData.append('pass', pass);
            formData.append('name', name);

            fetch('', { // Post to self
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        resultDiv.innerText = '<?= $lang['success_db_connect'] ?>';
                        resultDiv.style.color = 'green';
                        installBtn.style.display = 'flex'; // Show install button
                    } else {
                        resultDiv.innerText = '<?= $lang['error_db_connect'] ?>: ' + data.message;
                        resultDiv.style.color = 'red';
                    }
                })
                .catch(error => {
                    resultDiv.innerText = 'Error: ' + error;
                    resultDiv.style.color = 'red';
                });
        }
    </script>
</body>

</html>