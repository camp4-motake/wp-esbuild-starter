<?php

namespace Lib\Vite;

define('VITE_ASSETS_DIR', ASSETS_DIR_URI);

add_action(
  'wp_head',
  function () {
    echo vite('src/main.js');
  },
  8
);

add_action(
  'wp_enqueue_scripts',
  function () {
    cssEnqueue('src/main.js');
  },
  100
);

function vite(string $entry): string
{
  return jsTag($entry) . "\n" . jsPreloadImports($entry);
  // "\n" . cssPreloadTag($entry) .
  // "\n" . cssTag($entry);
}

// Some dev/prod mechanism would exist in your project
function isDev(): bool
{
  return !file_exists(ASSETS_DIR_PATH . 'manifest.json');
}

// Helpers to print tags
function jsTag(string $entry): string
{
  $host = '/'; // 'http://localhost:3000/'
  $url = isDev() ? $host . $entry : assetUrl($entry);

  return $url
    ? "<script type=\"module\" crossorigin src=\"{$url}\"></script>"
    : '';
}

function jsPreloadImports(string $entry): string
{
  if (isDev()) {
    return '';
  }
  $res = '';
  foreach (importsUrls($entry) as $url) {
    $res .= '<link rel="modulepreload" href="' . $url . '">';
  }
  return $res;
}

// add enqueue
function cssEnqueue(string $entry): void
{
  if (isDev()) {
    return;
  }
  foreach (cssUrls($entry) as $index => $url) {
    $num = $index ? '-' . ($index + 1) : '';
    $id = str_replace('.', '-', $entry . $num);
    wp_enqueue_style($id, $url, false, null);
  }
}

function cssTag(string $entry): string
{
  // not needed on dev, it's inject by Vite
  if (isDev()) {
    return '';
  }

  $tags = '';
  foreach (cssUrls($entry) as $url) {
    $tags .= '<link rel="stylesheet" href="' . $url . '">';
  }
  return $tags;
}

function cssPreloadTag(string $entry): string
{
  // not needed on dev, it's inject by Vite
  if (isDev()) {
    return '';
  }

  $tags = '';
  foreach (cssUrls($entry) as $url) {
    $tags .= '<link rel="preload" as="style" href="' . $url . '">';
  }
  return $tags;
}

// Helpers to locate files

function getManifest(): array
{
  $manifest = ASSETS_DIR_PATH . 'manifest.json';

  if (!file_exists($manifest)) {
    return [];
  }

  $content = file_get_contents($manifest);

  return json_decode($content, true);
}

function assetUrl(string $entry): string
{
  $manifest = getManifest();

  return isset($manifest[$entry])
    ? VITE_ASSETS_DIR . $manifest[$entry]['file']
    : '';
}

function importsUrls(string $entry): array
{
  $urls = [];
  $manifest = getManifest();

  if (!empty($manifest[$entry]['imports'])) {
    foreach ($manifest[$entry]['imports'] as $imports) {
      $urls[] = VITE_ASSETS_DIR . $manifest[$imports]['file'];
    }
  }
  return $urls;
}

function cssUrls(string $entry): array
{
  $urls = [];
  $manifest = getManifest();

  if (!empty($manifest[$entry]['css'])) {
    foreach ($manifest[$entry]['css'] as $file) {
      $urls[] = VITE_ASSETS_DIR . $file;
    }
  }
  return $urls;
}
