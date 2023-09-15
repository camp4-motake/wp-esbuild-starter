<?php

namespace Lib\Block\AcfBlock;

use Lib\Admin\User;

/**
 * カスタムブロックカテゴリーを追加
 */
add_filter("block_categories_all", function ($categories, $post) {
  return array_merge($categories, [[
    "slug"  => THEME_DOMAIN,
    "title" => _(esc_attr(THEME_DOMAIN) . "専用ブロック"),
  ]]);
}, 10, 2);

/**
 * カスタムACFブロック登録
 */
add_action("acf/init", function () {
  if (!function_exists("acf_register_block_type")) return;
  register_custom_blocks();
});

/**
 * block_render_callback
 *
 * @param [string] $block
 * @return void
 */
function acf_block_render_callback($block)
{
  $slug = str_replace("acf/", "", $block["name"]);
  $path = "/inc/block/acf/{$slug}.php";

  if (file_exists(get_theme_file_path($path))) {
    include get_theme_file_path($path);
  }
}

/**
 * 登録ブロックタイプリスト
 *
 * acf_register_block_type
 * @see https://www.advancedcustomfields.com/resources/acf_register_block_type/
 *
 * Dashicons
 * @see https://developer.wordpress.org/resource/dashicons/
 */
function register_custom_blocks()
{
  if (is_admin() && !User\is_higher_role_user()) {
    return false;
  }

  acf_register_block_type([
    "title"           => __("_block_name"),
    "name"            => "custom-block",
    "description"     => __("_desc"),
    "category"        => THEME_DOMAIN,
    "icon"            => "list-view",
    "keywords"        => ['_keywords'],
    "mode"            => "auto",
    "render_callback" => __NAMESPACE__ . "\\acf_block_render_callback",
    "supports"        => ["align" => ['wide', 'full'], "anchor" => true],
  ]);
}
