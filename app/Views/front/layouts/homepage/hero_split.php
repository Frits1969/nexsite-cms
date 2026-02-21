<section class="hero-split">
    <div class="split-left">
        <div class="content-box">
            <span class="badge">Nieuw</span>
            <h1>
                <?= $settings['site_name'] ?>
            </h1>
            <p>
                <?= $settings['site_description'] ?>
            </p>
            <form class="newsletter-form">
                <input type="email" placeholder="Uw e-mailadres">
                <button type="submit">Begin nu</button>
            </form>
        </div>
    </div>
    <div class="split-right" style="background-image: url('https://via.placeholder.com/800x1000?text=Premium+Visual')">
    </div>
</section>

<style>
    .hero-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        min-height: 80vh;
    }

    .split-left {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 80px;
        background: white;
    }

    .content-box {
        max-width: 500px;
    }

    .badge {
        background: var(--accent-orange);
        color: white;
        padding: 4px 12px;
        border-radius: 50px;
        font-size: 0.8rem;
        font-weight: 700;
    }

    .split-left h1 {
        font-size: 4rem;
        margin: 20px 0;
        color: var(--text-main);
        line-height: 1;
    }

    .split-left p {
        font-size: 1.25rem;
        color: var(--text-muted);
        margin-bottom: 40px;
    }

    .split-right {
        background-size: cover;
        background-position: center;
    }

    .newsletter-form {
        display: flex;
        gap: 10px;
    }

    .newsletter-form input {
        flex: 1;
        padding: 15px 20px;
        border: 1px solid #ddd;
        border-radius: 12px;
        outline: none;
    }

    .newsletter-form button {
        background: var(--text-main);
        color: white;
        border: none;
        padding: 0 30px;
        border-radius: 12px;
        font-weight: 700;
        cursor: pointer;
    }
</style>