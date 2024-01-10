<?php

namespace Lib\Admin\Hooks;

use Lib\Helper\Env;

/**
 * ページリストの投稿表示数を変更
 */
add_filter(
	'edit_posts_per_page',
	function ( $posts_per_page ) {
		if ( $posts_per_page >= 100 ) {
			return $posts_per_page;
		}
		return 100;
	}
);

/**
 * 固定ページ一覧にスラッグ表示用カラムを追加
 */
add_filter( 'manage_pages_columns', __NAMESPACE__ . '\\add_page_column_title' );
// add_filter('manage_[post_type]_posts_columns', __NAMESPACE__ . '\\add_page_column_title');
function add_page_column_title( $columns ) {
	$columns['slug'] = 'スラッグ';
	return $columns;
}

/**
 * 固定ページ一覧にスラッグを表示
 */
add_action( 'manage_pages_custom_column', __NAMESPACE__ . '\\add_page_column', 10, 2 );
// add_action('manage_[post_type]_posts_custom_column', __NAMESPACE__ . '\\add_page_column', 10, 2);
function add_page_column( $column_name, $post_id ) {
	if ( $column_name == 'slug' ) {
		$post  = get_post( $post_id );
		$uri   = get_permalink( $post_id );
		$slug  = $post->post_name;
		$error = '';

		if ( strpos( esc_attr( $slug ), '%' ) !== false ) {
			$error = '<strong class="error" style="color:red;">【!】パーマリンクのURLスラッグを半角英数字のみに修正してから公開してください。</strong>';
		}

		echo $error . '<a href="' . esc_url( $uri ) . '" target="_blank" rel="noopener">' . esc_attr( $slug ) . ' </a>';
	}
}

/**
 * 管理画面カスタマイズ用追加インラインCSS
 */
add_action(
	'admin_print_styles',
	function () {
		$style = '<style>';

		// 管理バー左上タイトルにローカルホスト・開発サーバー識別文字を追加
		if ( Env\in_local() ) {
			$style .= '#wp-admin-bar-site-name .ab-item:after { content:"（ローカル）"; }';
		} elseif ( Env\in_staging() ) {
			$style .= '#wp-admin-bar-site-name .ab-item:after { content:"（ステージング環境）"; }';
		}

		$style .= '</style>';
		echo $style;
	}
);
