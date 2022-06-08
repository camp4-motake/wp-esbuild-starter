<?php

$timber_post = Timber::query_post();

$context = Timber::context();
$context['posts'] = new Timber\PostQuery();

$template_slug = $timber_post->post_type ?: get_query_var('post_type') ?: '';
$templates = ['archive-' . $template_slug . '.twig', 'archive.twig'];

Timber::render($templates, $context);
