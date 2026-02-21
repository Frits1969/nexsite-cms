<section class="hero-video">
    <div class="container">
        <div class="video-container">
            <div class="video-overlay">
                <h1>Ontdek onze visie</h1>
                <button class="play-btn">▶</button>
            </div>
            <img src="https://via.placeholder.com/1200x600?text=Video+Thumbnail" alt="Video">
        </div>

        <div class="testimonials">
            <h2>Wat onze klanten zeggen</h2>
            <div class="testimonial-cards">
                <div class="t-card">
                    <p>"Fritsion CMS heeft de manier waarop wij onze content beheren volledig veranderd."</p>
                    <strong>- Jan de Vries, CEO</strong>
                </div>
                <div class="t-card">
                    <p>"De snelheid en flexibiliteit zijn ongekend in deze markt."</p>
                    <strong>- Sarah Jansen, Marketeer</strong>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .hero-video {
        padding: 100px 0;
        background: #1A1336;
        color: white;
    }

    .video-container {
        position: relative;
        border-radius: 30px;
        overflow: hidden;
        margin-bottom: 80px;
    }

    .video-overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .play-btn {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: none;
        background: white;
        color: var(--accent-pink);
        font-size: 2rem;
        cursor: pointer;
        margin-top: 20px;
        transition: transform 0.2s;
    }

    .play-btn:hover {
        transform: scale(1.1);
    }

    .testimonials h2 {
        text-align: center;
        font-size: 2rem;
        margin-bottom: 40px;
    }

    .testimonial-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
    }

    .t-card {
        background: rgba(255, 255, 255, 0.05);
        padding: 40px;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-style: italic;
    }

    .t-card strong {
        display: block;
        margin-top: 20px;
        font-style: normal;
        color: var(--accent-orange);
    }
</style>