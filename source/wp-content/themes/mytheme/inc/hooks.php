<?php

namespace Lib\Hooks;

/**
 * read more リンクをカスタマイズ
 */
add_filter(
	'excerpt_more',
	function () {
		return '... <a class="link-readmore" href="' . get_permalink( get_the_ID() ) . '"><small>' . _( 'Readm More' ) . '</small></a>';
	}
);

/**
 * the_archive_title から余計な文字を削除
 */
add_filter(
	'get_the_archive_title',
	function ( $title ) {
		if ( is_category() ) {
			$title = single_cat_title( '', false );
		}
		if ( is_tag() ) {
			$title = single_tag_title( '', false );
		}
		if ( is_tax() ) {
			$title = single_term_title( '', false );
		}
		if ( is_post_type_archive() ) {
			$title = post_type_archive_title( '', false );
		}
		if ( is_search() ) {
			$title = '検索結果';

			if ( get_search_query( false ) ) {
				$title .= ': ' . esc_html( get_search_query( false ) );
			}
		}
		if ( is_404() ) {
			$title = '404 Not Found | ページが見つかりません';
		}
		return $title;
	}
);

/**
 * next_post_link、previous_post_link にクラス付与
 *
 * @link https://www.nxworld.net/wordpress/wp-add-class-previous-posts-link-and-next-posts-link.html
 */
add_filter(
	'previous_post_link',
	function ( $output ) {
		return str_replace(
			'<a href=',
			'<a class="prev btn -border is-arrow-left" href=',
			$output
		);
	}
);
add_filter(
	'next_post_link',
	function ( $output ) {
		return str_replace(
			'<a href=',
			'<a class="next btn -border is-arrow-right" href=',
			$output
		);
	}
);

/**
 * expert出力調整
 */
add_filter(
	'excerpt_more',
	function ( $more ) {
		if ( is_post_type_archive( 'contents' ) ) {
			return '[...]';
		}
	}
);

/**
 * 検索クエリを無効化しホームにリダイレクト
 */
/*
add_action('init', function ($query) {
	if (is_admin() || is_user_logged_in()) {
	return;
	}
	if (
	!empty($_GET['s']) ||
	(array_key_exists('s', $_GET) && $_GET['s'] === '')
	) {
	wp_redirect(home_url(), 301);
	exit();
	}
});
 */
