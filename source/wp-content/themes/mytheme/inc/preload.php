<?php

namespace Lib\Preload;

/**
 * アセットキューから preload を生成
 */
add_action("wp_head", function () {
  global $wp_version;
  global $wp_styles;
  global $wp_scripts;

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
    }/*  */

    echo '<link rel="preload" as="style" href="' . esc_url($src) . '">' . "\n";
  }

  // preload as script
  foreach ($wp_scripts->queue as $handle) {
    if ($wp_scripts->registered[$handle]->handle === "polyfill") {
      continue;
    }

    $src = $wp_scripts->registered[$handle]->src;
    $ver = $wp_scripts->registered[$handle]->ver;

    if (strpos($src, "/wp-includes") === 0) {
      $src = $wp_scripts->base_url . $src . "?ver=" . $wp_version;
    } elseif (!empty($ver)) {
      $src .= "?ver=" . $ver;
    }

    if (strpos($handle, "nomodule/") !== false) {
      continue;
    }

    if (strpos($handle, "modules/") !== false) {
      echo '<link rel="modulepreload" href="' . esc_url($src) . '">' . "\n";
      continue;
    }

    echo '<link rel="preload" as="script" href="' . esc_url($src) . '">' . "\n";
  }
}, 2, 1);

/**
 * script loader tag に module　属性を追加
 */
// add_filter("script_loader_tag", function ($tag /* , $handle */) {
//   if (is_admin()) {
//     return $tag;
//   }

//   $replace = $tag;

//   if (
//     preg_match("/module\//", $replace) &&
//     preg_match("/text\/javascript/", $replace)
//   ) {
//     return str_replace("text/javascript", "module", $replace);
//   }

//   if (preg_match("/nomodule\//", $replace)) {
//     // $replace = str_replace('<script ', '<script nomodule ', $replace);
//     $replace = str_replace("type='text/javascript'", "nomodule", $replace);
//   }

//   return $replace;
// }, 10, 2);
