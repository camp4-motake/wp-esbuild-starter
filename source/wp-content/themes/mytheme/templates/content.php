<?php

$image_class = '';

if (has_post_thumbnail()) {
    $image_class = ' content__link--thumbnail';
}

?>
<article class="content">
  <a href="<?php the_permalink(); ?>" class="content__link<?= $image_class ?>">
    <figure class="content__thumbnail">
      <?php the_post_thumbnail('large'); ?>
    </figure>
    <div class="content__body">
      <h3 class="content__heading line-clamp">
        <?php the_title(); ?>
      </h3>
      <div class="content__meta">
        <time class="updated line-clamp line-clamp--1"><?= get_the_date('M, j, Y') ?></time>
        <div class="line-clamp">
          <?php the_excerpt(); ?>
        </div>
      </div>
    </div>
  </a>
</article>
