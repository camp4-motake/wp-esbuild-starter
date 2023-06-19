<?php

/**
 * カスタム投稿タイプ: お知らせ
 */

namespace Lib\CustomPostType\News;

/**
 * カスタム投稿タイプ登録
 */
add_action("init", function () {
  register_post_type("news", [
    "labels" => [
      "name"               => __("News & Topics", "mytheme"),
      "singular_name"      => __("News & Topics", "mytheme"),
      "menu_name"          => __("お知らせ", "mytheme"),
      "add_new"            => __("お知らせを追加", "mytheme"),
      "add_new_item"       => __("お知らせを新規追加", "mytheme"),
      "edit_item"          => __("お知らせを編集する", "mytheme"),
      "new_item"           => __("新規お知らせ", "mytheme"),
      "all_items"          => __("お知らせ一覧", "mytheme"),
      "view_item"          => __("投稿を見る", "mytheme"),
      "search_items"       => __("検索する", "mytheme"),
      "not_found"          => __("お知らせが見つかりませんでした。", "mytheme"),
      "not_found_in_trash" => __("ゴミ箱内にお知らせが見つかりませんでした。", "mytheme"),
    ],
    "public"        => true,
    "has_archive"   => true,
    "show_in_rest"  => true,
    "show_ui"       => true,
    "show_in_menu"  => true,
    "supports"      => ["title", "author", "editor", "thumbnail"],
    "rewrite"       => ["slug" => "news"],
    "menu_position" => 4,
    "menu_icon"     => "dashicons-edit-large",
  ]);
});

/**
 * カスタムタクソノミー登録
 */

add_action("init", function () {
  register_taxonomy(
    "category-news",
    ["news"],
    [
      "hierarchical" => true,
      "show_in_rest" => true,
      "labels" => [
        "name"              => __("News & Topics Category", "mytheme"),
        "singular_name"     => __("News & Topics Category", "mytheme"),
        "menu_name"         => __("お知らせカテゴリー", "mytheme"),
        "search_items"      => __("お知らせカテゴリーを検索", "mytheme"),
        "all_items"         => __("全てのお知らせカテゴリー", "mytheme"),
        "parent_item"       => __("親お知らせカテゴリー", "mytheme"),
        "parent_item_colon" => __("親お知らせカテゴリー:", "mytheme"),
        "edit_item"         => __("お知らせカテゴリーを編集", "mytheme"),
        "update_item"       => __("お知らせカテゴリーを更新", "mytheme"),
        "add_new_item"      => __("お知らせカテゴリーを追加", "mytheme"),
        "new_item_name"     => __("新規お知らせカテゴリー", "mytheme"),
      ],
    ]
  );
});

/**
 * 管理画面: 投稿リストにカスタムタクソノミーの絞り込み用ドロップダウンを追加
 */

add_action("restrict_manage_posts", function () {
  global $post_type;

  if ($post_type !== "news") {
    return;
  }

  wp_dropdown_categories([
    "show_option_all" => __("すべてのカテゴリー", "mytheme"),
    "orderby"         => "name",
    "selected"        => get_query_var("category-news"),
    "hide_empty"      => true,
    "name"            => "category-news",
    "taxonomy"        => "category-news",
    "value_field"     => "slug",
  ]);
});
