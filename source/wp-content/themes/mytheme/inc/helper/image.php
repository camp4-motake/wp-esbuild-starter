<?php

namespace Lib\Helper\Image;

use Lib\Helper\Path;

/**
 * 指定したパスのインラインSVGを返す
 *
 * @param String $filepath svg ファイルパス
 * @param String $title titleタグ置換用テキスト
 * @return String インライン SVG
 */
function inline_svg( string $filepath = '', string $title = '' ) {
	$svg_asset_path = get_theme_file_path( $filepath );

	if ( ! file_exists( $svg_asset_path ) ) {
		return;
	}

	// svg 取得
	$svg_source = file_get_contents( $svg_asset_path );

	// titleタグ置換
	if ( $title && $title !== '' ) {
		$pattern    = '/<title>.*?<\/title>/u';
		$replace    = "<title>{$title}</title>";
		$svg_source = preg_replace( $pattern, $replace, $svg_source );
	}

	return $svg_source;
}

/**
 * svg スプライト表示タグを返す
 *
 * @param string $xlink - svg filename
 * @param string $classname - css class
 * @return string
 */
function svg_sprite( $xlink = '', $title = '', $class = '', $attr = array(), $role = 'img' ): string {
	$attr = array_merge(
		array(
			// 'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
			'xlink:href' => '#svg--' . esc_attr( $xlink ),
		),
		$attr
	);

	$use_attr   = array_to_attr_string( $attr );
	$class_name = $class ? 'class="' . esc_attr( $class ) . '" ' : '';

	$xml = '<svg ' . $class_name . 'role="' . esc_attr( $role ) . '">';
	if ( ! empty( $title ) ) {
		$xml .= '<title>' . esc_attr( $title ) . '</title>';
	}
	$xml .= '<use ' . $use_attr . '></use></svg>';

	return $xml;
}

/**
 * 画像タグ生成 - 同名の webp/avif の有無を判定しimg/picture タグを生成
 *
 * @param string  $path
 * @param array   $attrs
 * @param boolean $is_origin
 * @return string
 */
function auto_img( $path = '', $attrs = array(), $is_origin = true ) {
	if ( ! $path ) {
		return '';
	}
	// 画像探索パターン
	$order_patterns = array(
		'png'  => array( 'avif', 'webp', 'png' ),
		'jpg'  => array( 'avif', 'webp', 'jpg' ),
		'webp' => array( 'avif', 'webp' ),
	);
	$info           = pathinfo( $path );
	$ext            = $info['extension'];
	$img_tag        = make_img_tag( $path, $attrs );
	if ( empty( $order_patterns[ $ext ] ) ) {
		return $img_tag;
	}
	$src_items = array_map(
		function ( $e ) use ( $path, $ext, $img_tag, $is_origin ) {
			$target_path = str_replace( ".{$ext}", ".{$e}", $path );

			if ( $ext === $e && ! $is_origin ) {
				return null;
			}
			if ( file_exists( get_theme_file_path( $target_path ) ) ) {
				return $target_path;
			}
		},
		$order_patterns[ $ext ]
	);

	$src_items = array_filter( $src_items );
	$tag       = '';

	foreach ( $src_items as $item ) {
		if ( $item === end( $src_items ) ) {
			$tag .= make_img_tag( $item, $attrs );
		} else {
			$tag .= make_source_tag( $item );
		}
	}
	if ( count( $src_items ) <= 1 ) {
		return $tag;
	}
	return "<picture>\n" . $tag . "</picture>\n";
}

/**
 * {theme_name}/dist/ 内の画像パスから webp 表示用の picture タグを生成
 *
 * ex)メディアクエリなし
 *
 * 　<?php echo Image\mq_picture($src = 'images/sample.png', $img_attrs = [], $picture_attrs = []); ?>
 *
 * ex)メディアクエリありの場合はソースパスとブレークポイントをを配列で指定
 *
 * <?php
 * $src = [
 *  'img' => 'images/sample.jpg',
 *   'source' => [
 *     ['src' => 'images/sample-lg.jpg', 'media' => MQ_LG],
 *     ['src' => 'images/sample-sm.jpg', 'media' => MQ_MD],
 *   ]
 * ];
 * echo Image\mq_picture($src, $img_attrs = [], $picture_attrs = []);
 * ?>
 *
 * @param string|array $src_path - assets/ 以下の画像パスを指定
 * @param array        $img_attrs　- img タグに追加する属性。クラスやIDなど。
 * @param array        $picture_attrs - picture に追加する属性。クラスやIDなど。
 * @return string
 */
