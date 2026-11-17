#!/usr/bin/env bash
# Sube la web al hosting por FTP (o SFTP) con lftp.
#
# Solo envía lo que ha cambiado desde la última publicación: guarda en el
# servidor el commit publicado (.deploy-commit) y compara con git. Si ese
# archivo no existe (primera vez) o no se reconoce, sube toda la web.
#
# Variables (vienen de los secrets): FTP_SERVER, FTP_USERNAME, FTP_PASSWORD,
# FTP_SERVER_DIR, FTP_PROTOCOL (sftp | ftp), FTP_PORT.
set -euo pipefail

PROTOCOL="${FTP_PROTOCOL:-ftp}"
case "$PROTOCOL" in
  sftp) PORT="${FTP_PORT:-22}" ;;
  ftp)  PORT="${FTP_PORT:-21}" ;;
  *) echo "::error::FTP_PROTOCOL debe ser sftp o ftp (ahora vale «$PROTOCOL»)."; exit 1 ;;
esac
REMOTE_DIR="${FTP_SERVER_DIR:-}"
REMOTE_DIR="${REMOTE_DIR%/}"
STATE_FILE=".deploy-commit"
export LFTP_PASSWORD="$FTP_PASSWORD"

# Archivos que nunca se suben al servidor
excluido() {
  case "$1" in
    .git*|*/.git*|.github/*|*.md|*.DS_Store|*Thumbs.db|CV-original*|*/CV-original*) return 0 ;;
  esac
  return 1
}

# Ejecuta órdenes de lftp ya conectado y dentro de la carpeta de la web.
# Cada orden que no debe fallar lleva «|| exit 1» para cortar la subida.
lftp_run() {
  {
    echo "set net:max-retries 3"
    echo "set net:reconnect-interval-base 5"
    echo "set net:timeout 30"
    echo "set sftp:auto-confirm yes"
    echo "set ftp:ssl-allow no"
    echo "set ftp:passive-mode yes"
    echo "set ftp:prefer-epsv no"
    echo "open --env-password -u \"$FTP_USERNAME\" -p $PORT $PROTOCOL://$FTP_SERVER"
    if [ -n "$REMOTE_DIR" ]; then echo "cd \"$REMOTE_DIR\" || exit 1"; fi
    cat
  } > "$RUNNER_TEMP/lftp-cmds"
  lftp -f "$RUNNER_TEMP/lftp-cmds" < /dev/null
}

echo "Conectando a $FTP_SERVER por $PROTOCOL (puerto $PORT)…"
ANTERIOR="$(echo "cat $STATE_FILE" | lftp_run 2>/dev/null | tr -dc '0-9a-f' || true)"
ACTUAL="$(git rev-parse HEAD)"

SUBIR=()
BORRAR=()
if [ -n "$ANTERIOR" ] && git cat-file -e "$ANTERIOR^{commit}" 2>/dev/null \
   && git merge-base --is-ancestor "$ANTERIOR" "$ACTUAL"; then
  if [ "$ANTERIOR" = "$ACTUAL" ]; then
    echo "El servidor ya tiene esta versión. Nada que subir."
    exit 0
  fi
  echo "Última versión publicada: ${ANTERIOR:0:7}. Subo solo los cambios."
  while IFS=$'\t' read -r estado ruta; do
    excluido "$ruta" && continue
    case "$estado" in
      D) BORRAR+=("$ruta") ;;
      *) SUBIR+=("$ruta") ;;
    esac
  done < <(git diff --name-status --no-renames "$ANTERIOR" "$ACTUAL")
else
  echo "Primera publicación (o versión anterior desconocida): subo toda la web."
  while IFS= read -r ruta; do
    excluido "$ruta" || SUBIR+=("$ruta")
  done < <(git ls-files)
fi

echo "Archivos a subir: ${#SUBIR[@]} · a borrar: ${#BORRAR[@]}"

{
  declare -A CARPETAS=()
  for f in "${SUBIR[@]}"; do
    d="$(dirname "$f")"
    if [ "$d" != "." ] && [ -z "${CARPETAS[$d]:-}" ]; then
      echo "mkdir -p -f \"$d\""
      CARPETAS[$d]=1
    fi
    echo "echo \"Subiendo: $f\""
    echo "put -O \"$d\" \"$f\" || exit 1"
  done
  for f in "${BORRAR[@]}"; do
    echo "echo \"Borrando: $f\""
    echo "rm -f \"$f\""
  done
  echo "$ACTUAL" > "$RUNNER_TEMP/$STATE_FILE"
  echo "put -O . \"$RUNNER_TEMP/$STATE_FILE\" || exit 1"
} | lftp_run

echo "Web publicada (versión ${ACTUAL:0:7})."
