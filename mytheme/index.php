<?php

$context = Timber::context();
$context['posts'] = new Timber\PostQuery();
$templates = ['archive.twig'];

Timber::render($templates, $context);
