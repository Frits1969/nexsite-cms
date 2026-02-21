<section class="hero-services">
    <div class="hero-top">
        <div class="container">
            <h1>Onze Diensten</h1>
            <p>
                <?= $settings['site_description'] ?>
            </p>
        </div>
    </div>
    <div class="services-content">
        <div class="container">
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">🌐</div>
                    <h3>Web Design</h3>
                    <p>Prachtige en functionele websites.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📱</div>
                    <h3>App Development</h3>
                    <p>Mobiele oplossingen voor elke sector.</p>
                </div>
                <div class="service-card">
                    <div class="service-icon">📈</div>
                    <h3>SEO Optimalisatie</h3>
                    <p>Wordt gevonden door uw doelgroep.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-services {
        background: #f8fafc;
    }

    .hero-top {
        background: var(--text-main);
        color: white;
        padding: 100px 0 150px;
        text-align: center;
    }

    .hero-top h1 {
        font-size: 3rem;
        margin-bottom: 20px;
    }

    .services-content {
        margin-top: -80px;
        padding-bottom: 100px;
    }

    .services-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 30px;
    }

    .service-card {
        background: white;
        padding: 40px;
        border-radius: 24px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
        text-align: center;
        transition: transform 0.3s;
    }

    .service-card:hover {
        transform: translateY(-10px);
    }

    .service-icon {
        font-size: 3rem;
        margin-bottom: 20px;
    }
</style>