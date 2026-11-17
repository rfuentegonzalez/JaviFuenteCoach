# Web de Javier Fuente · Entrenador de fútbol base

Landing page en PHP (sin base de datos ni librerías externas). Funciona en cualquier hosting con PHP 8.1 o superior.

## Cómo publicarla

1. Contrata un hosting con PHP 8.1+ (cualquier plan básico vale) y un dominio, por ejemplo `javierfuente.es`.
2. Sube **todo el contenido** de esta carpeta a la carpeta pública del hosting (suele llamarse `public_html` o `www`), incluido el archivo oculto `.htaccess`.
3. Abre `config.php` y revisa:
   - `site_url`: el dominio final.
   - `contact_to`: el correo donde quieres recibir los mensajes.
   - `mail_from`: crea en el hosting un buzón del propio dominio (p. ej. `web@javierfuente.es`) y ponlo aquí. Si usas una dirección de Gmail como remitente, los mensajes acabarán en spam.
   - `public_phone`: está vacío a propósito (ver nota de privacidad).
   - `instagram` / `linkedin`: pega las URL cuando existan y aparecerán solas.
4. Activa el certificado SSL gratuito del hosting y quita la almohadilla de las 4 últimas líneas de `.htaccess` para forzar HTTPS.
5. Envía un mensaje de prueba desde el formulario.

## Cómo actualizar el contenido

Todo el texto de la web está en `includes/data.php`: temporadas, ideas, preguntas, fortalezas, licencias y formación. Para añadir la temporada que viene, copia un bloque de `seasons` y cambia los datos. La edad se calcula sola a partir de la fecha de nacimiento.

El botón «Descargar CV completo» enlaza a `assets/docs/CV-Javier-Fuente.pdf`. Es una versión pensada para publicarse: no incluye teléfono ni fecha de nacimiento. Para actualizarla, sustituye ese archivo manteniendo el nombre. No subas el CV original con el teléfono.

Para cambiar una foto, sustituye el archivo en `assets/img/` manteniendo el nombre (sube la versión `.webp` y la `.png`/`.jpg`).

## Estructura

```
index.php          Página principal
contacto.php       Recibe el formulario y envía el email
privacidad.php     Política de privacidad (obligatoria por el formulario)
config.php         Datos de contacto y ajustes
includes/data.php  Contenido del CV
includes/functions.php
assets/css, js, img, fonts, logo, docs
```

## Notas

- **Privacidad:** Javier es menor, así que la web no publica su teléfono ni muestra fotos de los niños de sus equipos. Antes de añadir fotos de partidos, asegúrate de que no se reconoce a ningún jugador o de que hay permiso de las familias y del club.
- **Escudos y camisetas:** las fotos muestran la equipación oficial del Rayo Vallecano, algo normal en un CV. Si en el futuro la web se usa para promocionar servicios propios (campus, clases particulares), conviene consultarlo con el club.
- **Fuentes:** Inter 4.1 (licencia SIL Open Font License, ver `assets/fonts/LICENSE-Inter.txt`) en formato `.woff2`, servida desde el propio servidor; no se carga nada de Google ni hay cookies de seguimiento.
- **Fecha de nacimiento:** este repositorio es público, así que `includes/data.php` solo guarda el mes y el año (julio de 2009). La edad se actualiza sola el 1 de julio.
- El formulario lleva protección anti-spam (campo trampa, token de sesión y límite de un envío por minuto).

## Recursos pendientes

Esta primera versión usa los archivos que había disponibles. Cuando estén, conviene sustituirlos:

- **Logos en SVG.** Faltan `jf-logo-horizontal-blanco.svg`, `jf-monograma-blanco.svg` y `favicon.svg`. Mientras tanto, la web usa las versiones PNG (`jf-logo-horizontal-blanco.png`, `jf-monograma-blanco.png`, recortado del logo horizontal, y `favicon.png`, sacado del avatar). Si llegan los SVG, cambia la extensión en `index.php` y `privacidad.php`.
- **Logo vertical y monograma sobre fondo claro** (`jf-logo-vertical`, `jf-logo-vertical-blanco`, `jf-monograma`): no los usa la web, pero no están en el repositorio.
- **Imagen para redes (`assets/img/og-image.jpg`):** provisional, es el logo horizontal blanco sobre fondo marino. Se puede sustituir por una pieza diseñada manteniendo el nombre (1200 × 630 px).
