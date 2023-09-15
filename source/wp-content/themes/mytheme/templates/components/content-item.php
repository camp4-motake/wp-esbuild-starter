<?php

/**
 * component: カード型リンクコンテンツ
 */

use lib\Plugins\Acf;

$ctx = wp_parse_args($args, [
  'class' => '',
  'title' => get_the_title(),
  'link'  => [
    'url'   => get_the_permalink(),
    'title' => get_the_title()
  ],
  'thumbnail_id' => get_post_thumbnail_id(get_the_ID())
]);

$link_attr = Acf\make_acf_link_attr_string($ctx['link']);

$class_name = 'card';
if ($ctx['class']) {
  $class_name .= ' ' . $ctx['class'];
}

?>
<a class="<?= esc_attr($class_name); ?>" <?= $link_attr ?>>
  <figure class="card-thumbnail">
    <?php

    if (isset($ctx['thumbnail_id']) && is_int($ctx['thumbnail_id'])) {
      echo wp_get_attachment_image($ctx['thumbnail_id'], 'large');
    } else if (get_the_post_thumbnail()) {
      the_post_thumbnail('large');
    }

    ?>
  </figure>
  <div class="card-content">
    <h3 class="card-heading"><?= esc_html($ctx['title']); ?></h3>
  </div>
</a>
