<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_set_cookie_params([
        'httponly' => true,
        'samesite' => 'Lax',
        'secure'   => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    ]);
    session_start();
}

/** Escapa texto para HTML. */
function e(string|int|float|null $v): string
{
    return htmlspecialchars((string) $v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Token anti-CSRF para el formulario. */
function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

/** Ruta de un recurso con versión según la fecha de modificación (evita cachés viejas). */
function asset(string $path): string
{
    $file = __DIR__ . '/../' . $path;
    $v = is_file($file) ? filemtime($file) : time();
    return $path . '?v=' . $v;
}

/** <picture> con WebP y PNG/JPG de respaldo. */
function picture(string $name, string $fallbackExt, string $alt, string $class = '', string $loading = 'lazy', array $size = []): string
{
    $dims = $size ? sprintf(' width="%d" height="%d"', $size[0], $size[1]) : '';
    return sprintf(
        '<picture class="%s"><source srcset="%s" type="image/webp"><img src="%s" alt="%s" loading="%s" decoding="async"%s></picture>',
        e($class),
        e(asset("assets/img/{$name}.webp")),
        e(asset("assets/img/{$name}.{$fallbackExt}")),
        e($alt),
        e($loading),
        $dims
    );
}

/** Logo inline (SVG) para poder colorearlo con CSS. */
function inline_svg(string $file): string
{
    $path = __DIR__ . '/../assets/logo/' . basename($file);
    return is_file($path) ? (string) file_get_contents($path) : '';
}

/** Nombre de la portada letra a letra (para la animación de entrada). Cada letra lleva su orden en --i. */
function hero_letters(string $word, int $start = 0): string
{
    $out = '';
    foreach (mb_str_split($word) as $n => $ch) {
        $out .= sprintf('<span class="hero__ch" style="--i:%d">%s</span>', $start + $n, e($ch));
    }
    return $out;
}
