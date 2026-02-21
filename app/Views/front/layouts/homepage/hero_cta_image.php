<section class="hero-cta">
    <div class="container container-split">
        <div class="cta-text">
            <h1>
                <?= $settings['site_name'] ?>
            </h1>
            <p>
                <?= $settings['site_description'] ?>
            </p>
            <div class="cta-actions">
                <a href="#" class="btn-primary">Aan de slag</a>
                <a href="#" class="btn-outline">Lees meer</a>
            </div>
        </div>
        <div class="cta-image">
            <img src="/assets/img/hero-mockup.png" alt="Mockup"
                onerror="this.src='https://via.placeholder.com/600x400?text=Hero+Afbeelding'">
        </div>
    </div>
</section>

<style>
    .hero-cta {
        padding: 120px 0;
        background: #fff;
    }

    .container-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        align-items: center;
    }

    .cta-text h1 {
        font-size: 3.5rem;
        color: var(--text-main);
        line-height: 1.1;
        margin-bottom: 25px;
    }

    .cta-text p {
        font-size: 1.25rem;
        color: var(--text-muted);
        margin-bottom: 40px;
    }

    .cta-actions {
        display: flex;
        gap: 20px;
    }

    .btn-primary {
        background: var(--accent-gradient);
        color: white;
        padding: 15px 35px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
    }

    .btn-outline {
        border: 2px solid var(--accent-pink);
        color: var(--accent-pink);
        padding: 13px 33px;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 700;
    }

    .cta-image img {
        width: 100%;
        height: auto;
        border-radius: 30px;
        box-shadow: 0 30px 60px rgba(0, 0, 0, 0.1);
    }
</style>