<?php

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

global $wp_query;
global $post;

$post_type = !empty($wp_query->query['post_type'])
  ? $wp_query->query['post_type']
  : get_post_type();

if (is_front_page() || is_home()) {
  get_template_part('templates/front-page', $post_type);
} elseif (is_page()) {
  get_template_part('templates/page', $post->post_name);
} elseif (is_singular()) {
  get_template_part('templates/single', $post_type);
} elseif (is_archive()) {
  get_template_part('templates/archive', $post_type);
} elseif (is_search()) {
  get_template_part('templates/search');
} else {
  get_template_part('templates/404');
}
