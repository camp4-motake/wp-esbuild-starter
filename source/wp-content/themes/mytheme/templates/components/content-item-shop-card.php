<?php

$post_id = get_the_ID();

?>
<article class="id-content">
  <a href="<?php the_permalink(); ?>" class="id-content-link">
    <div class="id-content-badge">
      <?php if (get_field('shop_id', $post_id)) : ?>
        <span class="id-badge"><?php the_field('shop_id', $post_id); ?></span>
      <?php endif; ?>
    </div>
    <div class="id-content-body">
      <h4 class="id-content-heading"><?php the_title(); ?></h4>
      <p class="id-content-shoulder"><?php the_field('shoulder_text', $post_id); ?></p>
    </div>
  </a>
</article>
