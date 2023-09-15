<?php

/**
 * トラッキングコード
 *
 * 表示するには constant.php で IS_ENABLE_GTM_TRACKING のフラグを有効にする
 */

namespace Lib\Tracking;

use Lib\Helper\Env;

/**
 * head 内のタグ
 */
add_action("wp_head", function () {
  if (!is_gtm_active()) {
    return;
  }
  echo <<<EOM
  <!-- gtm tag -->
  EOM;
});

/**
 * body タグ直後に追加するタグ（GTM の noscript タグなど）
 */
add_action("wp_body_open", function () {
  if (!is_gtm_active()) {
    return;
  }
  echo <<<EOM
  <!-- noscript -->
  EOM;
});

/**
 * GTMのresource hints 追加
 */
add_filter("wp_resource_hints", function ($hints, $relation_type) {
  if (!is_admin() && "dns-prefetch" === $relation_type && is_gtm_active()) {
    $hints[] = "https://www.googletagmanager.com";
  }
  return $hints;
}, 10, 2);

/**
 * GTM 有効可否判定
 *
 * @return boolean
 */
function is_gtm_active()
{
  return IS_ENABLE_GTM_TRACKING && Env\in_production() && !is_user_logged_in();
}
