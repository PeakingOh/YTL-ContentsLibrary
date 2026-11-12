#!/usr/bin/env bash
# database/latest.sql をステージング WordPress へインポートし、URL を置換する。
# Lando: lando sync-staging（appserver 上で実行。秘密鍵は /user/.ssh を参照）
#
# ホスト・ポート・パスは SSH ログイン後のホームからの相対パス。
# ユーザー名は .lando.local.yml で指定する（GitHub Secrets の STG_SSH_USER / PRD_SSH_USER と同じ値）。

set -euo pipefail

ROOT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
SQL_FILE="${ROOT_DIR}/database/latest.sql"

STG_SSH_USER="${STG_SSH_USER:-}"
STG_SSH_HOST="${STG_SSH_HOST:-peakingoh002.xsrv.jp}"
STG_SSH_PORT="${STG_SSH_PORT:-10022}"
STG_WP_PATH="${STG_WP_PATH:-peakingoh-dev.com/public_html/ytl-contentslibrary}"
STG_SSH_IDENTITY="${STG_SSH_IDENTITY:-}"
STG_URL="${STG_URL:-https://ytl-contentslibrary.peakingoh-dev.com}"

PROD_SSH_USER="${PROD_SSH_USER:-}"
PROD_SSH_HOST="${PROD_SSH_HOST:-www339.conoha.ne.jp}"
PROD_SSH_PORT="${PROD_SSH_PORT:-8022}"
PROD_WP_PATH="${PROD_WP_PATH:-public_html/contentslibrary.ytl.jp}"
PROD_SSH_IDENTITY="${PROD_SSH_IDENTITY:-${STG_SSH_IDENTITY}}"

PROD_URL_HTTPS="https://contentslibrary.ytl.jp"
PROD_URL_HTTP="http://contentslibrary.ytl.jp"

REMOTE_SQL='ytl-contentslibrary-latest.sql'

require_value() {
  local name="$1"
  local value="$2"
  if [[ -z "${value}" || "${value}" == "CHANGE_ME" || "${value}" == *"STAGING_HOST_TODO"* ]]; then
    echo "エラー: ${name} が未設定です。" >&2
    echo "  .lando.local.yml.example を参考に .lando.local.yml を作成し、CHANGE_ME を実値に置き換えてください。" >&2
    exit 1
  fi
}

require_value STG_SSH_USER "${STG_SSH_USER}"
require_value STG_SSH_HOST "${STG_SSH_HOST}"
require_value STG_SSH_PORT "${STG_SSH_PORT}"
require_value STG_WP_PATH "${STG_WP_PATH}"
require_value STG_URL "${STG_URL}"
require_value PROD_SSH_USER "${PROD_SSH_USER}"
require_value PROD_SSH_HOST "${PROD_SSH_HOST}"
require_value PROD_SSH_PORT "${PROD_SSH_PORT}"
require_value PROD_WP_PATH "${PROD_WP_PATH}"

if [[ "${PROD_WP_PATH}" == *" "* || "${STG_WP_PATH}" == *" "* ]]; then
  echo "エラー: PROD_WP_PATH と STG_WP_PATH に空白は使えません。" >&2
  exit 1
fi

if [[ ! -f "${SQL_FILE}" ]]; then
  echo "エラー: ${SQL_FILE} が存在しません。database/latest.sql を配置してください。" >&2
  exit 1
fi

SSH_TARGET="${STG_SSH_USER}@${STG_SSH_HOST}"
SSH_OPTS=(
  -p "${STG_SSH_PORT}"
  -o BatchMode=yes
  -o IdentitiesOnly=yes
  -o ConnectTimeout=30
  -o StrictHostKeyChecking=accept-new
)
SCP_OPTS=(
  -P "${STG_SSH_PORT}"
  -o BatchMode=yes
  -o IdentitiesOnly=yes
  -o ConnectTimeout=30
  -o StrictHostKeyChecking=accept-new
)
append_identity() {
  local identity="$1"
  local -n opts_ref="$2"
  if [[ -z "${identity}" ]]; then
    return
  fi
  if [[ ! -f "${identity}" ]]; then
    echo "エラー: SSH 秘密鍵が見つかりません: ${identity}" >&2
    exit 1
  fi
  opts_ref+=(-i "${identity}")
}

append_identity "${STG_SSH_IDENTITY}" SSH_OPTS
append_identity "${STG_SSH_IDENTITY}" SCP_OPTS

