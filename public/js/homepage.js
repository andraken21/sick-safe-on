    // Hamburger toggle (simple, no Alpine/jQuery needed)
    const hamburger = document.querySelector('.hamburger');
    const navLinks  = document.querySelector('.nav-links');
    const navAct    = document.querySelector('.nav-actions');

    hamburger.addEventListener('click', () => {
        const open = navLinks.style.display === 'flex';
        navLinks.style.cssText = open ? '' : 'display:flex;flex-direction:column;position:absolute;top:68px;left:0;right:0;background:#fff;padding:1.5rem 5%;gap:1rem;border-bottom:1px solid var(--border);z-index:99;';
        navAct.style.cssText   = open ? '' : 'display:flex;flex-direction:row;position:absolute;top:calc(68px + 10rem);left:0;right:0;background:#fff;padding:1rem 5% 1.5rem;gap:.75rem;z-index:99;';
    });

    // Smooth active nav highlight
    const sections = document.querySelectorAll('section[id], div[id]');
    const links    = document.querySelectorAll('.nav-links a');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                links.forEach(l => l.style.color = '');
                const active = document.querySelector(`.nav-links a[href="#${entry.target.id}"]`);
                if (active) active.style.color = 'var(--teal)';
            }
        });
    }, { threshold: 0.4 });

    sections.forEach(s => observer.observe(s));
