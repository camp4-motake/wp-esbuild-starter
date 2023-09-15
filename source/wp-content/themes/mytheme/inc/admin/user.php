<?php

namespace Lib\Admin\User;

/**
 * 上位ユーザー以外はメディア表示を自分のアイテムのみに制限
 */
add_filter('posts_where', function ($where) {
  if (!is_admin() || is_higher_role_user()) {
    return $where;
  }
  if (isset($_POST['action']) && ($_POST['action'] == 'query-attachments')) {
    global $current_user;
    $where .= ' AND post_author=' . $current_user->data->ID;
  }
  return $where;
});

/**
 * ヘルパー: 上位編集ユーザー（管理者or編集者）判定
 *
 * @return boolean
 */
function is_higher_role_user()
{
  return current_user_can('administrator') || current_user_can('editor');
}

/**
 * 指定ロール所属ユーザーID配列を取得
 *
 * @param string $cap
 * @return array
 */
function get_user_cap_ids($cap = '')
{
  $store_users = get_users(['role' => $cap]);
  if (!$store_users) {
    return [];
  }
  return array_map(function ($user) {
    return $user->ID;
  }, $store_users);
}

/**
 * 購読者ユーザーの管理画面表示を禁止
 */
// add_action("auth_redirect", function ($user_id) {
//   $user = get_userdata($user_id);
//   if (!$user->has_cap("edit_posts")) {
//     wp_redirect(get_home_url());
//     exit();
//   }
// });

/**
 * 購読者ユーザーの管理バーを表示しない
 */
// add_action("after_setup_theme", function () {
//   $user = wp_get_current_user();
//   if (isset($user->data) && !$user->has_cap("edit_posts")) {
//     show_admin_bar(false);
//   }
// });
