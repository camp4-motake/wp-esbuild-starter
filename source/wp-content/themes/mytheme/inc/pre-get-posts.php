<?php

namespace Lib\Hooks\PreGetPosts;

add_action("pre_get_posts", function ($query) {
  if (is_admin() || !$query->is_main_query()) {
    return;
  }
  // ...
});
