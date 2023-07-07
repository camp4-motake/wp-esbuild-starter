<?php

namespace Lib\BlockPatterns;

add_action("after_setup_theme", function () {
  cleanup_core_pattern();
  custom_block_pattern_category();
  custom_block_patterns();
});

/**
 * WPコアブロックパターン削除
 */
function cleanup_core_pattern()
{
  remove_theme_support("core-block-patterns");
}


/**
 * カスタムパターンカテゴリーを追加
 */
function custom_block_pattern_category()
{
  register_block_pattern_category(THEME_DOMAIN . "-custom", [
    "label" => __(THEME_NAME, THEME_DOMAIN),
  ]);
}

/**
 * カスタムパターン登録
 */
function custom_block_patterns()
{
  $block_patterns = ["button"];
  $block_patterns = apply_filters(THEME_DOMAIN . "_custom_block_patterns", $block_patterns);

  foreach ($block_patterns as $block_pattern) {
    $pattern_file = get_theme_file_path("/inc/block/patterns/" . $block_pattern . ".php");

    register_block_pattern(
      THEME_DOMAIN . "-theme/" . THEME_DOMAIN . "-" . $block_pattern,
      require $pattern_file
    );
  }
}