PROD_TARGET="${PROD_SSH_USER}@${PROD_SSH_HOST}"
PROD_SSH_OPTS=(
  -p "${PROD_SSH_PORT}"
  -o BatchMode=yes
  -o IdentitiesOnly=yes
  -o ConnectTimeout=30
  -o StrictHostKeyChecking=accept-new
)
append_identity "${PROD_SSH_IDENTITY}" PROD_SSH_OPTS

echo "==> 本番のプラグインディレクトリを確認します..."
ssh "${PROD_SSH_OPTS[@]}" "${PROD_TARGET}" "test -d ${PROD_WP_PATH}/wp-content/plugins"

DUMP_PREFIX="$(grep -m1 '^# Table prefix:' "${SQL_FILE}" | sed 's/^# Table prefix: //' | tr -d '\r')"
STG_PREFIX="$(ssh "${SSH_OPTS[@]}" "${SSH_TARGET}" "wp --path=${STG_WP_PATH} config get table_prefix" | tr -d '\r')"
UPLOAD_SQL="${SQL_FILE}"
OLD_TABLES=""

if [[ -n "${DUMP_PREFIX}" && -n "${STG_PREFIX}" && "${DUMP_PREFIX}" != "${STG_PREFIX}" ]]; then
  echo "==> ダンプのテーブル接頭辞 ${DUMP_PREFIX} を ${STG_PREFIX} に変換します..."
  UPLOAD_SQL="$(mktemp /tmp/ytl-contentslibrary-staging-import.XXXXXX.sql)"
  OLD_TABLES="$(mktemp /tmp/ytl-contentslibrary-staging-old-tables.XXXXXX)"
  php "${ROOT_DIR}/scripts/rewrite-sql-prefix.php" rewrite "${SQL_FILE}" "${UPLOAD_SQL}" "${DUMP_PREFIX}" "${STG_PREFIX}"
  php "${ROOT_DIR}/scripts/rewrite-sql-prefix.php" old-names "${SQL_FILE}" "${DUMP_PREFIX}" "${STG_PREFIX}" > "${OLD_TABLES}"
fi

echo "==> ステージングへ SQL を転送します (${SSH_TARGET})..."
scp "${SCP_OPTS[@]}" "${UPLOAD_SQL}" "${SSH_TARGET}:${REMOTE_SQL}"

echo "==> ステージング DB へインポートし、URL を置換します..."
ssh "${SSH_OPTS[@]}" "${SSH_TARGET}" bash -s -- \
  "${STG_WP_PATH}" \
  "${REMOTE_SQL}" \
  "${PROD_URL_HTTPS}" \
  "${PROD_URL_HTTP}" \
  "${STG_URL}" <<'REMOTE'
set -euo pipefail
WP_PATH="$1"
SQL_PATH="$2"
FROM_HTTPS="$3"
FROM_HTTP="$4"
TO_URL="$5"

SQL_FULL="${HOME}/${SQL_PATH}"
wp --path="${WP_PATH}" db import "${SQL_FULL}"
wp --path="${WP_PATH}" search-replace "${FROM_HTTPS}" "${TO_URL}" --skip-columns=guid
wp --path="${WP_PATH}" search-replace "${FROM_HTTP}" "${TO_URL}" --skip-columns=guid
wp --path="${WP_PATH}" rewrite flush --hard
rm -f "${SQL_FULL}"
REMOTE

if [[ -n "${OLD_TABLES}" && -s "${OLD_TABLES}" ]]; then
  echo "==> 接頭辞の合わない旧テーブルを削除します..."
  OLD_TABLE_LIST="$(paste -sd ' ' "${OLD_TABLES}")"
  ssh "${SSH_OPTS[@]}" "${SSH_TARGET}" bash -s -- "${STG_WP_PATH}" "${OLD_TABLE_LIST}" <<'REMOTE'
set -euo pipefail
WP_PATH="$1"
for table in $2; do
  wp --path="${WP_PATH}" db query "DROP TABLE IF EXISTS \`${table}\`"
done
REMOTE
fi

if [[ -n "${OLD_TABLES}" ]]; then
  rm -f "${OLD_TABLES}"
fi
if [[ "${UPLOAD_SQL}" != "${SQL_FILE}" ]]; then
  rm -f "${UPLOAD_SQL}"
fi

