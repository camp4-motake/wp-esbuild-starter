<?php

namespace Lib\Assets;

/**
 * main アセット
 */
add_action('wp_enqueue_scripts', function () {
  $manifestPath = get_theme_file_path('dist/.vite/manifest.json');

  if (wp_get_environment_type() === 'local' && file_exists(get_theme_file_path('dist/.dev'))) {
    wp_enqueue_script('vite', 'http://localhost:5173/@vite/client', array(), null);
    wp_enqueue_script(THEME_DOMAIN, 'http://localhost:5173/src/main.ts', array(), null);
  } elseif (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
    wp_enqueue_script(THEME_DOMAIN, get_theme_file_uri('dist/' . $manifest['src/main.ts']['file']));
    wp_enqueue_style(THEME_DOMAIN, get_theme_file_uri('dist/' . $manifest['src/main.ts']['css'][0]));
  }
});

/**
 * wp_enqueue_script の出力を modules の script タグに置換
 */
add_filter('script_loader_tag', function (string $tag, string $handle, string $src) {
  if (in_array($handle, ['vite', THEME_DOMAIN])) {
    return '<script type="module" src="' . esc_url($src) . '" defer></script>' . "\n";
  }
  return $tag;
}, 10, 3);
