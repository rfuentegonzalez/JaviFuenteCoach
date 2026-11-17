<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$cfg = require __DIR__ . '/config.php';
$d   = require __DIR__ . '/includes/data.php';

$sent  = isset($_GET['enviado']);
$error = $_GET['error'] ?? '';
$desc = "{$d['full_name']}, entrenador UEFA C de fútbol base. {$d['current']}";
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($d['name']) ?> · Entrenador de fútbol base</title>
<meta name="description" content="<?= e($desc) ?>">
<meta name="theme-color" content="#0B1630">
<link rel="canonical" href="<?= e($cfg['site_url']) ?>/">
<meta property="og:type" content="profile">
<meta property="og:title" content="<?= e($d['name']) ?> · Entrenador de fútbol base">
<meta property="og:description" content="<?= e($desc) ?>">
<meta property="og:image" content="<?= e($cfg['site_url']) ?>/assets/img/og-image.jpg">
<meta property="og:locale" content="es_ES">
<meta name="twitter:card" content="summary_large_image">
<link rel="icon" href="<?= e(asset('assets/logo/favicon.png')) ?>" type="image/png">
<link rel="apple-touch-icon" href="<?= e(asset('assets/logo/favicon.png')) ?>">
<script>document.documentElement.classList.add('js')</script>
<link rel="preload" href="assets/fonts/InterDisplay-Black.woff2" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
<script type="application/ld+json"><?= json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Person',
    'name' => $d['full_name'],
    'jobTitle' => $d['role'],
    'url' => $cfg['site_url'],
    'image' => $cfg['site_url'] . '/assets/img/javi-azul.png',
    'hasCredential' => 'Entrenador UEFA C (RFFM)',
], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?></script>
</head>
<body>
<a class="skip" href="#contenido">Saltar al contenido</a>

<header class="top">
    <a class="top__logo" href="#" aria-label="<?= e($d['name']) ?>, inicio">
        <img src="<?= e(asset('assets/logo/jf-logo-horizontal-blanco.png')) ?>" alt="<?= e($d['name']) ?> · Entrenador de fútbol base" width="461" height="92">
    </a>
    <nav class="top__nav" aria-label="Secciones">
        <a href="#trayectoria">Trayectoria</a>
        <a href="#mi-idea">Mi idea de fútbol</a>
        <a href="#formacion">Formación</a>
        <a class="btn btn--light btn--sm" href="#contacto">Contactar</a>
    </nav>
</header>

<nav class="dock" aria-label="Navegación rápida" data-dock>
    <a class="dock__logo" href="#" aria-label="Volver arriba"><img src="<?= e(asset('assets/logo/jf-monograma-blanco.png')) ?>" alt="" width="34" height="34"></a>
    <a href="#sobre-mi">Sobre mí</a>
    <a href="#trayectoria">Trayectoria</a>
    <a href="#mi-idea">Mi idea de fútbol</a>
    <a href="#formacion">Formación</a>
    <a class="btn btn--volt btn--sm" href="#contacto">Contactar</a>
</nav>

<main id="contenido">

