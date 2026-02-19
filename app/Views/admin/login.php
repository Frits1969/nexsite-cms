<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen | Fritsion CMS</title>
    <!-- Google Fonts: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #0f172a;
            --secondary-bg: #1e293b;
            --accent-color: #0183D6;
            --accent-gradient: linear-gradient(135deg, #0183D6 0%, #0B9C70 100%);
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --glass-bg: rgba(30, 41, 59, 0.7);
            --glass-border: rgba(255, 255, 255, 0.1);
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
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            position: relative;
        }

        /* Animated Background Blobs */
        .blob {
            position: absolute;
            width: 500px;
            height: 500px;
            background: linear-gradient(135deg, #0183D6 0%, #0B9C70 50%, #F0961B 100%);
            filter: blur(80px);
            border-radius: 50%;
            z-index: -1;
            opacity: 0.15;
            animation: move 20s infinite alternate;
        }

        .blob-1 { top: -10%; left: -10%; }
        .blob-2 { bottom: -10%; right: -10%; animation-delay: -5s; }

        @keyframes move {
            from { transform: translate(0, 0); }
            to { transform: translate(100px, 100px); }
        }

        .login-card {
            background: var(--glass-bg);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid var(--glass-border);
            padding: 40px;
            border-radius: 24px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
            text-align: center;
        }

        .logo-container {
            margin-bottom: 30px;
        }

        .logo-container img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        .login-card h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .login-card p {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 500;
            color: var(--text-muted);
            margin-bottom: 8px;
            margin-left: 4px;
        }

        .form-input {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: var(--text-main);
            font-size: 1rem;
            outline: none;
            transition: all 0.3s;
        }

        .form-input:focus {
            border-color: var(--accent-color);
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 0 0 4px rgba(1, 131, 214, 0.1);
        }

        .login-btn {
            width: 100%;
            padding: 14px;
            background: var(--accent-gradient);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            box-shadow: 0 10px 15px -3px rgba(1, 131, 214, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 25px -5px rgba(1, 131, 214, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .footer-links {
            margin-top: 25px;
            font-size: 0.85rem;
        }

        .footer-links a {
            color: var(--accent-color);
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .footer-links a:hover {
            text-decoration: underline;
        }

        ::placeholder {
            color: #475569;
        }
    </style>
</head>

<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <div class="login-card">
        <div class="logo-container">
            <img src="/assets/logo/fritsion-logo.png" alt="Fritsion Logo">
        </div>
        <h2>Welkom Terug</h2>
        <p>Log in om je Fritsion CMS te beheren</p>

        <form method="POST" action="/backoffice/login">
            <div class="form-group">
                <label for="username">Gebruikersnaam of Email</label>
                <input type="text" name="username" id="username" class="form-input" placeholder="admin" required>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord</label>
                <input type="password" name="password" id="password" class="form-input" placeholder="••••••••" required>
            </div>

            <button type="submit" class="login-btn">Inloggen</button>
        </form>

        <div class="footer-links">
            <a href="/">Terug naar de website</a>
        </div>
    </div>
</body>

</html>