<?php

/**
 *  Template: General Information Page
 */

$post_type = 'general-information';
$tax       = 'category-general-information';
$terms     = get_terms($tax, ['hide_empty' => true]);

?>
<section class="section pt-0 container -max-entry">
  <?php if (!$terms) get_template_part('templates/components/no-posts'); ?>
  <?php foreach ($terms as $term) : ?>
    <?php

    $the_query = new WP_Query([
      'post_type' => $post_type,
      'posts_per_page' => 50,
      'tax_query' => [
        'relation' => 'AND',
        ['taxonomy' => $tax, 'field' => 'id', 'terms' => [$term->term_id]]
      ]
    ]);

    ?>
    <?php if ($the_query->have_posts()) : ?>
      <section class="section -gutter-md">
        <h2 class="heading -display-4"><?= esc_html($term->name); ?></h2>
        <ul class="link-list -is-arrow-right">
          <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
            <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
          <?php endwhile; ?>
        </ul>
      </section>
    <?php endif;  ?>
  <?php endforeach; ?>
  <?php wp_reset_postdata(); ?>
</section>
