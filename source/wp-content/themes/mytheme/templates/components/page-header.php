<?php

$ctx = wp_parse_args($args, [
  'tag'   => 'h1',
  'title' => get_the_title(),
  'sub'   => '',
]);

$tag = esc_attr($ctx['tag']);

?>
<div class="page-header">
  <?= '<' . $tag . ' class="page-header-heading h1">' ?>
  <span class="page-header-title"><span><?= esc_html($ctx['title']) ?></span></span>
  <?php if (!empty($ctx['sub'])) : ?>
    <small class="page-header-subtitle"><span><?= esc_html($ctx['sub']) ?></span></small>
  <?php endif; ?>
  <?= '</' . $tag . '>' ?>
</div>
