document.addEventListener('DOMContentLoaded', function() {
    // Mobile Menu Toggle
    const menuBtn = document.querySelector('button.md\\:hidden');
    const navMenu = document.querySelector('.md\\:flex.space-x-8');

    if (menuBtn && navMenu) {
        menuBtn.addEventListener('click', () => {
            // In a real implementation, you'd toggle a mobile-specific menu
            // For now, we'll just log it or you could add classes to show/hide
            console.log('Mobile menu clicked');
        });
    }

    // Smooth Scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });
});
