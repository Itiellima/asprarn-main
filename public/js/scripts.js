// Mobile Menu Toggle
function toggleMenu() {
    const nav = document.querySelector('.nav-desktop');
    if (nav) {
        nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
        if (window.innerWidth < 768) {
            nav.style.position = 'absolute';
            nav.style.top = '80px';
            nav.style.left = '0';
            nav.style.right = '0';
            nav.style.background = 'white';
            nav.style.flexDirection = 'column';
            nav.style.padding = '1rem';
            nav.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        }
    }
}

// Form Submit Handler
function handleSubmit(event) {
    event.preventDefault();
    
    const formData = new FormData(event.target);
    const data = {
        name: formData.get('name'),
        email: formData.get('email'),
        phone: formData.get('phone'),
        message: formData.get('message')
    };
    
    console.log('Form submitted:', data);
    alert('Mensagem enviada com sucesso! Entraremos em contato em breve.');
    event.target.reset();
}

// Smooth scroll for anchor links
document.addEventListener('DOMContentLoaded', function() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                const headerOffset = 80;
                const elementPosition = target.getBoundingClientRect().top;
                const offsetPosition = elementPosition + window.pageYOffset - headerOffset;
                
                window.scrollTo({
                    top: offsetPosition,
                    behavior: 'smooth'
                });
                
                // Close mobile menu if open
                const nav = document.querySelector('.nav-desktop');
                if (window.innerWidth < 768 && nav.style.display === 'flex') {
                    toggleMenu();
                }
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        const nav = document.querySelector('.nav-desktop');
        if (window.innerWidth >= 768) {
            nav.style.display = 'flex';
            nav.style.position = '';
            nav.style.flexDirection = '';
            nav.style.padding = '';
            nav.style.boxShadow = '';
        } else {
            nav.style.display = 'none';
        }
    });
});