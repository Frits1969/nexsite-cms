<section class="hero-blog">
    <div class="container">
        <div class="blog-header">
            <div>
                <h1>Laatste Nieuws</h1>
                <p>Blijf op de hoogte van de ontwikkelingen bij
                    <?= $settings['site_name'] ?>
                </p>
            </div>
            <a href="/blog" class="btn-text">Bekijk alle artikelen →</a>
        </div>

        <div class="blog-grid">
            <div class="blog-post">
                <div class="post-img" style="background-image: url('https://via.placeholder.com/400x250?text=Blog+1')">
                </div>
                <div class="post-content">
                    <span class="category">Updates</span>
                    <h3>Lancering Fritsion CMS v0.1.3</h3>
                    <p>De nieuwste update brengt vele verbeteringen in de gebruikerservaring...</p>
                </div>
            </div>
            <div class="blog-post">
                <div class="post-img" style="background-image: url('https://via.placeholder.com/400x250?text=Blog+2')">
                </div>
                <div class="post-content">
                    <span class="category">Tips</span>
                    <h3>Hoe maak je een perfecte homepage?</h3>
                    <p>In dit artikel leggen we uit waar je op moet letten bij het inrichten...</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-blog {
        padding: 100px 0;
    }

    .blog-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-bottom: 50px;
    }

    .blog-header h1 {
        font-size: 2.5rem;
        margin-bottom: 10px;
    }

    .blog-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    .blog-post {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.05);
    }

    .post-img {
        height: 250px;
        background-size: cover;
        background-position: center;
    }

    .post-content {
        padding: 30px;
    }

    .category {
        color: var(--accent-pink);
        font-weight: 700;
        font-size: 0.8rem;
        text-transform: uppercase;
        margin-bottom: 15px;
        display: block;
    }

    .post-content h3 {
        font-size: 1.5rem;
        margin-bottom: 15px;
    }

    .btn-text {
        color: var(--accent-pink);
        text-decoration: none;
        font-weight: 700;
    }
</style>