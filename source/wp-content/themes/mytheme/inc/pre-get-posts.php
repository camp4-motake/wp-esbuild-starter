<?php

namespace Lib\Hooks\PreGetPosts;

add_action("pre_get_posts", __NAMESPACE__ . "\custom_post_query");
function custom_post_query($query)
{
  if (is_admin() || !$query->is_main_query()) {
    return;
  }
  // if ($query->is_archive()) {
  //   if ($query->is_archive("items")) {
  //     $query->set("posts_per_page", 36);
  //   } else {
  //     $query->set("posts_per_page", 30);
  //   }
  // }
}
