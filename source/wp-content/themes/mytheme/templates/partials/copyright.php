<?php

$ctx = wp_parse_args($args, [
  'class' => ''
]);

$class_name = 'copyright';
if ($ctx['class']) {
  $class_name .= ' ' . esc_attr($ctx['class']);
}

$year = (int) date('Y');
if ($year > 2023) {
  $year = '2023-' . $year;
}

?>
<p class="<?= $class_name ?>">
  <small class="notranslate">&copy;<?= $year . ' ' . __('corp name Co., Ltd. All Rights Reserved.', 'mytheme'); ?></small>
</p>
