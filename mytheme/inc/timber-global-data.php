<?php

namespace Lib\Timber\GlobalData;

if (!class_exists('Timber')) {
  return;
}

/**
 * global context
 *
 * @see https://timber.github.io/docs/guides/menus/#setting-up-a-menu-globally
 */
add_action('timber/context', function ($context) {
  $context['menu'] = new \Timber\Menu('primary-menu');
  $context['env'] = [
    'home_url' => home_url(),
    'theme_url' => get_template_directory_uri(),
  ];
  return $context;
});
