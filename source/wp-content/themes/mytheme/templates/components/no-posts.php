<?php

$ctx = wp_parse_args($args, ['no_post_label' => 'coming soon']);

?>
<p class="text-center">
  <small class="roundLabel"><?= esc_html($ctx['no_post_label']); ?></small>
</p>
