<?php

global $post_type;

if (!$post_type) {
  if (!empty($wp_query->query['post_type'])) {
    $post_type = $wp_query->query['post_type'];
  } else {
    $post_type = get_post_type();
  }
}

$ctx = wp_parse_args($args, [
  'lead_title' => '',
  'sub_title'  => '',
]);

get_template_part('templates/components/page-header', null, [
  'lead' => $ctx['lead_title'],
  'sub'  => $ctx['sub_title']
]);

?>
<section class="section container container--max-lg">
  <?php while (have_posts()) : the_post(); ?>
    <?php get_template_part('templates/content', $post_type); ?>
  <?php endwhile; ?>
  <?php if (!have_posts()) {
    get_template_part('templates/components/no-posts');
  } ?>
</section>

<?php get_template_part('templates/components/pagination'); ?>
