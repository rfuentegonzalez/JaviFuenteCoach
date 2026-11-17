# Web de Javier Fuente · Entrenador de fútbol base

Landing page en PHP (sin base de datos ni librerías externas). Funciona en cualquier hosting con PHP 8.1 o superior.

## Cómo publicarla

1. Contrata un hosting con PHP 8.1+ (cualquier plan básico vale) y un dominio, por ejemplo `javierfuente.es`.
2. Sube **todo el contenido** de esta carpeta a la carpeta pública del hosting (suele llamarse `public_html` o `www`), incluido el archivo oculto `.htaccess`. Lo más cómodo es dejar que GitHub lo haga solo: mira el apartado [Publicación automática](#publicación-automática).
3. Abre `config.php` y revisa:
   - `site_url`: el dominio final.
   - `contact_to`: el correo donde quieres recibir los mensajes.
   - `mail_from`: crea en el hosting un buzón del propio dominio (p. ej. `web@javierfuente.es`) y ponlo aquí. Si usas una dirección de Gmail como remitente, los mensajes acabarán en spam.
   - `public_phone`: está vacío a propósito (ver nota de privacidad).
   - `instagram` / `linkedin`: pega las URL cuando existan y aparecerán solas.
4. Activa el certificado SSL gratuito del hosting y quita la almohadilla de las 4 últimas líneas de `.htaccess` para forzar HTTPS.
5. Envía un mensaje de prueba desde el formulario.

## Publicación automática

Cada vez que se hace merge de un cambio en la rama `main`, GitHub sube sola la web al hosting por FTP. Solo envía los archivos que han cambiado, así que tarda poco. Antes de subir nada comprueba que los archivos PHP no tienen errores; si los tiene, no publica y la web sigue como estaba.

No se suben al servidor: este `LEEME.md` y cualquier otro `.md`, la carpeta `.github`, los archivos de Git (`.gitignore`…) ni un posible `CV-original`.

Mientras no estén puestos los datos del hosting, la publicación se salta sin dar error y aparece un aviso amarillo en la pestaña **Actions**.

### Paso 1. Apunta los datos FTP del hosting

Al contratar el hosting te llegará un correo de bienvenida, o los verás en su panel de control (cPanel, Plesk o similar) en un apartado llamado «FTP» o «Cuentas FTP». Necesitas:

- **Servidor FTP**: algo como `ftp.javierfuente.es` o `ftp.nombredelhosting.com`. Sin `ftp://` delante.
- **Usuario FTP**.
- **Contraseña FTP**. Si no la sabes, crea una cuenta FTP nueva desde el panel y apunta la contraseña.
- **Carpeta de la web**: la carpeta pública donde va la web, normalmente `public_html/` o `www/`. Si al entrar por FTP ya estás dentro de esa carpeta, no hace falta este dato.

Si dudas, escribe al soporte del hosting: «¿Qué servidor, usuario y carpeta tengo que usar para subir la web por FTP? ¿Admitís FTPS (FTP con TLS)?».

### Paso 2. Guárdalos en GitHub como «secrets»

Los secrets son datos privados que GitHub guarda cifrados: nadie los puede ver, ni siquiera en este repositorio público.

1. Entra en el repositorio en github.com.
2. Pulsa **Settings** (arriba a la derecha, el icono de la rueda).
3. En el menú de la izquierda: **Secrets and variables** > **Actions**.
4. Pulsa el botón verde **New repository secret**.
5. En **Name** escribe el nombre exacto de la tabla (en mayúsculas), en **Secret** pega el valor y pulsa **Add secret**.
6. Repite con cada uno.

| Name | Qué poner | ¿Obligatorio? |
|---|---|---|
| `FTP_SERVER` | El servidor FTP, p. ej. `ftp.javierfuente.es` | Sí |
| `FTP_USERNAME` | El usuario FTP | Sí |
| `FTP_PASSWORD` | La contraseña FTP | Sí |
| `FTP_SERVER_DIR` | La carpeta de la web **terminada en barra**, p. ej. `public_html/` | Solo si al entrar por FTP no estás ya dentro de la carpeta pública |
| `FTP_PROTOCOL` | `ftps` (por defecto, conexión cifrada), `ftps-legacy` o `ftp` | No. Ver «Si falla» |
| `FTP_PORT` | El puerto, si el hosting indica uno distinto de 21 | No |

Si te equivocas en un valor, vuelve a esa pantalla, pulsa el lápiz junto al secret y pégalo de nuevo (GitHub no deja ver el valor guardado, solo reemplazarlo).

### Paso 3. Haz la primera publicación

1. Ve a la pestaña **Actions** del repositorio.
2. A la izquierda, pulsa **Publicar la web**.
3. Pulsa **Run workflow** > **Run workflow** (botón verde).
4. Espera a que salga un círculo verde con un ✓. Abre la web en el navegador para comprobarlo.

A partir de ahí no hay que hacer nada: cada merge en `main` publica solo.

### Si falla

Si sale una cruz roja, pulsa sobre ella y luego en **Subir al hosting** para ver el error.

- **Error de inicio de sesión (`530`, `Login incorrect`)**: revisa `FTP_USERNAME` y `FTP_PASSWORD`. Algunos hostings piden el usuario completo, tipo `usuario@javierfuente.es`.
- **Error de conexión o de TLS/certificado (`ECONNREFUSED`, `timeout`, `certificate`)**: puede que el hosting no admita FTPS en el puerto 21. Prueba primero creando `FTP_PROTOCOL` con el valor `ftps-legacy` y `FTP_PORT` con `990`. Si tampoco, pon `FTP_PROTOCOL` = `ftp` y borra `FTP_PORT`. El FTP normal funciona, pero envía la contraseña sin cifrar: úsalo solo si el hosting no ofrece otra opción.
- **La web sale vacía o dentro de otra carpeta**: revisa `FTP_SERVER_DIR` (debe terminar en `/`).
- **Errores de PHP**: el paso «Comprobar que no hay errores de PHP» indica el archivo y la línea. Corrígelo y vuelve a hacer merge.

### Cosas a tener en cuenta

- En el servidor aparecerá un archivo `.ftp-deploy-sync-state.json`. Es el registro de lo que ya se ha subido: **no lo borres** (si se borra, la siguiente vez se vuelve a subir todo, sin más problema). El `.htaccess` impide que se vea desde fuera.
- Si cambias o borras un archivo **directamente en el hosting**, la publicación automática no se entera. Haz siempre los cambios en el repositorio.
- Los archivos que se borran del repositorio también se borran del servidor en la siguiente publicación.

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
.github/workflows/publicar-web.yml  Publicación automática por FTP
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