function picture_media( $src_path = '' || array(), $img_attrs = array(), $picture_attrs = array() ): string {
	$sources = false;

	if ( is_array( $src_path ) && isset( $src_path['img'] ) ) {
		$path = $src_path['img'];
		if ( isset( $src_path['source'] ) && count( $src_path['source'] ) ) {
			$sources = $src_path['source'];
		}
	} elseif ( is_string( $src_path ) ) {
		$path = $src_path;
	} else {
		return '';
	}

	$img_tag   = make_img_tag( $path, $img_attrs );
	$webp_path = preg_replace( '/\.[^.]+$/', '.webp', $path );

	if ( ! $sources && ! file_exists( get_theme_file_path( $webp_path ) ) ) {
		return $img_tag;
	}

	$n    = "\n";
	$html = '<picture' . array_to_attr_string( $picture_attrs ) . '>' . $n;

	if ( $sources ) {
		foreach ( $sources as $source ) {
			if ( ! isset( $source['src'] ) || ! isset( $source['media'] ) ) {
				continue;
			}
			$webp_path = preg_replace( '/\.[^.]+$/', '.webp', $source['src'] );
			$html     .= make_source_tag( $webp_path, 'image/webp', $source['media'] );
		}
		foreach ( $sources as $source ) {
			if ( ! isset( $source['src'] ) || ! isset( $source['media'] ) ) {
				continue;
			}
			$html .= make_source_tag( $source['src'], null, $source['media'] );
		}
	} else {
		$html .=
		'' . make_source_tag( $webp_path, 'image/webp' ) . make_source_tag( $path );
	}

	$html .= $img_tag;
	$html .= '</picture>' . $n;

	return $html;
}

/**
 * img タグ生成
 *
 * @param string $path
 * @param array  $attrs
 * @return string
 */
function make_img_tag( $path = '', $attrs = array() ) {
	$img_path = get_theme_file_path( $path );
	if ( ! file_exists( $img_path ) ) {
		return '';
	}
	$img_size = getimagesize( $img_path );
	$attrs    = wp_parse_args(
		$attrs,
		array(
			'width'    => ! empty( $img_size[0] ) ? $img_size[0] : '',
			'height'   => ! empty( $img_size[1] ) ? $img_size[1] : '',
			'alt'      => '',
			'decoding' => 'async',
		)
	);
	return '<img src="' . esc_url( Path\cache_buster( $path ) ) . '"' . array_to_attr_string( $attrs ) . '/>' . "\n";
}

/**
 * source タグ生成
 *
 * @param string $path
 * @param string $media
 * @return string
 */
function make_source_tag( $path = '', $media = null ) {
	$source_path = get_theme_file_path( $path );
	if ( ! file_exists( $source_path ) ) {
		return '';
	}
	$source_size = getimagesize( $source_path );
	$attrs       = array(
		'width'  => ! empty( $source_size[0] ) ? $source_size[0] : '',
		'height' => ! empty( $source_size[1] ) ? $source_size[1] : '',
		'type'   => ! empty( $source_size['mime'] ) ? $source_size['mime'] : '',
	);
	if ( ! empty( $media ) ) {
		$attrs = wp_parse_args( $attrs, array( 'media' => $media ) );
	}
	return '<source srcset="' . esc_url( Path\cache_buster( $path ) ) . '"' . array_to_attr_string( $attrs ) . ' >' . "\n";
}

/**
 * srcset 文字列を生成
 *
 * @param string  $filename
 * @param array   $resolution
 * @param boolean $non_1x
 * @return string
 */
function get_srcset_attr( $filename = '', $resolution = array(), $non_1x = false ): string {
	$resolution    = array_merge(
		array(
			'1x' => '',
			'2x' => '@2x',
		),
		$resolution
	);
	$srcset        = array();
	$srcset_string = '';
	foreach ( $resolution as $key => $res ) {
		if ( $key === '1x' && $non_1x === true ) {
			continue;
		}
		$high_res_name = preg_replace( '/\.[^.]s+$/', $res . '$0', $filename );
		if ( ! file_exists( get_theme_file_path( $high_res_name ) ) ) {
			continue;
		}
		$srcset[ $key ] = esc_url( Path\cache_buster( $high_res_name ) );
	}
	$srcset_string_arr = array();
	foreach ( $srcset as $key => $url ) {
		$srcset_string_arr[] = $url . ' ' . $key;
	}
	$srcset_string = implode( ',', $srcset_string_arr );
	return $srcset_string ? 'srcset="' . $srcset_string . '"' : '';
}

/**
 * 連想配列を HTML タグ属性文字列に変換
 *
 * ex)
 * ['alt' => 'text', 'loading' => 'lazy'] -> 'alt="text" loading="lazy"'
 *
 * @param array $attrs
 * @return string
 */
function array_to_attr_string( $attrs = array(), $spacer = ' ' ): string {
	$attr_string = '';
	foreach ( $attrs as $key => $attr ) {
		$attr_string .= esc_attr( $key ) . '="' . esc_attr( $attr ) . '"';
		if ( $attr !== end( $attrs ) ) {
			$attr_string .= ' ';
		}
	}
	return $attr_string ? $spacer . $attr_string : '';
}

/**
 * wp_kses_allowed_html にpictureなどのタグを追加
 */
function kses_post_extend( $context = 'post' ) {
	$wp_allowed_html = wp_kses_allowed_html( $context );

	return array_merge(
		$wp_allowed_html,
		array(
			'source'  => array(
				'media'  => true,
				'sizes'  => true,
				'src'    => true,
				'srcset' => true,
				'type'   => true,
			),
			'picture' => array(
				'class'  => true,
				'id'     => true,
				'media'  => true,
				'srcset' => true,
				'type'   => true,
			),
		)
	);
}
