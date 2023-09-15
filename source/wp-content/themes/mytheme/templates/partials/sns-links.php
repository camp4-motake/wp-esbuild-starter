<?php

use Lib\Helper\Path;

$sns = [
  'twitter'   => ['href' => '#0', 'label' => 'Twitter'],
  'instagram' => ['href' => '#0', 'label' => 'Instagram'],
  'facebook'  => ['href' => '#0', 'label' => 'Facebook'],
];

?>
<ul class="sns-links">
  <?php foreach ($sns as $k => $v) : ?>
    <li><a title="<?= esc_attr($v['label']) ?>" href="<?= esc_url($v['href']) ?>" target="_blank" rel="noopener noreferrer"><img src="<?= Path\cache_buster('dist/images/sns/' . esc_attr($k) . '.svg'); ?>" width="48" height="48" alt="<?= esc_attr($v['label']) ?>" decoding="async"></a></li>
  <?php endforeach; ?>
</ul>
