<?php

namespace Lib\Helper\Conditional;

/**
 * 開発環境判定
 *
 * @return boolean
 */
function is_dev()
{
  $host = $_SERVER["HTTP_HOST"];
  return WP_DEBUG && (strpos($host, "localhost") !== false);
}

/**
 * 固定ページの存在確認
 *
 * @param [type] $slug
 * @return boolean
 */
function is_exist_page($slug)
{
  $post_id = get_page_by_path("/${slug}");
  return !empty($post_id);
}

/**
 * 固定ページの子ページ判定
 *
 * @param [type] $slug 固定ページスラッグ
 * @return boolean
 */
function is_page_child($slug = null)
{
  if (!is_page()) {
    return false;
  }

  global $post;

  $parent_id = $post->post_parent;
  $parent_slug = get_post($parent_id)->post_name;

  if ($parent_slug === $slug) {
    return is_page() && $post->post_parent;
  }
  return false;
}