echo "==> 本番のプラグインファイルをステージングへコピーします..."
ssh "${PROD_SSH_OPTS[@]}" "${PROD_TARGET}" \
  tar -C "${PROD_WP_PATH}/wp-content" -cf - plugins \
  | ssh "${SSH_OPTS[@]}" "${SSH_TARGET}" \
    "rm -rf ${STG_WP_PATH}/wp-content/plugins && mkdir -p ${STG_WP_PATH}/wp-content && tar -C ${STG_WP_PATH}/wp-content -xf -"

echo "==> テーマディレクトリを確認します..."
# 本番 DB の stylesheet は ytl-archive。ステージングへのデプロイ先は contentslibrary。
# 欠けると白画面になるため、必要ならシンボリックリンクを張る。
THEME_CHECK="$(ssh "${SSH_OPTS[@]}" "${SSH_TARGET}" bash -s -- "${STG_WP_PATH}" <<'REMOTE'
set -euo pipefail
WP_PATH="$1"
THEMES="${WP_PATH}/wp-content/themes"
PROD_SLUG="ytl-archive"
STG_SLUG="contentslibrary"

if [ -e "${THEMES}/${PROD_SLUG}" ]; then
  echo "ok"
  exit 0
fi

if [ -d "${THEMES}/${STG_SLUG}" ]; then
  ln -s "${STG_SLUG}" "${THEMES}/${PROD_SLUG}"
  echo "linked"
  exit 0
fi

echo "missing"
REMOTE
)"

case "${THEME_CHECK}" in
  ok) echo "  - テーマ ytl-archive: OK" ;;
  linked) echo "  - テーマ ytl-archive -> contentslibrary のリンクを作成しました" ;;
  missing)
    echo "警告: wp-content/themes/ytl-archive も contentslibrary もありません。develop へデプロイしてください。" >&2
    ;;
esac

echo "==> SiteGuard ログイン改名の .htaccess を同期します..."
SG_FIX="$(ssh "${SSH_OPTS[@]}" "${SSH_TARGET}" bash -s -- "${STG_WP_PATH}" <<'REMOTE'
set -euo pipefail
WP_PATH="$1"
HT="${WP_PATH}/.htaccess"
if [ ! -f "${HT}" ]; then
  echo "no_htaccess"
  exit 0
fi
if ! grep -q 'SITEGUARD_RENAME_LOGIN_SETTINGS' "${HT}"; then
  echo "no_block"
  exit 0
fi
wp --path="${WP_PATH}" eval '
$ht = ABSPATH . ".htaccess";
$c = get_option("siteguard_config");
if (!is_array($c) || (($c["renamelogin_enable"] ?? "0") !== "1")) {
  echo "disabled";
} else {
  $path = isset($c["renamelogin_path"]) ? (string) $c["renamelogin_path"] : "";
  if (!preg_match("/^[A-Za-z0-9_-]+$/", $path)) {
    echo "invalid_path";
  } else {
    $text = file_get_contents($ht);
    if (false === $text) {
      echo "read_failed";
    } elseif (preg_match("/RewriteRule \\^" . preg_quote($path, "/") . "\\(\\.\*\\)\\$ wp-login\\.php/", $text)) {
      echo "ok";
    } else {
      $new = preg_replace(
        "/(RewriteRule \\^)[A-Za-z0-9_-]+(\\(\\.\*\\)\\$ wp-login\\.php)/",
        "\${1}" . $path . "$2",
        $text,
        1,
        $count
      );
      if ($count !== 1 || false === file_put_contents($ht, $new)) {
        echo "replace_failed";
      } else {
        echo "fixed:" . $path;
      }
    }
  }
}
'
REMOTE
)"
SG_FIX="$(printf '%s' "${SG_FIX}" | tr -d '\r' | tail -n 1)"

case "${SG_FIX}" in
  ok) echo "  - SiteGuard RewriteRule: OK" ;;
  fixed:*) echo "  - SiteGuard ログインパスを ${SG_FIX#fixed:} に合わせました" ;;
  disabled) echo "  - SiteGuard ログイン改名は無効（スキップ）" ;;
  no_htaccess|no_block) echo "  - SiteGuard .htaccess ブロックなし（スキップ）" ;;
  *) echo "警告: SiteGuard .htaccess の同期に失敗しました (${SG_FIX})" >&2 ;;
esac

echo "==> sync-staging 完了しました。"
