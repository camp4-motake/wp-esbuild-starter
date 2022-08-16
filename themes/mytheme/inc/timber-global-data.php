<?php

namespace Lib\Timber\GlobalData;

if (!class_exists('Timber') || !function_exists('get_field')) {
  return;
}

/**
 * global context
 *
 * @see https://timber.github.io/docs/guides/menus/#setting-up-a-menu-globally
 */
add_action('timber/context', function ($context) {
  $context['primary_navigation'] = new \Timber\Menu('primary_navigation', [
    'depth' => 1,
  ]);

  return $context;
});
