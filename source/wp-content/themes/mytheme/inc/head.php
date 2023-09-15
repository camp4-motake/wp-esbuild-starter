<?php

namespace Lib\Head;

use Lib\Helper\Path;

/**
 * テーマアセットキュー
 */
add_action('wp_enqueue_scripts', function () {
  // wp_dequeue_style("wp-block-library");
  enqueue_google_fonts();
  wp_enqueue_style(THEME_DOMAIN, Path\cache_buster('dist/main.css'), [], null);
  wp_enqueue_script(THEME_DOMAIN, Path\cache_buster('dist/main.js'), [], null);
}, 100);

/**
 * wp_enqueue_script の出力を modules の script タグに置換
 */
add_filter('script_loader_tag', function (string $tag, string $handle, string $src) {
  if (!in_array($handle, [THEME_DOMAIN]))   return $tag;
  return '<script type="module" src="' . esc_url($src) . '" defer></script>' . "\n";
}, 10, 3);

/**
 * Goggle Font の resource hints 追加
 */
add_filter("wp_resource_hints", function ($hints, $relation_type) {
  if (is_admin() || is_user_logged_in()) {
    return $hints;
  }
  if ("dns-prefetch" === $relation_type) {
    $hints = array_filter($hints, function ($val) {
      return $val !== "fonts.googleapis.com" ? true : false;
    });
  }
  if ("preconnect" === $relation_type && GOOGLE_FONTS && (count(GOOGLE_FONTS) > 0)) {
    $hints[] = "https://fonts.googleapis.com";
    $hints[] = "https://fonts.gstatic.com";
  }
  return $hints;
}, 10, 2);

/**
 * Goggle Font link キューを追加
 */
function enqueue_google_fonts()
{
  if (!GOOGLE_FONTS || !(count(GOOGLE_FONTS) > 0)) return;
  foreach (GOOGLE_FONTS as $i => $fonts) {
    $num = '-' . $i;
    if ($i === 0) $num = '';
    wp_enqueue_style('google-fonts' . $num, esc_url($fonts), [], null);
  }
}
