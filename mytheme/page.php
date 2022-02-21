<?php while (have_posts()):
  the_post(); ?>
  <?php $slug = get_post()->post_name; ?>
  <?php get_template_part('templates/partials/page-header'); ?>
  <?php get_template_part('templates/content-page', $slug); ?>
<?php
endwhile; ?>
