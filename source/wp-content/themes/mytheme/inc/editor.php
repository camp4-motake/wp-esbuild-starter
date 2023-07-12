<?php

namespace Lib\Editor;

use Lib\Helper\Path;

/**
 * allowed_block_types_all
 * @see https://developer.wordpress.org/reference/hooks/allowed_block_types_all/
 */
// add_filter('allowed_block_types_all', function ($allowed_block_types, $block_editor_context) {
//   return [
//     'core/image',
//     'core/paragraph',
//     'core/heading',
//     'core/list',
//     'core/list-item'
//   ];
// }, 25, 2);

/**
 * ブロックエディター用カスタム JS
 *
 * @return void
 */
add_action("admin_print_scripts", function () {
  $n = "\n";
  echo $n;

  // TODO
  // if (IS_ENABLE_GOOGLE_FONTS && count(GOOGLE_FONTS) > 0) {
  //   foreach (GOOGLE_FONTS as fonts) {
  //     echo "<link rel='stylesheet' id='custom-google-font-css' href='{fonts}' media='all' />" . $n;
  //   }
  // }

  echo '<link rel="stylesheet" href="' . Path\cache_buster('/dist/editor.css') . '" />' . $n;
  echo '<script module src="' . Path\cache_buster('/dist/editor.js') . '"></script>' . $n;
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
    return $post_ID;
  }
  if ($is_slug_invalid) {
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
