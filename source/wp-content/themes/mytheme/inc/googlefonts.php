<?php

namespace Lib\GoogleFonts;

/**
 * Goggle Font link キューを追加
 */
add_action('wp_enqueue_scripts', __NAMESPACE__ . "\\enqueue_google_fonts");
add_action("admin_enqueue_scripts", __NAMESPACE__ . "\\enqueue_google_fonts");
function enqueue_google_fonts()
{
  if (!GOOGLE_FONTS || !(count(GOOGLE_FONTS) > 0)) return;
  foreach (GOOGLE_FONTS as $i => $fonts) {
    $num = '-' . $i;
    if ($i === 0) $num = '';
    wp_enqueue_style('google-fonts' . $num, esc_url($fonts), [], null);
  }
}

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
