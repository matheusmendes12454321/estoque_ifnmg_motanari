// Smooth scroll para links internos
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

// Navbar transparente ao rolar
const navbar = document.querySelector('.navbar');
let lastScroll = 0;

window.addEventListener('scroll', () => {
    const currentScroll = window.pageYOffset;
    
    if (currentScroll <= 0) {
        navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.05)';
    } else {
        navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
    }
    
    lastScroll = currentScroll;
});

// Animação de entrada dos elementos ao rolar
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observar cards de recursos
document.querySelectorAll('.recurso-card').forEach((card, index) => {
    card.style.opacity = '0';
    card.style.transform = 'translateY(30px)';
    card.style.transition = `all 0.6s ease ${index * 0.1}s`;
    observer.observe(card);
});

// Efeito de typing no título (opcional)
const heroTitle = document.querySelector('.hero-title');
if (heroTitle) {
    const text = heroTitle.innerHTML;
    heroTitle.innerHTML = '';
    let i = 0;
    
    function typeWriter() {
        if (i < text.length) {
            heroTitle.innerHTML += text.charAt(i);
            i++;
            setTimeout(typeWriter, 50);
        }
    }
    
    // Descomentar para ativar efeito de digitação
    // typeWriter();
}

// Contador animado para estatísticas
function animateCounter(element, target, duration = 2000) {
    let current = 0;
    const increment = target / (duration / 16);
    const isMoney = element.textContent.includes('R$');
    const isPercent = element.textContent.includes('%');
    
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            current = target;
            clearInterval(timer);
        }
        
        let displayValue = Math.floor(current);
        
        if (target >= 1000) {
            displayValue = (displayValue / 1000).toFixed(0) + 'k+';
        } else if (isPercent) {
            displayValue = displayValue.toFixed(1) + '%';
        } else {
            displayValue = displayValue + '+';
        }
        
        element.textContent = displayValue;
    }, 16);
}

// Animar contadores quando visíveis
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const numbers = document.querySelectorAll('.stat-number');
            numbers.forEach(num => {
                const text = num.textContent;
                const value = parseFloat(text.replace(/[^0-9.]/g, ''));
                num.textContent = '0';
                animateCounter(num, value);
            });
            statsObserver.disconnect();
        }
    });
}, { threshold: 0.5 });

const statsSection = document.querySelector('.hero-stats');
if (statsSection) {
    statsObserver.observe(statsSection);
}

// Adicionar classe active aos links do menu baseado na seção
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('section[id]');
    const scrollY = window.pageYOffset;
    
    sections.forEach(section => {
        const sectionHeight = section.offsetHeight;
        const sectionTop = section.offsetTop - 100;
        const sectionId = section.getAttribute('id');
        const navLink = document.querySelector(`.nav-links a[href="#${sectionId}"]`);
        
        if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
            document.querySelectorAll('.nav-links a').forEach(link => {
                link.style.color = 'var(--text)';
            });
            if (navLink) {
                navLink.style.color = 'var(--primary)';
            }
        }
    });
});

// Prevenir zoom em mobile ao focar inputs
document.addEventListener('touchstart', function() {}, { passive: true });

// Adicionar efeito parallax suave nos círculos de fundo
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const circles = document.querySelectorAll('.circle');
    
    circles.forEach((circle, index) => {
        const speed = (index + 1) * 0.1;
        circle.style.transform = `translateY(${scrolled * speed}px)`;
    });
});

// Log de boas-vindas no console
console.log('%c📦 StockFlow', 'font-size: 24px; color: #4ecdc4; font-weight: bold;');
console.log('%cSistema de Gestão de Estoque', 'font-size: 14px; color: #7f8c8d;');
console.log('%cDesenvolvido com 💚', 'font-size: 12px; color: #2ecc71;');