<?php

namespace Lib\User;

/**
 * 購読者ユーザーの管理画面表示を禁止
 */
add_action("auth_redirect", function ($user_id) {
  $user = get_userdata($user_id);
  if (!$user->has_cap("edit_posts")) {
    wp_redirect(get_home_url());
    exit();
  }
});

/**
 * 購読者ユーザーの管理バーを表示しない
 */
add_action("after_setup_theme", function () {
  $user = wp_get_current_user();
  if (isset($user->data) && !$user->has_cap("edit_posts")) {
    show_admin_bar(false);
  }
});
