<section class="hero-usps">
    <div class="container">
        <div class="hero-content">
            <h1><?= $settings['site_name'] ?></h1>
            <p><?= $settings['site_description'] ?></p>
            <a href="#more" class="btn-primary">Ontdek meer</a>
        </div>
        <div class="usps-grid">
            <div class="usp-item">
                <span class="icon">🚀</span>
                <h3>Snelheid</h3>
                <p>Wij leveren alles razendsnel op.</p>
            </div>
            <div class="usp-item">
                <span class="icon">🛡️</span>
                <h3>Betrouwbaarheid</h3>
                <p>Altijd beschikbaar wanneer u ons nodig heeft.</p>
            </div>
            <div class="usp-item">
                <span class="icon">💎</span>
                <h3>Premium Kwaliteit</h3>
                <p>Alleen het beste is goed genoeg.</p>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-usps {
        padding: 100px 0;
        text-align: center;
        background: var(--accent-gradient);
        color: white;
    }

    .hero-content h1 {
        font-size: 3.5rem;
        margin-bottom: 20px;
    }

    .hero-content p {
        font-size: 1.25rem;
        margin-bottom: 40px;
        opacity: 0.9;
    }

    .usps-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
        margin-top: 80px;
    }

    .usp-item {
        background: rgba(255, 255, 255, 0.1);
        padding: 30px;
        border-radius: 20px;
        backdrop-filter: blur(10px);
    }

    .usp-item .icon {
        font-size: 2.5rem;
        margin-bottom: 15px;
        display: block;
    }

    .usp-item h3 {
        font-size: 1.25rem;
        margin-bottom: 10px;
    }
</style>