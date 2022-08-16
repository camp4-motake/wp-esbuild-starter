<?php
/**
 * Yoast SEO 動作カスタマイズ用 hook & helper
 *
 * Yoast SEO - Metadata API
 * https://developer.yoast.com/customization/apis/metadata-api/
 */
namespace Lib\YoastSeo;

/**
 * 管理画面: Yoast SEO のメタボックスを最下部に移動
 */
add_filter('wpseo_metabox_prio', function () {
  return 'low';
});

/**
 * Yoast SEO のソースコメント出力を削除
 */
add_filter('wpseo_debug_markers', '__return_false');

/**
 * Yoast SEO の言語上書き
 */
add_filter('wpseo_locale', function ($locale) {
  return get_locale();
});
