<footer class="footer">
  <nav class="footer__nav">
    <?php

    if (has_nav_menu('footer_navigation')) {
      wp_nav_menu([
        'theme_location' => 'footer_navigation',
        'menu_class'     => 'footer__navItems',
        'container'      => false,
        'link_before'    => '<span class="customMenuLink">',
        'link_after'     => '</span>',
        'depth'          => 1,
      ]);
    }

    ?>
  </nav>
  <p class="copyright">
    <small><?php _e('&copy; *** Co., Ltd. All Rights Reserved.', 'mytheme'); ?></small>
  </p>
</footer>
