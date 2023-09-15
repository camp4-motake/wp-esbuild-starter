<?php

/**
 * Yoast SEO 動作カスタマイズ用 hook & helper
 *
 * Yoast SEO - Metadata API
 * https://developer.yoast.com/customization/apis/metadata-api/
 */

namespace Lib\Plugins\YoastSeo;

/**
 * yoast SEO ユーザーを削除
 */
add_action("after_setup_theme", function () {
  remove_role('wpseo_manager');
  remove_role('wpseo_editor');
});

/**
 * 管理画面: Yoast SEO のメタボックスを最下部に移動
 */
add_filter("wpseo_metabox_prio", function () {
  return "low";
});

/**
 * Yoast SEO のソースコメント出力を削除
 */
add_filter("wpseo_debug_markers", "__return_false");

/**
 * Yoast SEO の言語上書き
 */
add_filter("wpseo_locale", function ($locale) {
  return get_locale();
});

/**
 *  Yoast SEO の右サイド広告を非表示
 */
add_action("admin_print_styles", function () {
  echo ''
    . "<style>"
    . ' #sidebar.yoast-sidebar,.yoast-notification.notice.notice-warning.is-dismissible,.yoast_premium_upsell { display: none !important;'
    . "</style>";
});


/**
 * Helper: yoast seo breadcrumb 出力 + パンくずの矢印をHTMLタグに置換
 * ※置換するには、管理画面パンくず設定で区切り文字に %arrow を指定
 *
 * https://yoast.com/help/implement-wordpress-seo-breadcrumbs/
 */
function get_yoast_seo_breadcrumb()
{
  if (!function_exists("yoast_breadcrumb")) {
    return "";
  }

  $arrow_html = ">";

  ob_start();
  yoast_breadcrumb('<div class="breadcrumb">', "</div>" . "\n");
  $breadcrumb = ob_get_contents();
  ob_end_clean();

  $breadcrumb = str_replace("%arrow", $arrow_html, $breadcrumb);

  return $breadcrumb;
}
