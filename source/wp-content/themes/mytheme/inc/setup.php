<?php

namespace Lib\Setup;

/**
 * Theme 基本セットアップ
 */
add_action("after_setup_theme", function () {
  add_theme_support("title-tag");
  add_theme_support("post-thumbnails");
  add_theme_support("align-wide");
  add_theme_support("html5", ["caption", "gallery", "search-form"]);
  add_theme_support("wp-block-styles");
  // add_theme_support('editor-styles');

  add_theme_custom_menu();
  load_theme_textdomain('mytheme', get_theme_file_path('/lang'));
});

/**
 * カスタムメニュー登録
 * @see http://codex.wordpress.org/Function_Reference/register_nav_menus
 */
function add_theme_custom_menu()
{
  register_nav_menus([
    "primary_navigation" => __("Primary Navigation", 'mytheme'),
    "footer_navigation"  => __("Footer Navigation", 'mytheme'),
  ]);
}
