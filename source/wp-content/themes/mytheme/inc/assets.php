<?php

namespace Lib\Assets;

/**
 * main アセット
 */
add_action('wp_enqueue_scripts', function () {
  $manifestPath = get_theme_file_path('dist/.vite/manifest.main.json');
  $is_dev = wp_get_environment_type() === 'local' && file_exists(get_theme_file_path('dist/.dev'));

  if ($is_dev) :

    // dev: vite client
    wp_enqueue_script('vite', 'http://localhost:5173/@vite/client', [], null);
    wp_enqueue_script(THEME_DOMAIN, 'http://localhost:5173/src/main.ts', [], null);

  elseif (file_exists($manifestPath)) :

    // prod:
    $manifest = json_decode(file_get_contents($manifestPath), true);
    $styles   = $manifest['src/main.ts']['css'];

    foreach ($styles as $i => $css) {
      wp_enqueue_style(str_replace('.css', '', $css), get_theme_file_uri('dist/' . $css), [], null);
    }
    wp_enqueue_script(THEME_DOMAIN, get_theme_file_uri('dist/' . $manifest['src/main.ts']['file']), [], null);

  endif;
}, 100);

/**
 * ブロックライブラリスタイルを削除
 */
add_action('wp_enqueue_scripts', function () {
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
}, 100);

/**
 * wp_enqueue_script の出力を modules の script タグに置換
 */
add_filter('script_loader_tag', function (string $tag, string $handle, string $src) {
  if (in_array($handle, ['vite', THEME_DOMAIN])) {
    return '<script type="module" src="' . esc_url($src) . '" defer></script>' . "\n";
  }
  return $tag;
}, 10, 3);
