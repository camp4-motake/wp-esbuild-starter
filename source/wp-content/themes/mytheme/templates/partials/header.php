<?php

?>
<header class="header">
  <div class="header__container">
    <a href="<?= home_url(); ?>" class="header__brand"></a>
  </div>
</header>
<div data-header-trigger></div>

<div data-modal-overlay></div>
<div class="navPrimaryLayer" x-cloak>
  <nav class="navPrimary" x-data="navPrimary" x-bind="navPrimary">
    <div class="navPrimary__body">
      <?php

      if (has_nav_menu('primary_navigation')) {
        wp_nav_menu([
          'theme_location' => 'primary_navigation',
          'menu_class'     => 'navPrimary__links',
          'container'      => false,
          'link_before'    => '<span class="customMenuLink">',
          'link_after'     => '</span>',
          'depth'          => 1,
        ]);
      }

      ?>
    </div>
  </nav>
</div>
