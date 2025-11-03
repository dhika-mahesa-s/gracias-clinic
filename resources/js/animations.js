// resources/js/animations.js
// Custom animations for Gracias Clinic landing page

// Hero section fade-in animation
function heroFadeIn() {
    const hero = document.querySelector('.hero-section');
    if (hero) {
        hero.style.opacity = '0';
        hero.style.transform = 'translateY(30px)';

        setTimeout(() => {
            hero.style.transition = 'all 1.2s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
            hero.style.opacity = '1';
            hero.style.transform = 'translateY(0)';
        }, 100);
    }
}

// Parallax scroll effect for background
function parallaxScroll() {
    const heroBg = document.querySelector('.hero-bg');
    if (heroBg) {
        window.addEventListener('scroll', () => {
            const scrolled = window.pageYOffset;
            const rate = scrolled * -0.5;
            heroBg.style.transform = `translateY(${rate}px)`;
        });
    }
}

// Stagger animation for content sections
function staggerAnimation() {
    const sections = document.querySelectorAll('.animate-section');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.classList.add('animate-in');
                }, index * 200);
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    sections.forEach(section => {
        observer.observe(section);
    });
}

// Smooth scroll for anchor links
function smoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Enhanced hover effects
function enhancedHoverEffects() {
    // Card hover effects
    const cards = document.querySelectorAll('.hover-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transform = 'translateY(-8px) scale(1.02)';
            card.style.boxShadow = '0 20px 40px rgba(0,0,0,0.1)';
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0) scale(1)';
            card.style.boxShadow = '0 4px 6px rgba(0,0,0,0.05)';
        });
    });

    // Button hover effects
    const buttons = document.querySelectorAll('.btn-hover');
    buttons.forEach(button => {
        button.addEventListener('mouseenter', () => {
            button.style.transform = 'translateY(-2px)';
            button.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });

        button.addEventListener('mouseleave', () => {
            button.style.transform = 'translateY(0)';
            button.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        });
    });
}

// Loading animation
function loadingAnimation() {
    const loader = document.querySelector('.page-loader');
    if (loader) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                loader.style.opacity = '0';
                setTimeout(() => {
                    loader.style.display = 'none';
                }, 500);
            }, 1000);
        });
    }
}

// Initialize all animations when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize AOS if available
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            once: true,
            offset: 100,
            easing: 'ease-out-cubic'
        });
    }

    // Initialize custom animations
    heroFadeIn();
    parallaxScroll();
    staggerAnimation();
    smoothScroll();
    enhancedHoverEffects();
    loadingAnimation();

    // Performance optimization: throttle scroll events
    let scrollTimeout;
    const throttledScroll = () => {
        if (!scrollTimeout) {
            scrollTimeout = setTimeout(() => {
                // Custom scroll-based animations can be added here
                scrollTimeout = null;
            }, 16); // ~60fps
        }
    };

    window.addEventListener('scroll', throttledScroll, { passive: true });
});

// Export functions for potential reuse
export {
    heroFadeIn,
    parallaxScroll,
    staggerAnimation,
    smoothScroll,
    enhancedHoverEffects,
    loadingAnimation
};
