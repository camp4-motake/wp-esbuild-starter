<?php

namespace Lib\Assets;

/**
 * テーマアセットキュー
 *
 * @return void
 */
function enqueue_vite_assets() {
	$manifest_path = get_theme_file_path( 'dist/.vite/manifest.main.json' );
	$is_dev        = wp_get_environment_type() === 'local' && file_exists( get_theme_file_path( 'dist/.dev' ) );

	if ( $is_dev ) :
		wp_enqueue_script( 'vite', 'http://localhost:5173/@vite/client', array(), null, false );
		wp_enqueue_script( THEME_DOMAIN, 'http://localhost:5173/src/main.ts', array(), null, false );

	elseif ( file_exists( $manifest_path ) ) :

		$manifest = json_decode( wp_remote_get( esc_url_raw( $manifest_path ), array() ), true );
		$styles   = $manifest['src/main.ts']['css'];

		foreach ( $styles as $i => $css ) {
			wp_enqueue_style( str_replace( '.css', '', $css ), get_theme_file_uri( 'dist/' . $css ), array(), null, false );
		}
		wp_enqueue_script( THEME_DOMAIN, get_theme_file_uri( 'dist/' . $manifest['src/main.ts']['file'] ), array(), null, false );

	endif;
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_vite_assets', 100 );


/**
 * ブロックライブラリスタイルを削除
 */
function dequeue_block_style() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\dequeue_block_style', 100 );


/**
 * Script タグ置換
 *
 * @param string $tag HTML tag.
 * @param string $handle handle.
 * @param string $src src.
 * @return string HTML tag.
 */
function replace_script_module( string $tag, string $handle, string $src ) {
	if ( in_array( $handle, array( 'vite', THEME_DOMAIN ), true ) ) {
		return '<script type="module" src="' . esc_url( $src ) . '" defer></script>' . "\n"; // phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
	}
	return $tag;
}
add_filter( 'script_loader_tag', __NAMESPACE__ . '\replace_script_module', 10, 3 );