<!-- PORTADA -->
<section class="hero" aria-labelledby="hero-title">
    <svg class="hero__pitch" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice" aria-hidden="true">
        <g fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path class="chalk" style="--d:0s" pathLength="1" d="M40 40H1160V760H40Z"/>
            <path class="chalk" style="--d:.25s" pathLength="1" d="M600 40V760"/>
            <path class="chalk" style="--d:.4s" pathLength="1" d="M600 290a110 110 0 1 1 0 220a110 110 0 1 1 0-220"/>
            <circle class="chalk-dot" cx="600" cy="400" r="4" fill="currentColor"/>
            <path class="chalk" style="--d:.5s" pathLength="1" d="M40 200H210V600H40"/>
            <path class="chalk" style="--d:.65s" pathLength="1" d="M40 300H100V500H40"/>
            <path class="chalk" style="--d:.75s" pathLength="1" d="M210 330a90 90 0 0 1 0 140"/>
            <path class="chalk" style="--d:.5s" pathLength="1" d="M1160 200H990V600H1160"/>
            <path class="chalk" style="--d:.65s" pathLength="1" d="M1160 300H1100V500H1160"/>
            <path class="chalk" style="--d:.75s" pathLength="1" d="M990 330a90 90 0 0 0 0 140"/>
        </g>
    </svg>

    <div class="hero__inner">
        <h1 id="hero-title" class="hero__name">
            <span class="sr-only">Javier Fuente</span>
            <span class="hero__line" aria-hidden="true"><?= hero_letters('Javier') ?></span>
            <span class="hero__line" aria-hidden="true"><?= hero_letters('Fuente', 6) ?><span class="hero__ball"></span></span>
        </h1>

        <div class="hero__intro">
            <p class="hero__role"><?= e($d['role']) ?>. <?= e($d['current']) ?></p>
            <div class="hero__ctas">
                <a class="btn btn--volt" href="#contacto">Escríbeme</a>
                <a class="btn btn--ghost" href="#trayectoria">Ver trayectoria</a>
            </div>
        </div>
    </div>

    <?= picture('javi-azul', 'png', "{$d['name']} con la camiseta de entrenamiento", 'hero__photo', 'eager', [789, 1400]) ?>
</section>

<!-- SOBRE MÍ -->
<section class="about" id="sobre-mi" aria-labelledby="about-title">
    <div class="wrap bento">
        <figure class="bento__art">
            <?= picture('javi-celebra-ilustracion', 'png', "Ilustración de {$d['name']} celebrando un gol", '', 'lazy', [1360, 1150]) ?>
        </figure>
        <div class="bento__text">
            <h2 id="about-title" class="h2">Hace nada estaba en su lugar</h2>
            <?php foreach ($d['about'] as $p): ?>
            <p><?= e($p) ?></p>
            <?php endforeach; ?>
            <a class="btn btn--outline" href="<?= e(asset('assets/docs/CV-Javier-Fuente.pdf')) ?>" download="CV-Javier-Fuente.pdf">Descargar CV completo <span class="btn__meta">PDF</span></a>
        </div>
        <blockquote class="bento__quote"><p><?= e($d['quote']) ?></p></blockquote>
        <ul class="bento__stats" aria-label="En cifras">
            <?php foreach ($d['facts'] as $f): ?>
            <li><strong><?= e($f['value']) ?></strong><span><?= e($f['label']) ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- TRAYECTORIA: escalera, de la temporada más antigua a la actual -->
<section class="career" id="trayectoria" aria-labelledby="career-title">
    <div class="wrap">
        <div class="sec-head">
            <h2 id="career-title" class="h2">Trayectoria</h2>
            <p class="lead">Cuatro temporadas, un escalón cada año: dos como segundo entrenador y dos al frente del equipo.</p>
        </div>

        <ol class="steps" data-reveal>
            <?php foreach (array_reverse($d['seasons']) as $i => $s): ?>
            <li class="step<?= !empty($s['now']) ? ' is-now' : '' ?>" style="--i: <?= (int) $i ?>">
                <div class="step__head">
                    <span class="step__season"><?= e($s['season']) ?></span>
                    <?php if (!empty($s['now'])): ?><em class="tag">Ahora</em><?php endif; ?>
                </div>
                <?php foreach ($s['roles'] as $r): ?>
                <div class="step__role">
                    <h3><?= e($r['title']) ?></h3>
                    <p class="step__club"><?= e($r['club']) ?></p>
                    <ul class="chips">
                        <?php foreach ($r['tags'] as $t): ?><li><?= e($t) ?></li><?php endforeach; ?>
                    </ul>
                    <?php if (!empty($r['badge'])): ?>
                    <p class="badge"><span class="dot" aria-hidden="true"></span><?= e($r['badge']) ?></p>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </li>
            <?php endforeach; ?>
        </ol>
    </div>
</section>

