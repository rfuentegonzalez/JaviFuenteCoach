<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$cfg = require __DIR__ . '/config.php';
?>
<!doctype html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Política de privacidad · Javier Fuente</title>
<meta name="robots" content="noindex">
<link rel="stylesheet" href="<?= e(asset('assets/css/style.css')) ?>">
</head>
<body class="page-light">
<div class="legal-top"><a href="index.php"><img src="<?= e(asset('assets/logo/jf-logo-horizontal-blanco.png')) ?>" alt="Javier Fuente · volver al inicio" width="461" height="92"></a></div>
<main class="legal">
    <h1>Política de privacidad</h1>
    <p>Esta web solo recoge los datos que tú escribes en el formulario de contacto: nombre, club o escuela, email y mensaje.</p>

    <h2>Quién es el responsable</h2>
    <p><?= e($cfg['privacy_owner']) ?>. Contacto: <a href="mailto:<?= e($cfg['contact_to']) ?>"><?= e($cfg['contact_to']) ?></a>.</p>

    <h2>Para qué se usan</h2>
    <p>Únicamente para responder a tu mensaje. No se envían boletines ni se ceden a terceros.</p>

    <h2>Base legal y conservación</h2>
    <p>Tu consentimiento al marcar la casilla del formulario. Los mensajes se guardan en el correo el tiempo necesario para atender la consulta y después se eliminan.</p>

    <h2>Tus derechos</h2>
    <ul>
        <li>Acceder a tus datos, corregirlos o pedir que se borren.</li>
        <li>Oponerte a su uso o retirar tu consentimiento en cualquier momento.</li>
        <li>Reclamar ante la Agencia Española de Protección de Datos (aepd.es) si lo consideras necesario.</li>
    </ul>
    <p>Para ejercerlos, escribe al email indicado arriba.</p>

    <h2>Cookies</h2>
    <p>La web solo usa una cookie técnica de sesión para proteger el formulario frente a envíos automáticos. No hay cookies de analítica ni de publicidad, y las fuentes tipográficas se sirven desde el propio servidor.</p>

    <p style="margin-top:2.5em"><a class="btn btn--volt" style="background:var(--marino);color:#fff" href="index.php">Volver a la web</a></p>
</main>
</body>
</html>
