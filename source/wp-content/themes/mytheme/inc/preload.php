<?php

namespace Lib\Preload;

/**
 * WP アセットキューの preload を追加
 */
add_action("wp_head", function () {
  preload_styles();
  preload_scripts();
}, 2, 1);

/**
 * style preload を生成
 */
function preload_styles()
{
  global $wp_styles, $wp_version;

  // wp optimize only
  $is_wpo_html_minify = false;
  $wpo_option = get_option("wpo_minify_config");
  if (!empty($wpo_option)) {
    $is_wpo_html_minify = $wpo_option["enabled"] && $wpo_option["html_minification"];
  }

  // preload as style
  foreach ($wp_styles->queue as $handle) {
    $src = $wp_styles->registered[$handle]->src;
    $ver = $wp_styles->registered[$handle]->ver;

    if (empty($src)) {
      continue;
    }
    if (strpos($src, "/wp-includes") === 0) {
      $src = $wp_styles->base_url . $src;

      if (!$is_wpo_html_minify) {
        $src .= "?ver=" . $wp_version;
      }
    } elseif (!empty($ver)) {
      $src .= "?ver=" . $ver;
    }
    if (0 === strpos($src, "?")) {
      continue;
    }
    echo '<link rel="preload" as="style" href="' . esc_url($src) . '">' . "\n";
  }
}

/**
 * script preload を生成
 */
function preload_scripts()
{
  global $wp_scripts, $wp_version;

  // preload as script
  foreach ($wp_scripts->queue as $handle) {
    if (in_array($handle, ['vite', THEME_DOMAIN])) {
      continue;
    }

    $src = $wp_scripts->registered[$handle]->src;
    $ver = $wp_scripts->registered[$handle]->ver;

    if (strpos($src, "/wp-includes") === 0) {
      $src = $wp_scripts->base_url . $src . "?ver=" . $wp_version;
    } elseif (!empty($ver)) {
      $src .= "?ver=" . $ver;
    }
    /*
    if (strpos($handle, "nomodule/") !== false) {
      continue;
    }
    if (strpos($handle, "modules/") !== false) {
      echo '<link rel="modulepreload" href="' . esc_url($src) . '">' . "\n";
      continue;
    }
    */
    echo '<link rel="preload" as="script" href="' . esc_url($src) . '">' . "\n";
  }
}
