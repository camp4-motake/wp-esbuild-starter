<?php

namespace Lib\Plugins\Acf;

/**
 * ACF TinyMCE エディタ設定カスタマイズ
 */
add_filter(
	'acf/fields/wysiwyg/toolbars',
	function ( $toolbars ) {
		// TinyMCE エディタにフォントサイズ設定用のドロップダウン追加
		$key = array_search( 'fontsizeselect', $toolbars['Full'][2] );
		if ( $key !== true ) {
			array_push( $toolbars['Full'][2], 'fontsizeselect' );
		}
		return $toolbars;
	}
);

add_filter(
	'tiny_mce_before_init',
	function ( $initArray ) {
		// フォントサイズ変更
		$initArray['fontsize_formats'] = '0.625rem 0.75rem 0.875rem 1em 1.125rem 1.25rem 1.5rem 1.75rem 2.5rem 4rem';
		return $initArray;
	}
);

/**
 * WORKAROUND: ACFのデータが preview で反映されない現象対策
 * 参考: https://gist.github.com/ChrisLTD/892eccf385752dadaf5f
 */
add_filter(
	'_wp_post_revision_fields',
	function ( $fields ) {
		$fields['debug_preview'] = 'debug_preview';
		return $fields;
	}
);

add_action(
	'edit_form_after_title',
	function () {
		echo '<input type="hidden" name="debug_preview" value="debug_preview">';
	}
);


/**
 * ヘルパー: Linkフィールド配列からaタグの属性文字列を生成
 *
 * @param [array] $link
 * @return string
 */
function make_acf_link_attr_string( $link = array() ) {
	if ( empty( $link ) ) {
		return false;
	}

	$link_attr = 'href="' . esc_url( $link['url'] ) . '" ';

	if ( isset( $link['title'] ) ) {
		$link_attr .= ' title="' . esc_attr( $link['title'] ) . '"';
	}
	if ( isset( $link['target'] ) ) {
		$link_attr .= ' target="' . esc_attr( $link['target'] ) . '"';

		if ( $link['target'] === '_blank' ) {
			$link_attr .= ' rel="noopener noreferrer"';
		}
	}

	return $link_attr;
}
