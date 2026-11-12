<?php
/**
 * テーマアセットの URL ヘルパー
 */

/**
 * CI が生成するアセットマニフェスト（内容ハッシュ）を読み込む
 *
 * @return array<string, array{hash?: string, size?: int}>
 */
function site_get_asset_manifest(): array {
	static $manifest = null;

	if ( $manifest !== null ) {
		return $manifest;
	}

	$manifest = array();
	$path     = get_template_directory() . '/assets/manifest/asset-manifest.json';

	if ( is_readable( $path ) ) {
		$data = json_decode( (string) file_get_contents( $path ), true );
		if ( is_array( $data ) ) {
			$manifest = $data;
		}
	}

	return $manifest;
}

/**
 * テーマ内アセットの URL（キャッシュバスティング用の ver を付与）
 *
 * マニフェストの内容ハッシュを優先し、無い場合やサイズが一致しない場合は更新時刻を使う。
 *
 * @param string $relative_path テーマルートからの相対パス（例: assets/css/styles.css）
 */
function site_get_asset_uri( string $relative_path ): string {
	$relative_path = ltrim( $relative_path, '/' );
	$path          = get_template_directory() . '/' . $relative_path;
	$uri           = get_template_directory_uri() . '/' . $relative_path;

	if ( ! file_exists( $path ) ) {
		return $uri;
	}

	$entry = site_get_asset_manifest()[ $relative_path ] ?? null;

	if (
		is_array( $entry )
		&& ! empty( $entry['hash'] )
		&& isset( $entry['size'] )
		&& (int) $entry['size'] === filesize( $path )
	) {
		return add_query_arg( 'ver', (string) $entry['hash'], $uri );
	}

	return add_query_arg( 'ver', (string) filemtime( $path ), $uri );
}
