<?php

$context = Timber::context();
$templates = ["front-page.twig", "home.twig"];

Timber::render($templates, $context);
