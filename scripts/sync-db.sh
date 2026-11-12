#!/usr/bin/env bash
# database/latest.sql をローカル WordPress に取り込み、URL と有効プラグインを同期する
set -euo pipefail

bash /app/scripts/ensure-wp-cli.sh

SQL_FILE="/app/database/latest.sql"
if [[ ! -f "${SQL_FILE}" ]]; then
  echo "エラー: ${SQL_FILE} が存在しません。database/latest.sql を配置してください。"
  exit 1
fi

LOCAL_URL="https://ytl-contentslibrary.lndo.site"

choose_plugin_mode() {
  if [[ -n "${SYNC_PLUGINS:-}" ]]; then
    case "${SYNC_PLUGINS}" in
      production|keep) printf '%s\n' "${SYNC_PLUGINS}"; return ;;
      *)
        echo "エラー: SYNC_PLUGINS は production または keep を指定してください。" >&2
        exit 1
        ;;
    esac
  fi
  if [[ ! -r /dev/tty ]]; then
    echo "エラー: 確認用の入力ができません。端末で lando sync-db を実行するか、SYNC_PLUGINS=production または keep を指定してください。" >&2
    exit 1
  fi
  cat > /dev/tty <<'EOF'

プラグインファイルの扱いを選んでください。
投稿データとプラグイン設定は、どちらを選んでもダンプで上書きします。

  1) 本番ダンプで有効なプラグインに合わせる
     足りないものは WordPress.org から入れ、ダンプに無いものは削除します
  2) この開発環境に入っているプラグインを維持する
     ファイルの追加・削除はしません。有効・無効も今のまま残します

EOF
  local choice
  while true; do
    read -r -p "選択 [1/2]: " choice < /dev/tty
    case "${choice}" in
      1) printf '%s\n' production; return ;;
      2) printf '%s\n' keep; return ;;
      *) echo "1 または 2 を入力してください。" > /dev/tty ;;
    esac
  done
}

echo "現在有効なプラグイン:"
if ! wp plugin list --status=active --field=name 2>/dev/null; then
  echo "  （まだデータベースがありません）"
fi

PLUGIN_MODE="$(choose_plugin_mode)"
echo "==> プラグインの扱い: ${PLUGIN_MODE}"

ACTIVE_PLUGINS_FILE="$(mktemp /tmp/ytl-contentslibrary-active-plugins.XXXXXX.json)"
if ! wp option get active_plugins --format=json > "${ACTIVE_PLUGINS_FILE}" 2>/dev/null || [[ ! -s "${ACTIVE_PLUGINS_FILE}" ]]; then
  echo '[]' > "${ACTIVE_PLUGINS_FILE}"
fi

IMPORT_SQL="${SQL_FILE}"
DUMP_PREFIX="$(grep -m1 '^# Table prefix:' "${SQL_FILE}" | sed 's/^# Table prefix: //' | tr -d '\r')"
LOCAL_PREFIX="$(wp config get table_prefix)"
OLD_TABLES=""

if [[ -n "${DUMP_PREFIX}" && "${DUMP_PREFIX}" != "${LOCAL_PREFIX}" ]]; then
  echo "==> ダンプのテーブル接頭辞 ${DUMP_PREFIX} を ${LOCAL_PREFIX} に変換します..."
  IMPORT_SQL="$(mktemp /tmp/ytl-contentslibrary-import.XXXXXX.sql)"
  OLD_TABLES="$(mktemp /tmp/ytl-contentslibrary-old-tables.XXXXXX)"
  php /app/scripts/rewrite-sql-prefix.php rewrite "${SQL_FILE}" "${IMPORT_SQL}" "${DUMP_PREFIX}" "${LOCAL_PREFIX}"
  php /app/scripts/rewrite-sql-prefix.php old-names "${SQL_FILE}" "${DUMP_PREFIX}" "${LOCAL_PREFIX}" > "${OLD_TABLES}"
fi

echo "==> WordPress データベースへインポートします..."
wp db import "${IMPORT_SQL}"

if [[ -n "${OLD_TABLES}" && -s "${OLD_TABLES}" ]]; then
  echo "==> 接頭辞の合わない旧テーブルを削除します..."
  while IFS= read -r table; do
    [[ -z "${table}" ]] && continue
    wp db query "DROP TABLE IF EXISTS \`${table}\`"
  done < "${OLD_TABLES}"
fi

if [[ -n "${OLD_TABLES}" ]]; then
  rm -f "${OLD_TABLES}"
fi
if [[ "${IMPORT_SQL}" != "${SQL_FILE}" ]]; then
  rm -f "${IMPORT_SQL}"
fi

echo "==> URL をローカルに置換します..."
wp search-replace "https://contentslibrary.ytl.jp" "${LOCAL_URL}" --skip-columns=guid
wp search-replace "http://contentslibrary.ytl.jp" "${LOCAL_URL}" --skip-columns=guid
wp search-replace "https://ytl-contentslibrary.peakingoh-dev.com" "${LOCAL_URL}" --skip-columns=guid
wp search-replace "http://ytl-contentslibrary.peakingoh-dev.com" "${LOCAL_URL}" --skip-columns=guid

echo "==> パーマリンク用 .htaccess を確認します..."
bash /app/scripts/ensure-wordpress-htaccess.sh /app/wordpress

if [[ "${PLUGIN_MODE}" == "keep" ]]; then
  echo "==> プラグインファイルは変更しません。有効化状態を取り込み前のまま戻します..."
  ACTIVE_PLUGINS_FILE="${ACTIVE_PLUGINS_FILE}" wp eval '
    $path = getenv("ACTIVE_PLUGINS_FILE");
    $plugins = json_decode((string) file_get_contents($path), true);
    if (!is_array($plugins)) {
      fwrite(STDERR, "有効プラグイン一覧を復元できません。\n");
      exit(1);
    }
    update_option("active_plugins", $plugins);
    echo "  - 有効プラグイン " . count($plugins) . " 件を維持しました\n";
  '
else
  echo "==> 本番ダンプの有効プラグインに合わせます..."
  plugins="$(wp eval 'foreach ((array) get_option("active_plugins") as $p) { echo dirname($p), PHP_EOL; }')"
  wanted="$(mktemp /tmp/ytl-contentslibrary-wanted-plugins.XXXXXX)"
  if [[ -n "${plugins}" ]]; then
    while IFS= read -r plugin; do
      [[ -z "${plugin}" || "${plugin}" == "." ]] && continue
      printf '%s\n' "${plugin}" >> "${wanted}"
      if wp plugin is-installed "${plugin}" >/dev/null 2>&1; then
        echo "  - ${plugin}: 既にインストール済み、アクティブ化のみ確認"
        wp plugin activate "${plugin}" >/dev/null 2>&1 || true
      else
        echo "  - ${plugin}: インストールしてアクティブ化します..."
        if ! wp plugin install "${plugin}" --activate; then
          echo "    ! ${plugin} のインストールに失敗しました（有料/カスタムプラグインの可能性）。" >&2
        fi
      fi
    done <<< "${plugins}"
  fi

  echo "==> ダンプに無いプラグインを削除します..."
  while IFS= read -r installed; do
    [[ -z "${installed}" ]] && continue
    if grep -Fxq "${installed}" "${wanted}"; then
      continue
    fi
    echo "  - ${installed}: 削除します"
    wp plugin deactivate "${installed}" >/dev/null 2>&1 || true
    wp plugin uninstall "${installed}" --deactivate
  done < <(wp plugin list --field=name)
  rm -f "${wanted}"
fi

rm -f "${ACTIVE_PLUGINS_FILE}"

echo "==> sync-db 完了しました。"
