<?php

namespace Lib\Editor;

use Lib\Helper;

/**
 * パーマリンクの2バイト検証
 *
 * @return void
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
 * ブロックエディター用カスタム JS
 * パーマリンクストラクチャーに '%postname%' を含む投稿タイプの記事編集の場合にスラッグの2バイト検証を有効化
 *
 * @return void
 */
add_action("admin_print_scripts", function () {
  global $post_type;

  $is_enable_custom_post_type_permalinks = is_plugin_active(
    "custom-post-type-permalinks/custom-post-type-permalinks.php"
  );
  $structure = get_option($post_type . "_structure");

  if (!$is_enable_custom_post_type_permalinks || $post_type === "post") {
    $structure = get_option("permalink_structure");
  }

  $is_enable = strpos($structure, "%postname%") !== false;

  if ($post_type === "page") {
    $is_enable = true;
  }

  $post_types_list = get_post_types(["public" => false]);

  if (in_array($post_type, $post_types_list, true)) {
    $is_enable = false;
  }
  // if ($structure !== false && "/%postname%/" !== $structure) return;

  $js_values = $is_enable ? "true" : "false";
  $js_values = "window.CUSTOM_THEME_SLUG_STRING_CHECK = {$js_values};";

  echo "\n<script>{$js_values}</script>\n";
  echo '<link rel="stylesheet" href="' . Helper\cache_buster('/dist/editor.css') . '" />' . "\n";
  echo '<script module src="' . Helper\cache_buster('/dist/editor.js') . '"></script>' . "\n";
}, 100);

/**
 *  ブロックエディター用カスタムスタイル
 */
add_action("admin_print_styles", function () {
  // google font
  echo "\n<link rel='stylesheet' id='custom-google-font-css' href='{GOOGLE_FONTS}' media='all' />\n";
}, 200);

/**
 * 投稿の初回保存時にページIDを設定（記事の日本語タイトルがそのままスラッグになるのを防ぐ）
 *
 * @ex https://liginc.co.jp/576942
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

// WORKAROUND: Bogoを有効にすると wp_unique_post_slug が発火しない対策
add_filter('pre_wp_unique_post_slug', function ($override_slug, $slug, $post_ID, $post_status, $post_type) {
  if (preg_match('/(%[0-9a-f]{2})+/', $slug)) {
    $override_slug =  $post_ID;
  }
  if (preg_match('/^[0-9]+$/', $slug) && $override_slug !== (string) $post_ID) {
    $override_slug =  $post_ID;
  }
  return $override_slug;
}, 10, 5);
