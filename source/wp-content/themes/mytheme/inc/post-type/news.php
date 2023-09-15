<?php

/**
 * カスタム投稿タイプ: ニュース
 */

namespace Lib\CustomPostType\News;

/**
 * カスタム投稿タイプ登録
 */
add_action("init", function () {
  register_post_type("news", [
    "labels" => [
      "name"               => __("ニュース", "mytheme"),
      "singular_name"      => __("ニュース", "mytheme"),
      "menu_name"          => __("ニュース", "mytheme"),
      "add_new"            => __("ニュースを追加", "mytheme"),
      "add_new_item"       => __("ニュースを新規追加", "mytheme"),
      "edit_item"          => __("ニュースを編集する", "mytheme"),
      "new_item"           => __("新規ニュース", "mytheme"),
      "all_items"          => __("ニュース一覧", "mytheme"),
      "view_item"          => __("投稿を見る", "mytheme"),
      "search_items"       => __("検索する", "mytheme"),
      "not_found"          => __("ニュースが見つかりませんでした。", "mytheme"),
      "not_found_in_trash" => __("ゴミ箱内にニュースが見つかりませんでした。", "mytheme"),
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

    // 'capability_type' => 'news',
    // 'map_meta_cap'    => true
  ]);

  // $capabilities = [
  //   'delete_newss',
  //   'delete_others_newss',
  //   'delete_private_newss',
  //   'delete_published_newss',
  //   'edit_newss',
  //   'edit_others_newss',
  //   'edit_private_newss',
  //   'edit_published_newss',
  //   'publish_newss',
  //   'read_private_newss',
  // ];
  // $enable_roles = ['administrator', 'editor'];

  // foreach ($enable_roles as $role_name) {
  //   $role = get_role($role_name);
  //   foreach ($capabilities as $cap) {
  //     $role->add_cap($cap);
  //   }
  // }
});

/**
 * カスタムタクソノミー登録
 * https://developer.wordpress.org/reference/functions/register_taxonomy/
 */
add_action("init", function () {
  register_taxonomy(
    "category-news",
    ["news"],
    [
      "hierarchical" => true,
      "show_in_rest" => true,
      "labels" => [
        "name"              => __("ニュースカテゴリー", "mytheme"),
        "singular_name"     => __("ニュースカテゴリー", "mytheme"),
        "menu_name"         => __("ニュースカテゴリー", "mytheme"),
        "search_items"      => __("ニュースカテゴリーを検索", "mytheme"),
        "all_items"         => __("全てのニュースカテゴリー", "mytheme"),
        "parent_item"       => __("親ニュースカテゴリー", "mytheme"),
        "parent_item_colon" => __("親ニュースカテゴリー:", "mytheme"),
        "edit_item"         => __("ニュースカテゴリーを編集", "mytheme"),
        "update_item"       => __("ニュースカテゴリーを更新", "mytheme"),
        "add_new_item"      => __("ニュースカテゴリーを追加", "mytheme"),
        "new_item_name"     => __("新規ニュースカテゴリー", "mytheme"),
      ],
      'capabilities' => [
        'assign_terms' => 'edit_newss',
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
