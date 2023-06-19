<?php

$ctx = wp_parse_args($args, [
  'hd'   => 'h1',
  'lead' =>  '',
  'sub'  => '',
]);

?>
<div class="pageHeader" x-data="inView" x-bind="trigger">
  <?= '<' . $ctx['hd'] . ' class="pageHeader__heading">' ?>
  <span class="pageHeader__heading__title"><span><?= esc_html($ctx['lead']) ?></span></span>
  <?php if (!empty($ctx['sub'])) : ?>
    <small class="pageHeader__heading__subTitle"><span><?= esc_html($ctx['sub']) ?></span></small>
  <?php endif; ?>
  <?= '</' . $ctx['hd'] . '>' ?>
</div>
