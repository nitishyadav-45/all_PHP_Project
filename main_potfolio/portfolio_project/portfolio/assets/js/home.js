
  // Mobile menu
  const menuBtn = document.getElementById('menuBtn');
  const closeMenu = document.getElementById('closeMenu');
  const mobileMenu = document.getElementById('mobileMenu');
  
  menuBtn.addEventListener('click', () => mobileMenu.classList.add('open'));
  closeMenu.addEventListener('click', () => mobileMenu.classList.remove('open'));
  document.querySelectorAll('.mobile-link').forEach(link => {
    link.addEventListener('click', () => mobileMenu.classList.remove('open'));
  });

  // Navbar scroll effect
  const navbar = document.getElementById('navbar');
  window.addEventListener('scroll', () => {
    if (window.scrollY > 50) {
      navbar.classList.add('shadow-2xl');
    } else {
      navbar.classList.remove('shadow-2xl');
    }
    
    // Back to top
    const backToTop = document.getElementById('backToTop');
    if (window.scrollY > 500) {
      backToTop.style.opacity = '1';
      backToTop.style.pointerEvents = 'auto';
    } else {
      backToTop.style.opacity = '0';
      backToTop.style.pointerEvents = 'none';
    }
  });

  document.getElementById('backToTop').addEventListener('click', () => {
    window.scrollTo({top: 0, behavior: 'smooth'});
  });

  // Active nav link on scroll
  const sections = document.querySelectorAll('section[id]');
  const navLinks = document.querySelectorAll('.nav-link');
  window.addEventListener('scroll', () => {
    let current = '';
    sections.forEach(section => {
      const sectionTop = section.offsetTop - 100;
      if (window.scrollY >= sectionTop) {
        current = section.getAttribute('id');
      }
    });
    navLinks.forEach(link => {
      link.classList.remove('active');
      if (link.getAttribute('href') === '#' + current) {
        link.classList.add('active');
      }
    });
  });

  // Reveal on scroll
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        
        // Animate skill bars
        if (entry.target.querySelector('.skill-fill')) {
          entry.target.querySelectorAll('.skill-fill').forEach(fill => {
            fill.style.width = fill.dataset.width + '%';
          });
        }
        
        // Animate counters
        if (entry.target.querySelector('.counter')) {
          entry.target.querySelectorAll('.counter').forEach(counter => {
            const target = parseInt(counter.dataset.target);
            let count = 0;
            const increment = target / 60;
            const update = () => {
              count += increment;
              if (count < target) {
                counter.textContent = Math.floor(count) + (target >= 15 ? '+' : '');
                requestAnimationFrame(update);
              } else {
                counter.textContent = target + (target >= 15 ? '+' : '');
              }
            };
            update();
          });
        }
      }
    });
  }, { threshold: 0.15 });

  document.querySelectorAll('.reveal').forEach(el => observer.observe(el));

  // Project filter
  const filterPills = document.querySelectorAll('.filter-pill');
  const projectCards = document.querySelectorAll('[data-category]');
  
  filterPills.forEach(pill => {
    pill.addEventListener('click', () => {
      filterPills.forEach(p => p.classList.remove('active'));
      pill.classList.add('active');
      
      const filter = pill.dataset.filter;
      projectCards.forEach(card => {
        if (filter === 'all' || card.dataset.category === filter) {
          card.style.display = '';
          setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'scale(1)';
          }, 50);
        } else {
          card.style.opacity = '0';
          card.style.transform = 'scale(0.8)';
          setTimeout(() => card.style.display = 'none', 300);
        }
      });
    });
  });

  // Style active filter
  const style = document.createElement('style');
  style.textContent = `.filter-pill.active{background:linear-gradient(135deg,#ff6b35,#ffb627);color:#000;border-color:transparent;}`;
  document.head.appendChild(style);

  // Form handler
  function handleSubmit(e) {
    e.preventDefault();
    showToast('Message sent successfully! I\'ll get back to you soon.');
    e.target.reset();
    return false;
  }

  function showToast(msg) {
    const toast = document.getElementById('toast');
    const toastMsg = document.getElementById('toastMsg');
    toastMsg.textContent = msg;
    toast.style.opacity = '1';
    toast.style.transform = 'translate(-50%, -10px)';
    setTimeout(() => {
      toast.style.opacity = '0';
      toast.style.transform = 'translate(-50%, 0)';
    }, 3500);
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function(e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  document.addEventListener('DOMContentLoaded', function() {
  // Check if the element exists to avoid errors
  if (document.querySelector('.typed-text')) {
    var typed = new Typed('.typed-text', {
      strings: ["Full Stact Developer","Developer", "Designer", "Problem Solver"], // Yahan apne words add karein
      typeSpeed: 50,      // Type karne ki speed
      backSpeed: 30,      // Backspace karne ki speed
      backDelay: 1500,    // Naya word type karne se pehle ka delay
      loop: true          // Loop mein chalane ke liye
    });
  }
});