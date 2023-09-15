<?php

use Lib\Plugins\Acf;

$ctx = wp_parse_args($args, [
  'terms' => [],
]);

if (!$ctx['terms'] || count($ctx['terms']) <= 0) {
  return;
}

?>
<div x-data="modal">
  <?php foreach ($ctx['terms'] as $term) : ?>
    <?php

    if ($term->parent > 0) continue;

    $map_img   = get_field('map_image', $term);
    $link      = get_field('link', $term);
    $link_attr = Acf\make_acf_link_attr_string($link,);

    ?>
    <?php if ($map_img) : ?>
      <button type="button" class="modal-btn-trigger link -arrow-right" x-bind="modalTrigger"><span><?= esc_html($term->name); ?></span></button>
      <dialog class="modal" x-bind="modalDialog">
        <div class="modal-content" data-modal-content>
          <h3 class="heading h6">
            <?php if (get_field('shop_id')) : ?><span class="id-badge mr-xs"><?php the_field('shop_id') ?></span><?php endif; ?>
            <?php the_title(); ?>
          </h3>
          <figure class="modal-map-figure"><?= wp_get_attachment_image($map_img, 'full'); ?></figure>
          <?php if ($link_attr) : ?>
            <p class="mt-md mb-sm text-center"><a class="btn -reverse -sm -arrow-right" <?= $link_attr ?>><?php _e('フロアガイド', 'mytheme'); ?></a></p>
          <?php endif; ?>
          <div class="modal-btn-sticky">
            <button class="modal-close" type="button" x-bind="modalClose"><?php _e('閉じる', 'mytheme'); ?></button>
          </div>
        </div>
      </dialog>
    <?php elseif ($link_attr) : ?>
      <a class="link -arrow-right" <?= $link_attr ?>><?= esc_html($term->name); ?></a>
    <?php else : ?>
      <span><?= esc_html($term->name); ?></span>
    <?php endif; ?>
  <?php endforeach; ?>
</div>
