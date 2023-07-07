<?php

namespace Lib\SiteIcon;

// use Lib\Helper;

/**
 * サイトアイコン無効化
 */
add_filter("site_icon_meta_tags", function ($meta_tags) {
  $meta_tags = [];
  return $meta_tags;
});

/**
 * WP サイトアイコンのリダイレクト先をテーマ内の Favicon にオーバーライド
 */
add_filter('get_site_icon_url', function ($url) {
  return get_theme_file_uri('static/meta/favicon.ico');
});
