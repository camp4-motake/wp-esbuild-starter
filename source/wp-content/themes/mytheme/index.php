<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

global $post_type;

if (is_front_page() || is_home()) {
  get_template_part('templates/front-page');
} elseif (is_page()) {
  global $post;
  get_template_part('templates/page', $post->post_name);
} elseif (is_singular()) {
  get_template_part('templates/single', $post_type);
} elseif (is_tax()) {
  if (get_query_var('post_type')) {
    get_template_part('templates/archive', get_query_var('post_type'));
  } else {
    $tax_slug = get_query_var('taxonomy');
    get_template_part('templates/taxonomy', $tax_slug);
  }
} elseif (is_archive()) {
  get_template_part('templates/archive', $post_type);
} elseif (is_search()) {
  get_template_part('templates/search');
} else {
  get_template_part('templates/404');
}
