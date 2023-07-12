<?php

namespace Lib\Head;

use Lib\Helper\Path;

/**
 * wp_head アセット
 */
add_action("wp_head", function () {
  $n = "\n";

  // theme color
  echo '<meta name="theme-color" media="(prefers-color-scheme: light)" content="#efefef">' . $n;
  echo '<meta name="theme-color" media="(prefers-color-scheme: dark)" content="#323232">' . $n;

  // favicon
  echo '<link rel="apple-touch-icon" sizes="180x180" href="' . Path\cache_buster("/static/meta/apple-touch-icon.png") . '">' . $n;
  echo '<link rel="icon" type="image/svg+xml" href="' . Path\cache_buster("/static/meta/favicon.svg") . '">' . $n;
  echo '<link rel="icon" type="image/png" sizes="192x192" href="' . Path\cache_buster("/static/meta/favicon-192x192.png") . '">' . $n;
  echo '<link rel="icon" type="image/png" sizes="32x32" href="' . Path\cache_buster("/static/meta/favicon-32x32.png") . '">' . $n;

  // Google fonts
  $n . google_fonts_style_links();

  // main assets
  echo '<link rel="stylesheet" href="' . Path\cache_buster('/dist/main.css') . '">' . $n;
  echo '<script type="module" src="' . Path\cache_buster('/dist/main.js') . '"></script>' . $n;
});


/**
 * custom enqueue
 */
add_action("wp_enqueue_scripts", function () {
  remove_wp_block_library();
}, 100);

/**
 * dequeue wp-block-library
 */
function remove_wp_block_library()
{
  if (is_single() || is_singular()) {
    return;
  }
  wp_dequeue_style("wp-block-library");
}

/**
 * Google fonts キュー
 */
function enqueue_google_fonts()
{
  if (!GOOGLE_FONTS && !(count(GOOGLE_FONTS) > 0)) {
    return;
  }
  foreach (GOOGLE_FONTS as $i => $fonts) {
    wp_enqueue_style('google-fonts-' . $i + 1, $fonts, false, null);
  }
}


/**
 * resource hints 追加
 */
add_filter("wp_resource_hints", function ($hints, $relation_type) {
  if (is_admin() || is_user_logged_in()) {
    return $hints;
  }
  if ("dns-prefetch" === $relation_type) {
    $hints = array_filter($hints, function ($val) {
      return $val !== "fonts.googleapis.com" ? true : false;
    });

    if (IS_ENABLE_GTM_TRACKING) {
      $hints[] = "https://www.googletagmanager.com";
    }
  }
  if ("preconnect" === $relation_type) {
    if (GOOGLE_FONTS && (count(GOOGLE_FONTS) > 0)) {
      $hints[] = "https://fonts.googleapis.com";
      $hints[] = "https://fonts.gstatic.com";
    }
  }
  return $hints;
}, 10, 2);


/**
 * Goggle Font出力
 */
function google_fonts_style_links()
{
  if (!GOOGLE_FONTS || !(count(GOOGLE_FONTS) > 0)) {
    return;
  }
  foreach (GOOGLE_FONTS as $i => $fonts) {
    echo "<link rel=\"stylesheet\" href=\"{$fonts}\">\n";
  }
}
