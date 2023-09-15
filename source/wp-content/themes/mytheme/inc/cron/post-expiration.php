<?php

/**
 * wp-cronで期限切れ投稿を非表示
 */

namespace Lib\PostExpiration;

/**
 * initアクションにcronイベントを登録
 */
add_action('init', function () {
  $timestamp = wp_next_scheduled('dp_expired_posts');
  if ($timestamp === false) {
    wp_schedule_event(time(), '2min', 'dp_expired_posts');
  }
});

/**
 * 定期的に削除対象の投稿抽出
 * - 投稿をループし、draft_the_post関数を呼び出します。
 */
add_action('dp_expired_posts', function () {
  $post_types = get_post_types([
    'public'   => true,
    '_builtin' => false
  ]);
  $posts = get_posts([
    'posts_per_page' => -1,
    'post_type'      => $post_types,
    'post_status'    => 'publish',
    'meta_query'     => [[
      'key'     => 'expire_datetime',
      'value'   => null,
      'compare' => 'NOT IN'
    ]]
  ]);
  if (!$posts) {
    return;
  }
  foreach ($posts as $_post) {
    maybe_draft_the_post($_post);
  }
});

/**
 * 期限切れ投稿を下書きに変更する
 *
 * @requires ACF Pro
 * @param \WP_Post $_post
 */
function maybe_draft_the_post($_post)
{
  if (!function_exists('get_field')) {
    return;
  }
  $expire_date = get_field("expire_datetime", $_post->ID); // カスタムフィールド
  // Bail if no expire date set.
  if (!$expire_date) {
    return;
  }
  $expire_date = strtotime($expire_date);
  $actual_date = strtotime(date_i18n('Y-m-d H:i:s'));
  if ($expire_date <= $actual_date) {
    wp_update_post(array(
      'ID'          => $_post->ID,
      'post_status' => 'draft'
    ));
  }
}
