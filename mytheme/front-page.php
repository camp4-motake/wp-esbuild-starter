<?php

$context = Timber::context();
/*
$context['work_posts'] = Timber::get_posts([
  'post_type' => 'some_post_tye',
  'posts_per_page' => 5,
]);
 */
$templates = ['front-page.twig', 'home.twig'];

Timber::render($templates, $context);
