<?php

/**
 * カスタム投稿タイプ関連フック
 */

namespace Lib\CustomPostType;

/**
 * 記事タイトルの placeholder を変更
 *
 * @param [type] $title
 * @return void
 */
// function change_edit_title_placeholder($title)
// {
//   $screen = get_current_screen();

//   if ($screen->post_type == '') {
//     $title = '';
//   }

//   return $title;
// }
// add_filter('enter_title_here', __NAMESPACE__ . '\\change_edit_title_placeholder');

/**
 * 特定の投稿タイプでブロックエディター無効化
 */
// function hide_block_editor($use_block_editor, $post_type)
// {
//   if ($post_type === 'page') {
//     return false;
//   }
//   return $use_block_editor;
// }
// add_filter('use_block_editor_for_post_type', __NAMESPACE__ . '\\hide_block_editor', 10, 10);

/**
 * メニュー順序変更
 *
 * @param [type] $menu_ord
 * @return void
 */
add_filter('custom_menu_order', __NAMESPACE__ . '\\custom_menu_order');
add_filter('menu_order', __NAMESPACE__ . '\\custom_menu_order');
function custom_menu_order($menu_ord)
{
  if (!$menu_ord) {
    return true;
  }

  return [
    'index.php', // ダッシュボード
    'separator1',
    'edit.php?post_type=page', // 固定ページ
    'edit.php?post_type=events', // イベント
    'edit.php?post_type=news', // ニュース/レビュー
    'separator2',
  ];
}
