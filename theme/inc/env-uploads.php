<?php
/**
 * ローカル / ステージング向けの環境判定と、本番 uploads 参照
 *
 * ローカル・ステージングには wp-content/uploads を同期しない。
 * メディア URL を本番へ差し替え、画像・PDF などを本番サーバー上のファイルとして表示する。
 */

/**
 * ローカル（Lando）のサイト URL
 */
function site_local_site_url(): string {
	return 'https://ytl-contentslibrary.lndo.site';
}

/**
 * ステージングの公開ホスト
 */
function site_staging_host(): string {
	return 'ytl-contentslibrary.peakingoh-dev.com';
}

/**
 * リクエストのホスト名（home_url 等は wp_upload_dir 経由で再帰するため使わない）
 */
function site_request_host(): string {
	if ( ! empty( $_SERVER['HTTP_HOST'] ) ) {
		return strtolower( (string) wp_unslash( $_SERVER['HTTP_HOST'] ) );
	}
	return '';
}

/**
 * ローカル開発環境か（Lando 定数 / 環境変数、または lndo.site ホスト）
 */
function site_is_local_dev(): bool {
	if ( defined( 'LANDO' ) && LANDO ) {
		return true;
	}
	if ( getenv( 'LANDO' ) ) {
		return true;
	}
	$host = site_request_host();
	return $host !== '' && str_ends_with( $host, 'lndo.site' );
}

/**
 * ステージング環境か
 */
function site_is_staging(): bool {
	$host         = site_request_host();
	$staging_host = site_staging_host();
	return $staging_host !== '' && $host === $staging_host;
}

/**
 * Lando 上で siteurl / home をローカル URL に上書きするか
 */
function site_override_local_site_url(): bool {
	return site_is_local_dev();
}

add_filter(
	'pre_option_siteurl',
	function ( $pre ) {
		if ( site_override_local_site_url() ) {
			return site_local_site_url();
		}
		return $pre;
	}
);

add_filter(
	'pre_option_home',
	function ( $pre ) {
		if ( site_override_local_site_url() ) {
			return site_local_site_url();
		}
		return $pre;
	}
);

/**
 * 本番メディア（uploads）のベース URL
 */
function site_production_uploads_url(): string {
	return 'https://contentslibrary.ytl.jp/wp-content/uploads';
}

/**
 * ローカル（Lando）・ステージングで uploads 未同期時に本番メディアを参照するか
 */
function site_use_production_uploads(): bool {
	static $cached = null;
	if ( $cached !== null ) {
		return $cached;
	}
	$cached = site_is_local_dev() || site_is_staging();
	return $cached;
}

/**
 * 置換元になり得る uploads ベース URL 一覧（本番自身は含めない）
 *
 * @return string[]
 */
function site_uploads_url_sources(): array {
	$to = untrailingslashit( site_production_uploads_url() );
	$candidates = array(
		untrailingslashit( content_url( 'uploads' ) ),
		untrailingslashit( home_url( '/wp-content/uploads' ) ),
		'http://ytl-contentslibrary.peakingoh-dev.com/wp-content/uploads',
		'https://ytl-contentslibrary.peakingoh-dev.com/wp-content/uploads',
		'https://ytl-contentslibrary.lndo.site/wp-content/uploads',
		'http://ytl-contentslibrary.lndo.site/wp-content/uploads',
	);
	$sources = array();
	foreach ( $candidates as $from ) {
		$from = untrailingslashit( (string) $from );
		if ( $from === '' || $from === $to ) {
			continue;
		}
		$sources[] = $from;
	}
	return array_values( array_unique( $sources ) );
}

/**
 * 単一 URL の uploads 部分を本番へ差し替え
 *
 * @param mixed $url
 * @return mixed
 */
function site_rewrite_uploads_url( $url ) {
	if ( ! site_use_production_uploads() || ! is_string( $url ) || $url === '' ) {
		return $url;
	}
	$to = untrailingslashit( site_production_uploads_url() );
	if ( str_starts_with( $url, $to ) ) {
		return $url;
	}
	foreach ( site_uploads_url_sources() as $from ) {
		if ( str_starts_with( $url, $from ) ) {
			return $to . substr( $url, strlen( $from ) );
		}
	}
	return $url;
}

add_filter(
	'pre_option_upload_url_path',
	function ( $upload_url_path ) {
		if ( site_use_production_uploads() ) {
			return site_production_uploads_url();
		}
		return $upload_url_path;
	}
);

add_filter(
	'upload_dir',
	function ( $dirs ) {
		static $rewriting = false;
		if ( $rewriting || ! site_use_production_uploads() ) {
			return $dirs;
		}
		$rewriting       = true;
		$baseurl         = untrailingslashit( site_production_uploads_url() );
		$subdir          = $dirs['subdir'] ?? '';
		$dirs['baseurl'] = $baseurl;
		$dirs['url']     = $baseurl . $subdir;
		$rewriting       = false;
		return $dirs;
	}
);

add_filter( 'wp_get_attachment_url', 'site_rewrite_uploads_url' );

add_filter(
	'wp_calculate_image_srcset',
	function ( $sources ) {
		if ( ! site_use_production_uploads() || ! is_array( $sources ) ) {
			return $sources;
		}
		foreach ( $sources as $width => $source ) {
			if ( isset( $source['url'] ) ) {
				$sources[ $width ]['url'] = site_rewrite_uploads_url( $source['url'] );
			}
		}
		return $sources;
	},
	10,
	1
);

/**
 * 投稿本文内の uploads URL を本番向けに差し替え
 */
add_filter(
	'the_content',
	function ( $content ) {
		if ( ! site_use_production_uploads() || ! is_string( $content ) || $content === '' ) {
			return $content;
		}
		$to = untrailingslashit( site_production_uploads_url() );
		foreach ( site_uploads_url_sources() as $from ) {
			$content = str_replace( array( $from . '/', $from ), array( $to . '/', $to ), $content );
		}
		// ルート相対パス（属性値の先頭のみ）
		$content = preg_replace( '#([\'"])/wp-content/uploads#', '$1' . $to, $content ) ?? $content;
		return $content;
	},
	20
);

/**
 * ローカルでは Autoptimize のキャッシュ CSS が欠けるため無効化
 */
add_action(
	'plugins_loaded',
	function () {
		if ( ! site_is_local_dev() ) {
			return;
		}
		add_filter( 'autoptimize_filter_noptimize', '__return_true' );
	},
	1
);
