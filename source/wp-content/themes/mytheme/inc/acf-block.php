<?php

namespace Lib\Acf\Block;

/**
 * カスタムブロックカテゴリーを追加
 */
add_filter("block_categories_all", function ($categories, $post) {
  return array_merge($categories, [
    [
      "slug"  => THEME_DOMAIN,
      "title" => _("テーマ専用ブロック"),
    ],
  ]);
}, 10, 2);

/**
 * カスタムACFブロックを登録
 *
 * icon は Dashicons を指定
 * https://developer.wordpress.org/resource/dashicons/
 */
add_action("acf/init", function () {
  if (!function_exists("acf_register_block_type")) {
    return;
  }

  // acf_register_block_type([
  //   "title"           => __("***"),
  //   "description"     => __(""),
  //   "category"        => THEME_DOMAIN,
  //   "icon"            => "grid-view",
  //   "keywords"        => [],
  //   "mode"            => "auto",
  //   "name"            => "file_name",
  //   "render_callback" => __NAMESPACE__ . "\\acf_block_render_callback",
  //   "supports"        => ["align" => [], "anchor" => true],
  // ]);
});

function acf_block_render_callback($block)
{
  $slug = str_replace("acf/", "", $block["name"]);
  $path = "/inc/block/acf/{$slug}.php";

  if (file_exists(get_theme_file_path($path))) {
    include get_theme_file_path($path);
  }
}
