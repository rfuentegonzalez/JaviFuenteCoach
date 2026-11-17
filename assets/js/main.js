// Envío del formulario sin recargar la página (si falla JS, el formulario funciona igual).
(() => {
    const form = document.querySelector('[data-form]');
    if (!form) return;
    const status = form.querySelector('[data-status]');
    const btn = form.querySelector('button[type="submit"]');

    const setStatus = (msg, ok) => {
        status.textContent = msg;
        status.classList.toggle('is-ok', ok);
        status.classList.toggle('is-error', !ok);
    };

    const validate = () => {
        let ok = true;
        form.querySelectorAll('[required]').forEach((el) => {
            const wrap = el.closest('.field, .check');
            const valid = el.type === 'checkbox' ? el.checked : el.checkValidity() && el.value.trim() !== '';
            wrap && wrap.classList.toggle('is-invalid', !valid);
            if (!valid) ok = false;
        });
        return ok;
    };

    form.addEventListener('input', (e) => {
        const wrap = e.target.closest('.is-invalid');
        if (wrap) wrap.classList.remove('is-invalid');
    });

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        if (!validate()) {
            setStatus('Revisa los campos marcados: nombre, email válido, mensaje y la casilla de privacidad.', false);
            form.querySelector('.is-invalid input, .is-invalid textarea')?.focus();
            return;
        }
        btn.disabled = true;
        btn.textContent = 'Enviando…';
        try {
            const res = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { 'Accept': 'application/json' },
            });
            const data = await res.json();
            setStatus(data.message, !!data.ok);
            if (data.ok) form.reset();
        } catch {
            setStatus('No se ha podido enviar ahora mismo. Prueba de nuevo o escribe directamente al email.', false);
        } finally {
            btn.disabled = false;
            btn.textContent = 'Enviar mensaje';
        }
    });
})();

// Menú fijo: aparece al salir de la portada y marca la sección visible.
(() => {
    const dock = document.querySelector('[data-dock]');
    const hero = document.querySelector('.hero');
    if (!dock || !hero || !('IntersectionObserver' in window)) return;
    new IntersectionObserver(([e]) => dock.classList.toggle('is-visible', !e.isIntersecting), { threshold: 0.05 })
        .observe(hero);

    const links = new Map([...dock.querySelectorAll('a[href^="#"]')].map((a) => [a.getAttribute('href').slice(1), a]));
    const spy = new IntersectionObserver((entries) => {
        entries.forEach((e) => {
            if (!e.isIntersecting) return;
            links.forEach((l) => l.classList.remove('is-active'));
            links.get(e.target.id)?.classList.add('is-active');
        });
    }, { rootMargin: '-45% 0px -50% 0px' });
    document.querySelectorAll('main section[id]').forEach((s) => spy.observe(s));
})();

// Escalera de trayectoria: los escalones suben una sola vez al entrar en pantalla.
(() => {
    const els = document.querySelectorAll('[data-reveal]');
    if (!('IntersectionObserver' in window)) { els.forEach((el) => el.classList.add('is-in')); return; }
    const io = new IntersectionObserver((entries) => {
        entries.forEach((e) => { if (e.isIntersecting) { e.target.classList.add('is-in'); io.unobserve(e.target); } });
    }, { threshold: 0.2 });
    els.forEach((el) => io.observe(el));
})();

// Portada: el nombre entra letra a letra. Al separar las letras para animarlas se pierde el
// ajuste entre parejas como «JA» o «AV»; aquí se mide y se compensa para que el nombre quede igual.
(() => {
    const name = document.querySelector('.hero__name');
    if (!name || !matchMedia('(prefers-reduced-motion: no-preference)').matches) return;
    const lines = [...name.querySelectorAll('.hero__line')].map((l) => [...l.querySelectorAll('.hero__ch')]);

    const fix = () => {
        const fs = parseFloat(getComputedStyle(name).fontSize);
        lines.forEach((chars) => {
            chars.forEach((c) => { c.style.marginLeft = ''; c.style.display = 'inline'; });
            const kerned = chars.map((c) => c.offsetLeft);
            chars.forEach((c) => { c.style.display = ''; });
            const split = chars.map((c) => c.offsetLeft);
            chars.forEach((c, i) => {
                if (!i) return;
                const gap = (kerned[i] - kerned[i - 1]) - (split[i] - split[i - 1]);
                if (Math.abs(gap) > 0.2) c.style.marginLeft = `${(gap / fs).toFixed(4)}em`;
            });
        });
    };
    fix();
    document.fonts?.ready.then(fix);
})();

// Portada: el retrato y su círculo se mueven un poco con el ratón y el scroll (sensación de profundidad).
// Solo en pantallas grandes; en móvil y con «reducir movimiento» se queda quieto.
(() => {
    const photo = document.querySelector('.hero__photo');
    const hero = document.querySelector('.hero');
    const mq = matchMedia('(min-width: 901px) and (prefers-reduced-motion: no-preference)');
    if (!photo || !hero) return;
    const fine = matchMedia('(hover: hover) and (pointer: fine)');

    const target = { mx: 0, my: 0, sy: 0 };
    const now = { mx: 0, my: 0, sy: 0 };
    let raf = 0;

    const tick = () => {
        let moving = false;
        for (const k in now) {
            const d = target[k] - now[k];
            now[k] = Math.abs(d) < 0.001 ? target[k] : now[k] + d * 0.12;
            if (now[k] !== target[k]) moving = true;
            photo.style.setProperty(`--${k}`, now[k].toFixed(3));
        }
        raf = moving ? requestAnimationFrame(tick) : 0;
    };
    const go = () => { if (!raf) raf = requestAnimationFrame(tick); };

    hero.addEventListener('pointermove', (e) => {
        if (!mq.matches || !fine.matches || e.pointerType !== 'mouse') return;
        const r = hero.getBoundingClientRect();
        target.mx = ((e.clientX - r.left) / r.width - 0.5) * 2;
        target.my = ((e.clientY - r.top) / r.height - 0.5) * 2;
        go();
    });
    hero.addEventListener('pointerleave', () => { target.mx = target.my = 0; go(); });
    addEventListener('scroll', () => {
        if (!mq.matches) return;
        target.sy = Math.min(scrollY, hero.offsetHeight);
        go();
    }, { passive: true });
    mq.addEventListener?.('change', () => { if (!mq.matches) { target.mx = target.my = target.sy = 0; go(); } });
})();
