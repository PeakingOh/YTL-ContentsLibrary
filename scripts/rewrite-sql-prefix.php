<?php
/**
 * UpdraftPlus ダンプのテーブル接頭辞を、ローカル WordPress の接頭辞に合わせる。
 *
 * 本番ダンプは接頭辞が wp（wpoptions）で、Lando の wp-config は wp_（wp_options）。
 * そのまま import すると WordPress が読まないテーブルへ入る。
 *
 * Usage:
 *   php rewrite-sql-prefix.php rewrite <src> <dest> <from> <to>
 *   php rewrite-sql-prefix.php old-names <src> <from> <to>
 */
if ( $argc < 5 ) {
	fwrite( STDERR, "Usage: php rewrite-sql-prefix.php rewrite|old-names ...\n" );
	exit( 1 );
}

$mode = $argv[1];
$from = $argv[ $mode === 'rewrite' ? 4 : 3 ];
$to   = $argv[ $mode === 'rewrite' ? 5 : 4 ];

if ( $from === '' || $to === '' || $from === $to ) {
	fwrite( STDERR, "接頭辞が空、または変換の必要がありません。\n" );
	exit( 1 );
}

/**
 * @return array<string, string> old table name => new table name
 */
function prefix_table_map( string $sql, string $from, string $to ): array {
	$map = array();
	if ( ! preg_match_all( '/`' . preg_quote( $from, '/' ) . '([A-Za-z0-9_]*)`/', $sql, $matches, PREG_SET_ORDER ) ) {
		return $map;
	}
	foreach ( $matches as $match ) {
		$old = $from . $match[1];
		if ( str_starts_with( $old, $to ) ) {
			continue;
		}
		$map[ $old ] = $to . $match[1];
	}
	return $map;
}

$sql = file_get_contents( $argv[2] );
if ( $sql === false ) {
	fwrite( STDERR, "SQL を読めません: {$argv[2]}\n" );
	exit( 1 );
}

$map = prefix_table_map( $sql, $from, $to );

if ( $mode === 'old-names' ) {
	foreach ( array_keys( $map ) as $old ) {
		echo $old, PHP_EOL;
	}
	exit( 0 );
}

if ( $mode !== 'rewrite' ) {
	fwrite( STDERR, "不明なモードです: {$mode}\n" );
	exit( 1 );
}

$rewritten = preg_replace_callback(
	'/`' . preg_quote( $from, '/' ) . '([A-Za-z0-9_]*)`/',
	static function ( array $match ) use ( $from, $to ): string {
		$old = $from . $match[1];
		if ( str_starts_with( $old, $to ) ) {
			return '`' . $old . '`';
		}
		return '`' . $to . $match[1] . '`';
	},
	$sql
);

if ( ! is_string( $rewritten ) || file_put_contents( $argv[3], $rewritten ) === false ) {
	fwrite( STDERR, "変換後の SQL を書けません。\n" );
	exit( 1 );
}

fwrite( STDERR, 'テーブル名を ' . count( $map ) . " 件変換しました。\n" );
exit( 0 );
