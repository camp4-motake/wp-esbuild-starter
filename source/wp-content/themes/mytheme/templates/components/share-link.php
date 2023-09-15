<?php

use Lib\Helper\Path;
use Lib\Helper\Util;

$ctx = wp_parse_args($args, [
  'class' => '',
  'align' => ''
]);

$class_name = 'share-links';
if ($ctx['class']) $class_name .= ' ' . $ctx['class'];
if ($ctx['align']) $class_name .= ' -' . $ctx['align'];

$links   = Util\get_share_links();
$targets = ['twitter', 'facebook'];

?>
<div class="<?= esc_attr($class_name); ?>">
  <span class="share-links-label">SHARE</span>
  <?php foreach ($targets as $k) : ?>
    <a href="<?= esc_url($links[$k]); ?>" class="share-link" target="_blank" rel="noopener noreferrer"><img src="<?= Path\cache_buster('dist/images/sns/' . esc_attr($k) . '.svg'); ?>" width="48" height="48" alt="<?= esc_attr($v['label']) ?>" decoding="async"></a>
  <?php endforeach; ?>
</div>
