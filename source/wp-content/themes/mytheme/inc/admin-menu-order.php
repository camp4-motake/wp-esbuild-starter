<?php

namespace Lib\MenuOrder;

/**
 * メニュー順序変更
 *s
 * @param [type] $menu_ord
 * @return void
 */
add_filter("custom_menu_order", __NAMESPACE__ . "\\custom_menu_order");
add_filter("menu_order", __NAMESPACE__ . "\\custom_menu_order");
function custom_menu_order($menu_ord)
{
  if (!$menu_ord) {
    return true;
  }
  return [
    "index.php", // ダッシュボード
    "separator1",
    "edit.php?post_type=page", // 固定ページ
    "edit.php?post_type=news", // ニュース
    "separator2",
  ];
}
