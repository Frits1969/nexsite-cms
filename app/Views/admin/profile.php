<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profiel | NexSite CMS</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #0f172a;
            --secondary-bg: #1e293b;
            --accent-color: #0183D6;
            --accent-green: #0B9C70;
            --accent-orange: #F0961B;
            --accent-gradient: linear-gradient(135deg, #0183D6 0%, #0B9C70 50%, #F0961B 100%);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
            --sidebar-width: 260px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
            overflow-x: hidden;
            display: flex;
        }

        /* Sidebar Styling (Simplified clone from dashboard) */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--secondary-bg);
            border-right: 1px solid var(--glass-border);
            position: fixed;
            left: 0;
            top: 0;
            display: flex;
            flex-direction: column;
            z-index: 100;
        }

        .sidebar-header {
            padding: 30px 20px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .sidebar-header img {
            max-width: 65px;
            height: auto;
        }

        .sidebar-header h2 {
            font-size: 1.25rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .sidebar-nav {
            flex: 1;
            padding: 20px 15px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 10px;
            margin-bottom: 8px;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-item:hover, .nav-item.active {
            background: rgba(1, 131, 214, 0.1);
            color: var(--accent-color);
        }

        .main-wrapper {
            flex: 1;
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            height: 70px;
            padding: 0 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--glass-bg);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .content {
            padding: 40px;
            max-width: 800px;
            margin: 0 auto;
            width: 100%;
        }

        .profile-card {
            background: var(--secondary-bg);
            border-radius: 20px;
            border: 1px solid var(--glass-border);
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 1px solid var(--glass-border);
        }

        .profile-avatar {
            width: 100px;
            height: 100px;
            background: var(--accent-gradient);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(1, 131, 214, 0.2);
        }

        .profile-title h1 {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .profile-title p {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            color: var(--text-muted);
        }

        .form-group input {
            width: 100%;
            padding: 14px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-main);
            font-size: 1rem;
            transition: all 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--accent-color);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(1, 131, 214, 0.1);
        }

        .alert {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #10b981;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .btn-save {
            width: 100%;
            padding: 16px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 20px;
        }

        .btn-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(1, 131, 214, 0.3);
        }

        .section-divider {
            margin: 40px 0 30px;
            padding-top: 30px;
            border-top: 1px solid var(--glass-border);
        }

        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="/assets/logo/nexsite-logo.png" alt="Logo">
            <h2>NexSite</h2>
        </div>
        <nav class="sidebar-nav">
            <a href="/backoffice" class="nav-item">
                <span>Dashboard</span>
            </a>
            <a href="/backoffice/pages" class="nav-item">
                <span>Pagina's</span>
            </a>
            <a href="/backoffice/media" class="nav-item">
                <span>Media</span>
            </a>
            <a href="/backoffice/settings" class="nav-item">
                <span>Instellingen</span>
            </a>
            <a href="/" target="_blank" class="nav-item">
                <span>Bezoek Website</span>
            </a>
        </nav>
    </aside>

    <div class="main-wrapper">
        <header class="topbar">
            <div style="font-weight: 600; color: var(--text-muted);">Backoffice / Profiel</div>
            <div style="display: flex; gap: 20px;">
                 <a href="/backoffice" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem;">Terug naar Dashboard</a>
            </div>
        </header>

        <main class="content">
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar">
                        <?= strtoupper(substr($user['username'], 0, 1)) ?>
                    </div>
                    <div class="profile-title">
                        <h1>Mijn Profiel</h1>
                        <p>Beheer hier je persoonlijke gegevens en beveiligingsinstellingen.</p>
                    </div>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-error">
                        <span>⚠️</span> <?= $error ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success">
                        <span>✅</span> <?= $success ?>
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="form-group">
                        <label for="username">Gebruikersnaam</label>
                        <input type="text" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mailadres</label>
                        <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                    </div>

                    <div class="section-divider">
                        <h3 class="section-title"><span>🔒</span> Wachtwoord Wijzigen</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">Laat leeg als je het wachtwoord niet wilt wijzigen.</p>
                    </div>

                    <div class="form-group">
                        <label for="new_password">Nieuw Wachtwoord</label>
                        <input type="password" id="new_password" name="new_password" autocomplete="new-password">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Bevestig Nieuw Wachtwoord</label>
                        <input type="password" id="confirm_password" name="confirm_password" autocomplete="new-password">
                    </div>

                    <div class="section-divider">
                        <h3 class="section-title"><span>🛡️</span> Bevestig Wijzigingen</h3>
                        <p style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px;">Voer je **huidige wachtwoord** in om de wijzigingen op te slaan.</p>
                    </div>

                    <div class="form-group">
                        <label for="current_password">Huidig Wachtwoord</label>
                        <input type="password" id="current_password" name="current_password" required autocomplete="current-password">
                    </div>

                    <button type="submit" class="btn-save">Wijzigingen Opslaan</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
