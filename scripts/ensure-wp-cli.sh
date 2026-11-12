#!/usr/bin/env bash
# Lando の /usr/local/bin ボリューム再作成後も WP-CLI が使えるようにする
set -euo pipefail

WP_BIN="/usr/local/bin/wp"
WP_URL="https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar"

if [[ -x "${WP_BIN}" ]]; then
  exit 0
fi

echo "==> WP-CLI が見つからないためインストールします..."
curl -fsSL -o "${WP_BIN}" "${WP_URL}"
chmod +x "${WP_BIN}"

if ! "${WP_BIN}" --info >/dev/null 2>&1; then
  echo "エラー: WP-CLI のインストールに失敗しました。" >&2
  exit 1
fi

echo "==> WP-CLI をインストールしました。"
