document.addEventListener('DOMContentLoaded', () => {
    if (window.AOS) {
        AOS.init({
            duration: 800,
            once: true,
            offset: 80,
        });
    }

    const nav = document.getElementById('topNav');
    const scrollTop = document.getElementById('scrollTop');

    const handleScroll = () => {
        const isScrolled = window.scrollY > 24;
        nav?.classList.toggle('scrolled', isScrolled);
        scrollTop?.classList.toggle('visible', window.scrollY > 520);
    };

    handleScroll();
    window.addEventListener('scroll', handleScroll, { passive: true });

    scrollTop?.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    document.querySelectorAll('.nav-link[href*="#"]').forEach((link) => {
        link.addEventListener('click', () => {
            const menu = document.getElementById('mainNav');
            if (menu?.classList.contains('show') && window.bootstrap) {
                bootstrap.Collapse.getOrCreateInstance(menu).hide();
            }
        });
    });

    const typingTarget = document.querySelector('.typing-line');
    if (typingTarget) {
        let words = [];
        try {
            words = JSON.parse(typingTarget.dataset.typing || '[]');
        } catch (error) {
            words = [];
        }

        if (words.length) {
            let wordIndex = 0;
            let charIndex = 0;
            let deleting = false;

            const type = () => {
                const word = words[wordIndex];
                typingTarget.textContent = word.slice(0, charIndex);

                if (!deleting && charIndex < word.length) {
                    charIndex += 1;
                    setTimeout(type, 70);
                    return;
                }

                if (!deleting && charIndex === word.length) {
                    deleting = true;
                    setTimeout(type, 1100);
                    return;
                }

                if (deleting && charIndex > 0) {
                    charIndex -= 1;
                    setTimeout(type, 36);
                    return;
                }

                deleting = false;
                wordIndex = (wordIndex + 1) % words.length;
                setTimeout(type, 180);
            };

            type();
        }
    }

    const progressBars = document.querySelectorAll('.progress-bar[data-progress]');
    if ('IntersectionObserver' in window && progressBars.length) {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    bar.style.width = `${bar.dataset.progress}%`;
                    observer.unobserve(bar);
                }
            });
        }, { threshold: 0.45 });

        progressBars.forEach((bar) => observer.observe(bar));
    } else {
        progressBars.forEach((bar) => {
            bar.style.width = `${bar.dataset.progress}%`;
        });
    }

    const filterButtons = document.querySelectorAll('.filter-btn');
    const portfolioItems = document.querySelectorAll('.portfolio-item');

    filterButtons.forEach((button) => {
        button.addEventListener('click', () => {
            filterButtons.forEach((btn) => btn.classList.remove('active'));
            button.classList.add('active');

            const filter = button.dataset.filter;
            portfolioItems.forEach((item) => {
                const visible = filter === 'all' || item.dataset.category === filter;
                item.style.display = visible ? '' : 'none';
                if (visible) {
                    item.classList.add('animate__animated', 'animate__fadeInUp');
                    setTimeout(() => item.classList.remove('animate__animated', 'animate__fadeInUp'), 700);
                }
            });
        });
    });
});

