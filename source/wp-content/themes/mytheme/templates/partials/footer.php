<footer class="footer">
  <?php

  if (has_nav_menu('nav_footer')) {
    wp_nav_menu([
      'theme_location' => 'nav_footer',
      'menu_class'     => 'nav-footer',
      'container'      => false,
      'link_before'    => '',
      'link_after'     => '',
      'depth'          => 1,
    ]);
  }

  ?>
  <?php get_template_part('templates/partials/copyright', null, ['class' => 'container -max-lg']); ?>
</footer>
