<?php

/**
 * ビルトインの「投稿」の各メニューを非表示
 */

namespace Lib\BuiltinPosts;

// Remove side menu
add_action('admin_menu', function () {
  remove_menu_page('edit.php');
});

// Remove +New post in top Admin Menu Bar
add_action(
  'admin_bar_menu',
  function ($wp_admin_bar) {
    $wp_admin_bar->remove_node('new-post');
  },
  999
);

// Remove Quick Draft Dashboard Widget
add_action(
  'wp_dashboard_setup',
  function () {
    remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
  },
  999
);

// Remove Built in tag & category
add_action('init', function () {
  unregister_taxonomy_for_object_type('post_tag', 'post');
  unregister_taxonomy_for_object_type('category', 'post');
});