<!-- MI IDEA DE FÚTBOL -->
<section class="method" id="mi-idea" aria-labelledby="method-title">
    <div class="wrap">
        <div class="sec-head">
            <h2 id="method-title" class="h2">Mi idea de fútbol</h2>
            <p class="lead">Tres ideas que guían cada entrenamiento. Ninguna depende del marcador.</p>
        </div>

        <div class="ideas">
            <?php foreach ($d['ideas'] as $i): ?>
            <article class="idea">
                <h3><?= e($i['title']) ?></h3>
                <p><?= e($i['text']) ?></p>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Pizarra táctica -->
        <div class="board">
            <div class="board__copy">
                <h3 class="h3">Preguntas antes que respuestas</h3>
                <p>En las tareas no doy la solución: pregunto, y que sean ellos quienes la encuentren en el campo. Estas son las que más se oyen en mis entrenamientos.</p>
            </div>
            <div class="pitch">
                <svg class="pitch__svg" viewBox="0 0 1000 560" aria-hidden="true">
                    <g class="pitch__lines" fill="none" stroke-width="3">
                        <rect x="20" y="20" width="960" height="520" rx="4"/>
                        <path d="M20 190 a90 90 0 0 1 0 180"/>
                        <rect x="800" y="130" width="180" height="300"/>
                        <rect x="920" y="210" width="60" height="140"/>
                        <path d="M800 230 a70 70 0 0 0 0 100"/>
                        <circle cx="880" cy="280" r="4" fill="currentColor"/>
                    </g>
                    <g class="pitch__runs" fill="none" stroke-width="3" stroke-dasharray="10 10" stroke-linecap="round">
                        <path d="M262 300 Q330 200 418 160"/>
                        <path d="M262 300 Q450 300 622 284"/>
                        <path d="M262 300 Q350 400 455 420"/>
                        <path d="M700 470 Q720 400 690 330"/>
                    </g>
                    <g class="pitch__rivals">
                        <circle cx="380" cy="250" r="15"/><circle cx="560" cy="210" r="15"/>
                        <circle cx="560" cy="370" r="15"/><circle cx="780" cy="300" r="15"/>
                        <circle cx="940" cy="280" r="15"/>
                    </g>
                    <g class="pitch__team">
                        <circle cx="430" cy="150" r="17"/><circle cx="640" cy="280" r="17"/>
                        <circle cx="470" cy="425" r="17"/><circle cx="705" cy="480" r="17"/>
                        <circle cx="248" cy="300" r="17"/>
                    </g>
                    <circle class="pitch__ball" cx="276" cy="318" r="9"/>
                </svg>
                <ul class="bubbles">
                    <?php foreach ($d['questions'] as $k => $q): ?>
                    <li class="bubble bubble--<?= $k + 1 ?>"><?= e($q) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

    </div>
</section>

<!-- LO QUE APORTO -->
<section class="growth" aria-labelledby="growth-title">
    <div class="wrap growth__grid">
        <div class="growth__panel">
            <?= picture('javi-paseo', 'png', "{$d['name']} caminando por el campo", 'growth__photo', 'lazy', [490, 1300]) ?>
        </div>
        <div class="growth__lists">
            <h2 id="growth-title" class="h2">Lo que aporto</h2>
            <dl class="pros">
                <?php foreach ($d['strengths'] as $s): ?>
                <div><dt><?= e($s['title']) ?></dt><dd><?= e($s['text']) ?></dd></div>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>

<!-- FORMACIÓN -->
<section class="edu" id="formacion" aria-labelledby="edu-title">
    <div class="wrap">
        <div class="sec-head">
            <h2 id="edu-title" class="h2">Formación</h2>
            <p class="lead">El camino de licencias UEFA, y lo que estudia en paralelo.</p>
        </div>

        <ol class="licenses" aria-label="Licencias de entrenador UEFA">
            <?php
            $lab = ['done' => 'Conseguida', 'progress' => 'En curso', 'next' => 'Siguiente paso', 'later' => ''];
            foreach ($d['licenses'] as $l): ?>
            <li class="license is-<?= e($l['status']) ?>">
                <span class="license__node" aria-hidden="true"></span>
                <span class="license__name"><small>UEFA</small> <?= e($l['name']) ?></span>
                <?php if ($lab[$l['status']]): ?><span class="license__status"><?= e($lab[$l['status']]) ?></span><?php endif; ?>
                <span class="license__note"><?= e($l['note']) ?></span>
            </li>
            <?php endforeach; ?>
        </ol>

        <ul class="studies">
            <?php foreach ($d['education'] as $ed): ?>
            <li class="study">
                <span class="tag tag--outline">En curso</span>
                <h3><?= e($ed['title']) ?></h3>
                <p><?= e($ed['where']) ?></p>
                <p class="study__when"><?= e($ed['when']) ?></p>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<!-- CONTACTO -->
