<?php

namespace Lib\Cleanup;

/**
 * 不要メタ要素削除
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		remove_action( 'wp_head', 'wp_generator' );
		remove_action( 'wp_head', 'rsd_link' );
		remove_action( 'wp_head', 'wlwmanifest_link' );
		remove_action( 'wp_head', 'index_rel_link' );
		remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
		remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
		remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'feed_links_extra', 3 );

		// 絵文字関連削除
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_action( 'admin_print_styles', 'print_emoji_styles' );

		// Embed関連削除
		remove_action( 'wp_head', 'rest_output_link_wp_head' );
		remove_action( 'wp_head', 'wp_oembeds_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
		remove_action( 'template_redirect', 'rest_output_link_header', 11 );
	},
	102
);

/**
 * recent_comments_style 削除
 */
add_action(
	'widgets_init',
	function () {
		global $wp_widget_factory;
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
);

/**
 * コメント投稿無効化
 */
add_filter( 'comments_open', '__return_false' );

/**
 * REST API から "user" endpoint を削除
 */
add_filter(
	'rest_endpoints',
	function ( $endpoints ) {
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
		return $endpoints;
	},
	10,
	1
);
