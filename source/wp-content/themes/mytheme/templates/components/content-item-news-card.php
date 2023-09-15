<a href="<?php the_permalink(); ?>" class="card">
  <figure class="card-thumbnail"><?php the_post_thumbnail(); ?></figure>
  <div class="card-content">
    <h3 class="card-heading"><?php the_title(); ?></h3>
    <?php get_template_part('templates/components/entry-meta'); ?>
  </div>
</a>