<section class="contact" id="contacto" aria-labelledby="contact-title">
    <div class="wrap contact__grid">
        <div class="contact__copy">
            <h2 id="contact-title" class="h2">¿Hablamos?</h2>
            <p>Si coordinas una escuela o un club y buscas entrenador para la próxima temporada, o quieres conocer cómo trabajo, escríbeme.</p>
            <p class="contact__cv"><a class="btn btn--light" href="<?= e(asset('assets/docs/CV-Javier-Fuente.pdf')) ?>" download="CV-Javier-Fuente.pdf">Descargar CV completo <span class="btn__meta">PDF</span></a></p>
            <ul class="contact__direct">
                <?php if ($cfg['public_email']): ?>
                <li><a href="mailto:<?= e($cfg['public_email']) ?>"><?= e($cfg['public_email']) ?></a></li>
                <?php endif; ?>
                <?php if ($cfg['public_phone']): ?>
                <li><a href="tel:<?= e(preg_replace('/\s+/', '', $cfg['public_phone'])) ?>"><?= e($cfg['public_phone']) ?></a></li>
                <?php endif; ?>
                <?php if ($cfg['instagram']): ?><li><a href="<?= e($cfg['instagram']) ?>" rel="me noopener">Instagram</a></li><?php endif; ?>
                <?php if ($cfg['linkedin']): ?><li><a href="<?= e($cfg['linkedin']) ?>" rel="me noopener">LinkedIn</a></li><?php endif; ?>
            </ul>
        </div>

        <form class="form" action="contacto.php" method="post" novalidate data-form>
            <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
            <div class="form__hp" aria-hidden="true">
                <label>No rellenar <input type="text" name="web" tabindex="-1" autocomplete="off"></label>
            </div>
            <div class="form__row">
                <label class="field"><span>Nombre</span><input name="nombre" required maxlength="80" autocomplete="name"></label>
                <label class="field"><span>Club o escuela <em>(opcional)</em></span><input name="club" maxlength="120" autocomplete="organization"></label>
            </div>
            <label class="field"><span>Email</span><input name="email" type="email" required maxlength="120" autocomplete="email"></label>
            <label class="field"><span>Mensaje</span><textarea name="mensaje" rows="5" required maxlength="3000"></textarea></label>
            <label class="check">
                <input type="checkbox" name="privacidad" value="1" required>
                <span>He leído la <a href="privacidad.php">política de privacidad</a> y acepto que se usen mis datos para responder a este mensaje.</span>
            </label>
            <button class="btn btn--volt" type="submit">Enviar mensaje</button>
            <p class="form__status" role="status" aria-live="polite" data-status><?php
                if ($sent) echo 'Mensaje enviado. Javier te responderá lo antes posible.';
                elseif ($error) echo e(match ($error) {
                    'campos' => 'Revisa los campos: nombre, email válido, mensaje y la casilla de privacidad son obligatorios.',
                    'envio'  => 'No se ha podido enviar ahora mismo. Prueba de nuevo o escribe directamente al email.',
                    default  => 'La página ha caducado. Recarga e inténtalo otra vez.',
                });
            ?></p>
        </form>
    </div>
</section>
</main>

<footer class="foot">
    <div class="wrap foot__inner">
        <img src="<?= e(asset('assets/logo/jf-monograma-blanco.png')) ?>" alt="" width="48" height="48">
        <p>© <?= date('Y') ?> <?= e($d['full_name']) ?> · <a href="privacidad.php">Privacidad</a></p>
    </div>
</footer>

<script src="<?= e(asset('assets/js/main.js')) ?>" defer></script>
</body>
</html>
