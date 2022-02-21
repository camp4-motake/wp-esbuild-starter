<?php

namespace Lib\Editor;

/**
 * パーマリンクの2バイト検証
 *
 * @return void
 */
add_action('admin_notices', function () {
  global $current_page;

  if ($current_page !== 'post.php') {
    return;
  }

  $post_name = get_post()->post_name;
  $decoded = urldecode($post_name);
  if (!preg_match('/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+/', $decoded)) {
    echo '<div class="message error"><p>パーマリンク（URL）に日本語が含まれています。半角英数字のみに修正してから公開してください。</p></div>';
  }
});

/**
 * ブロックエディター用カスタム JS
 * パーマリンクストラクチャーに '%postname%' を含む投稿タイプの記事編集の場合にスラッグの2バイト検証を有効化
 *
 * @return void
 */
add_action(
  'admin_print_scripts',
  function () {
    global $post_type;

    $is_enable_custom_post_type_permalinks = is_plugin_active(
      'custom-post-type-permalinks/custom-post-type-permalinks.php'
    );
    $structure = get_option($post_type . '_structure');

    if (!$is_enable_custom_post_type_permalinks || $post_type === 'post') {
      $structure = get_option('permalink_structure');
    }

    $is_enable = strpos($structure, '%postname%') !== false;

    if ($post_type === 'page') {
      $is_enable = true;
    }

    $post_types_list = get_post_types(['public' => false]);

    if (in_array($post_type, $post_types_list, true)) {
      $is_enable = false;
    }
    // if ($structure !== false && "/%postname%/" !== $structure) return;

    $js_values = $is_enable ? 'true' : 'false';
    $js_values = "window.CUSTOM_THEME_SLUG_STRING_CHECK = {$js_values};";

    echo "\n<script>{$js_values}</script>\n";
    echo "<script src='" .
      get_template_directory_uri() .
      '/editor/editor.js' .
      "' id='modules/custom-editor-script-js'></script>\n";
  },
  100
);

/**
 *  ブロックエディター用カスタムスタイル
 */
add_action(
  'admin_print_styles',
  function () {
    $theme_uri = get_template_directory_uri();
    echo "\n<link rel='stylesheet' id='custom-editor-css' href='{$theme_uri}'/editor/editor.css' media='all' />\n";
  },
  200
);
