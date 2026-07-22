document.addEventListener('DOMContentLoaded', () => {
    const hero = document.querySelector('[data-hero-slider]');
    if (!hero) return;

    const slides = hero.querySelectorAll('.cine-slide');
    if (slides.length < 2) return;

    let current = 0;
    let interval = null;

    const show = (index) => {
        slides.forEach((slide, i) => slide.classList.toggle('is-active', i === index));
        current = index;
    };

    const next = () => show((current + 1) % slides.length);
    const prev = () => show((current - 1 + slides.length) % slides.length);

    const startAutoplay = () => {
        clearInterval(interval);
        interval = setInterval(next, 7000);
    };

    hero.querySelector('[data-hero-next]')?.addEventListener('click', () => {
        next();
        startAutoplay();
    });

    hero.querySelector('[data-hero-prev]')?.addEventListener('click', () => {
        prev();
        startAutoplay();
    });

    show(0);
    startAutoplay();
});
