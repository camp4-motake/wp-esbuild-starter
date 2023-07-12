<?php

/**
 * トラッキングコード
 */

namespace Lib\Tracking;

/**
 * head 内のタグ
 */
add_action("wp_head", function () {
  if (is_user_logged_in() || !IS_ENABLE_GTM_TRACKING) {
    return;
  }
  echo <<<EOM
EOM;
});

/**
 * body タグ直後に追加するタグ（GTM の noscript タグなど）
 */
add_action("body_tag_before", function () {
  if (is_user_logged_in() || !IS_ENABLE_GTM_TRACKING) {
    return;
  }
  echo <<<EOM
EOM;
});
