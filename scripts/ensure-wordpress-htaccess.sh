#!/usr/bin/env bash
# WordPress ルートに .htaccess が無いとパーマリンクが Apache 404 になる（Lando ローカル向け）
set -euo pipefail

WP_PATH="${1:-.}"
HT="${WP_PATH}/.htaccess"

if [[ ! -f "${HT}" ]]; then
  cat > "${HT}" <<'EOF'
# BEGIN WordPress
<IfModule mod_rewrite.c>
RewriteEngine On
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /index.php [L]
</IfModule>
# END WordPress
EOF
  echo "  - .htaccess を新規作成しました"
else
  echo "  - .htaccess は既に存在します"
fi

if command -v wp >/dev/null 2>&1; then
  wp --path="${WP_PATH}" rewrite flush >/dev/null 2>&1 || true
fi
