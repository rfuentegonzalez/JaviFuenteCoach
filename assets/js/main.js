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
