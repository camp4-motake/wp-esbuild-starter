<?php

namespace Lib\Setup;

add_action(
	'after_setup_theme',
	function () {
		add_supports();
		add_theme_custom_menu();
		add_text_domain();
	}
);

/**
 * テーマサポート
 *
 * @see https://developer.wordpress.org/reference/functions/add_theme_support/
 * @see https://ja.wordpress.org/team/handbook/block-editor/how-to-guides/themes/theme-support/
 */
function add_supports() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'html5', array( 'caption', 'gallery', 'search-form' ) );
	add_theme_support( 'wp-block-styles' );
	// add_theme_support('editor-styles');
}

/**
 * カスタムメニュー登録
 *
 * @see https://developer.wordpress.org/reference/functions/register_nav_menus/
 */
function add_theme_custom_menu() {
	register_nav_menus(
		array(
			'nav_primary' => __( 'nav primary', 'mytheme' ),
			'nav_footer'  => __( 'nav footer', 'mytheme' ),
		)
	);
}

/**
 * 翻訳ファイルをロード
 *
 * @see https://developer.wordpress.org/reference/functions/load_theme_textdomain/
 */
function add_text_domain() {
	load_theme_textdomain( 'mytheme', get_theme_file_path( '/lang' ) );
}
