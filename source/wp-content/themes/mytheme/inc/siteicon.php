<?php

namespace Lib\SiteIcon;

use Lib\Helper\Path;

/**
 * サイトアイコン無効化
 */
add_filter("site_icon_meta_tags", function ($meta_tags) {
  $meta_tags = [];
  return $meta_tags;
});

/**
 * WP サイトアイコンのリダイレクト先をテーマ内の Favicon 画像にオーバーライド
 */
add_filter('get_site_icon_url', function ($url) {
  $ico_file_svg = 'static/meta/favicon.svg';
  $ico_file_png = 'static/meta/favicon-144x144.png';

  if (is_admin() && file_exists(get_theme_file_path($ico_file_svg))) {
    return get_theme_file_uri($ico_file_svg);
  }
  if (file_exists(get_theme_file_path($ico_file_png))) {
    return get_theme_file_uri($ico_file_png);
  }
  return $url;
});

/**
 * wp_head 追加アセット
 */
add_action("wp_head", function () {
  $n = "\n";
  // favicon
  echo '<link rel="apple-touch-icon" sizes="180x180" href="' . Path\cache_buster("/static/meta/apple-touch-icon.png") . '">' . $n;
  echo '<link rel="icon" type="image/svg+xml" href="' . Path\cache_buster("/static/meta/favicon.svg") . '">' . $n;
  echo '<link rel="icon" type="image/png" sizes="144x144" href="' . Path\cache_buster("/static/meta/favicon-144x144.png") . '">' . $n;
  echo '<link rel="icon" type="image/png" sizes="48x48" href="' . Path\cache_buster("/static/meta/favicon-48x48.png") . '">' . $n;
  // theme color
  // echo '<meta name="theme-color" content="#2399ed">' . $n;

  // theme color (dark mode support)
  // echo '<meta name="theme-color" media="(prefers-color-scheme: light)" content="#efefef">' . $n;
  // echo '<meta name="theme-color" media="(prefers-color-scheme: dark)" content="#323232">' . $n;
}, 3);
