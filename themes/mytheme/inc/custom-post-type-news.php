<?php

/**
 * カスタム投稿タイプ: トピック
 */

namespace Lib\CustomPostType\News;

/**
 * カスタム投稿タイプ登録
 */
add_action('init', function () {
  register_post_type('news', [
    'labels' => [
      'name' => 'お知らせ',
      'menu_name' => 'お知らせ',
      'singular_name' => 'お知らせ',
      'add_new' => 'お知らせを追加',
      'add_new_item' => 'お知らせを新規追加',
      'edit_item' => 'お知らせを編集する',
      'new_item' => '新規お知らせ',
      'all_items' => 'お知らせ一覧',
      'view_item' => '投稿を見る',
      'search_items' => '検索する',
      'not_found' => 'お知らせが見つかりませんでした。',
      'not_found_in_trash' => 'ゴミ箱内にお知らせが見つかりませんでした。',
    ],
    'public' => true,
    'has_archive' => true,
    'show_in_rest' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'supports' => ['title', 'author', 'editor', 'thumbnail'],
    'rewrite' => ['slug' => 'news'],
    'menu_position' => 4,
    'menu_icon' => 'dashicons-edit-large',
  ]);
});

/**
 * カスタムタクソノミー登録
 */
/*
add_action('init', function () {
  register_taxonomy(
    'category-news',
    ['news'],
    [
      'hierarchical' => true,
      'show_in_rest' => true,
      'labels' => [
        'name' => 'お知らせカテゴリー',
        'menu_name' => 'お知らせカテゴリー',
        'singular_name' => 'お知らせカテゴリー',
        'search_items' => 'お知らせカテゴリーを検索',
        'all_items' => '全てのお知らせカテゴリー',
        'parent_item' => '親お知らせカテゴリー',
        'parent_item_colon' => '親お知らせカテゴリー:',
        'edit_item' => 'お知らせカテゴリーを編集',
        'update_item' => 'お知らせカテゴリーを更新',
        'add_new_item' => 'お知らせカテゴリーを追加',
        'new_item_name' => '新規お知らせカテゴリー',
      ],
    ]
  );
});
*/

/**
 * 管理画面: 投稿リストにカスタムタクソノミーの絞り込み用ドロップダウンを追加
 */
/*
add_action('restrict_manage_posts', function () {
  global $post_type;

  if ($post_type !== 'news') {
    return;
  }

  wp_dropdown_categories([
    'show_option_all' => 'すべてのカテゴリー',
    'orderby' => 'name',
    'selected' => get_query_var('category-news'),
    'hide_empty' => true,
    'name' => 'category-news',
    'taxonomy' => 'category-news',
    'value_field' => 'slug',
  ]);
});
*/
