<?php

namespace Lib\Editor;

use Lib\Head;
use Lib\Helper\Path;

/**
 * ブロックエディター用アセットをロード
 *
 * @return void
 */
add_action("admin_enqueue_scripts", function () {
  Head\enqueue_google_fonts(); // Google fonts
  wp_enqueue_script(THEME_DOMAIN . '-editor', Path\cache_buster('dist/editor.js'), [], null);
  wp_enqueue_style(THEME_DOMAIN . '-editor', Path\cache_buster('dist/editor.css'), [], null);
}, 100);

/**
 * 投稿の初回保存時にページIDを設定（記事の日本語タイトルがそのままスラッグになるのを防ぐ）
 *
 * @see https://liginc.co.jp/576942
 */
add_filter("wp_unique_post_slug", function ($slug, $post_ID, $post_status, $post_type) {
  $post = get_post($post_ID);
  $is_slug_invalid = preg_match("/(%[0-9a-f]{2})+/", $slug);

  if ($is_slug_invalid && $post->post_date_gmt == "0000-00-00 00:00:00") {
    if ($post_type === 'page') {
      return 'page-' . $post_ID;
    }
    return $post_ID;
  }
  if ($is_slug_invalid) {
    if ($post_type === 'page') {
      return 'page-' . $post_ID;
    }
    return $post_ID;
  }
  return $slug;
}, 10, 4);

/**
 * WORKAROUND: Bogoを有効にすると wp_unique_post_slug が発火しない対策
 */
add_filter('pre_wp_unique_post_slug', function ($override_slug, $slug, $post_ID, $post_status, $post_type) {
  if (preg_match('/(%[0-9a-f]{2})+/', $slug)) {
    $override_slug =  $post_ID;
  }
  if (preg_match('/^[0-9]+$/', $slug) && $override_slug !== (string) $post_ID) {
    $override_slug =  $post_ID;
  }
  return $override_slug;
}, 10, 5);

/**
 * パーマリンクの2バイト検証
 */
add_action("admin_notices", function () {
  global $current_page;

  if ($current_page !== "post.php") {
    return;
  }

  $post_name = get_post()->post_name;
  $decoded = urldecode($post_name);
  if (!preg_match('/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+/', $decoded)) {
    echo '<div class="message error"><p>パーマリンク（URL）に日本語が含まれています。半角英数字のみに修正してから公開してください。</p></div>';
  }
}, 10, 8);

/**
 * Openverseメデイアを無効化
 * https://www.wppagebuilders.com/disable-openverse-wordpress/
 */
add_filter('block_editor_settings_all', function ($settings) {
  $settings['enableOpenverseMediaCategory'] = false;
  return $settings;
}, 10);

/**
 * 投稿保存字に親タームを強制チェック
 */
/*
add_action('save_post', function ($post_id) {
  $post_categories = wp_get_post_terms($post_id, 'category-floor');
  foreach ($post_categories as $c) {
    $cat = get_term($c);
    while ($cat->parent != 0) {
      wp_set_post_terms($post_id, array($cat->parent), 'category-floor', true);
      $cat = get_term($cat->parent);
    }
  }
});
*/
