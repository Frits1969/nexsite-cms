<!DOCTYPE html>
<html lang="nl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Demo Pagina | NexSite CMS</title>
    <!-- Google Fonts: Inter & Outfit -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --blue: #0183D6;
            --green: #0B9C70;
            --orange: #F0961B;
            --dark: #0f172a;
            --light: #f8fafc;
            --gradient: linear-gradient(135deg, #0183D6 0%, #0B9C70 50%, #F0961B 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--light);
            color: var(--dark);
            line-height: 1.6;
        }

        .header {
            background: white;
            padding: 20px 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: 'Outfit', sans-serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark);
            text-decoration: none;
        }

        .logo img {
            height: 40px;
        }

        .btn-back {
            padding: 10px 20px;
            background: var(--dark);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s;
        }

        .btn-back:hover {
            opacity: 0.9;
            transform: translateY(-2px);
        }

        .hero {
            padding: 100px 5% 150px;
            text-align: center;
            background: radial-gradient(circle at top right, rgba(1, 131, 214, 0.05), transparent),
                        radial-gradient(circle at bottom left, rgba(240, 150, 27, 0.05), transparent);
        }

        .hero h1 {
            font-family: 'Outfit', sans-serif;
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            line-height: 1.1;
            background: var(--gradient);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero p {
            font-size: 1.25rem;
            color: #64748b;
            max-width: 700px;
            margin: 0 auto 40px;
        }

        .features {
            padding: 100px 5%;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            background: white;
        }

        .feature-card {
            padding: 40px;
            border-radius: 24px;
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.03);
            border-color: var(--blue);
        }

        .feature-icon {
            font-size: 2.5rem;
            margin-bottom: 20px;
            display: inline-block;
        }

        .feature-card h3 {
            font-family: 'Outfit', sans-serif;
            font-size: 1.5rem;
            margin-bottom: 15px;
        }

        .feature-card p {
            color: #64748b;
        }

        .showcase {
            padding: 100px 5%;
            text-align: center;
            background: var(--dark);
            color: white;
        }

        .showcase h2 {
            font-family: 'Outfit', sans-serif;
            font-size: 2.5rem;
            margin-bottom: 50px;
        }

        .puzzle-demo {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 30px;
        }

        .puzzle-demo span {
            width: 40px;
            height: 40px;
            border-radius: 8px;
        }

        .footer {
            padding: 50px 5%;
            text-align: center;
            border-top: 1px solid #f1f5f9;
            color: #94a3b8;
            font-size: 0.9rem;
        }

        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
        }
    </style>
</head>

<body>
    <header class="header">
        <a href="/" class="logo">
            <img src="/assets/logo/nexsite-logo.png" alt="NexSite">
            <span>NexSite</span>
        </a>
        <a href="/backoffice" class="btn-back">Terug naar Backoffice</a>
    </header>

    <section class="hero">
        <h1>De Toekomst van CMS</h1>
        <p>Ervaar de kracht van NexSite. Een modulair systeem ontworpen voor snelheid, flexibiliteit en een ongekende gebruikerservaring.</p>
        <div class="puzzle-demo">
            <span style="background: var(--orange);"></span>
            <span style="background: var(--green);"></span>
            <span style="background: var(--blue);"></span>
        </div>
    </section>

    <section class="features">
        <div class="feature-card">
            <span class="feature-icon">🚀</span>
            <h3>Razendsnel</h3>
            <p>Geoptimaliseerd voor maximale prestaties en een bliksemsnelle laadtijd op elk apparaat.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🧩</span>
            <h3>Modulair</h3>
            <p>Bouw je website zoals jij dat wilt met onze slimme, koppelbare puzzelstukjes-logica.</p>
        </div>
        <div class="feature-card">
            <span class="feature-icon">🛡️</span>
            <h3>Veilig</h3>
            <p>Ontworpen met een 'security-first' mindset om je data en je gebruikers te beschermen.</p>
        </div>
    </section>

    <section class="showcase">
        <h2>Klaar om te bouwen?</h2>
        <p>Ga terug naar de backoffice en begin vandaag nog.</p>
    </section>

    <footer class="footer">
        &copy; <?= date('Y') ?> NexSite CMS v0.1.0 - Alle rechten voorbehouden.
    </footer>
</body>

</html>
