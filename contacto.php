<?php
declare(strict_types=1);
require __DIR__ . '/includes/functions.php';
$cfg = require __DIR__ . '/config.php';

$wantsJson = str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');

function respond(bool $ok, string $code, string $message, bool $json): never
{
    if ($json) {
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'message' => $message], JSON_UNESCAPED_UNICODE);
    } else {
        header('Location: index.php?' . ($ok ? 'enviado=1' : 'error=' . urlencode($code)) . '#contacto', true, 303);
    }
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: index.php#contacto', true, 303);
    exit;
}

// 1. Token de la sesión (evita envíos desde otras webs)
if (!hash_equals($_SESSION['csrf'] ?? '', (string) ($_POST['csrf'] ?? ''))) {
    respond(false, 'token', 'La página ha caducado. Recarga e inténtalo otra vez.', $wantsJson);
}

// 2. Trampa para bots: si el campo oculto viene relleno, fingimos éxito y no enviamos nada
if (!empty($_POST['web'])) {
    respond(true, '', 'Mensaje enviado. Javier te responderá lo antes posible.', $wantsJson);
}

// 3. Límite: un mensaje cada 60 segundos por visitante
if (isset($_SESSION['last_sent']) && time() - $_SESSION['last_sent'] < 60) {
    respond(false, 'envio', 'Acabas de enviar un mensaje. Espera un minuto antes de mandar otro.', $wantsJson);
}

// 4. Validación
$clean = static fn(string $k, int $max): string =>
    mb_substr(trim(str_replace(["\r", "\n"], ' ', (string) ($_POST[$k] ?? ''))), 0, $max);

$nombre  = $clean('nombre', 80);
$club    = $clean('club', 120);
$email   = $clean('email', 120);
$mensaje = mb_substr(trim((string) ($_POST['mensaje'] ?? '')), 0, 3000);
$privacy = !empty($_POST['privacidad']);

if ($nombre === '' || $mensaje === '' || !$privacy || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    respond(false, 'campos', 'Revisa los campos: nombre, email válido, mensaje y la casilla de privacidad son obligatorios.', $wantsJson);
}

// 5. Envío
$subject = '=?UTF-8?B?' . base64_encode("Contacto web: {$nombre}" . ($club ? " ({$club})" : '')) . '?=';
$body = "Nuevo mensaje desde la web\n\n"
      . "Nombre: {$nombre}\n"
      . "Club o escuela: " . ($club ?: '—') . "\n"
      . "Email: {$email}\n"
      . "Fecha: " . date('d/m/Y H:i') . "\n\n"
      . "Mensaje:\n{$mensaje}\n";

$headers = implode("\r\n", [
    'MIME-Version: 1.0',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
    'From: Web Javier Fuente <' . $cfg['mail_from'] . '>',
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . PHP_VERSION,
]);

$ok = @mail($cfg['contact_to'], $subject, $body, $headers, '-f' . $cfg['mail_from']);

if (!$ok) {
    error_log('[contacto] mail() ha fallado');
    respond(false, 'envio', 'No se ha podido enviar ahora mismo. Prueba de nuevo o escribe directamente al email.', $wantsJson);
}

$_SESSION['last_sent'] = time();
respond(true, '', 'Mensaje enviado. Javier te responderá lo antes posible.', $wantsJson);
