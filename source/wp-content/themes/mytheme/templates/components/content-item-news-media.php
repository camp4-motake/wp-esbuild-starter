<a href="<?php the_permalink(); ?>" class="media">
  <figure class="media-thumbnail"><?php the_post_thumbnail(); ?></figure>
  <div class="media-content">
    <div class="media-category"><?php get_template_part('templates/components/badge-loop'); ?></div>
    <h2 class="media-heading"><?php the_title(); ?></h2>
    <?php get_template_part('templates/components/entry-meta'); ?>
  </div>
</a>
