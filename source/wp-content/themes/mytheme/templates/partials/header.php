<?php

use Lib\Helper\Image;
use Lib\Helper\Path;

$site_name = get_bloginfo('name');

?>
<header class="header">
  <div class="header-container">
    <a href="<?= home_url(); ?>" class="header-brand" title="<?= esc_html($site_name); ?>">
      <img src="<?= Path\cache_buster('dist/images/logo-brand.svg') ?>" width="246" height="32" alt=" <?= esc_html($site_name); ?>" decoding="async">
    </a>
    <div class="header-body">
      <nav>
        <?php

        if (has_nav_menu('nav_header_primary')) {
          wp_nav_menu([
            'theme_location' => 'nav_header_primary',
            'menu_class'     => 'header-nav',
            'menu_id'        => '',
            'container'      => false,
            'link_before'    => '',
            'link_after'     => '',
            'depth'          => 1,
          ]);
        }

        ?>
      </nav>
      <button type="button" class="menu-toggle" title="Menu Open" x-data="menuToggle" x-bind="toggle">
        <i class="menu-toggle-image -toggle" role="presentation"><?= Image\inline_svg('dist/images/menu-toggle.svg');  ?></i>
        <i class="menu-toggle-image -close" role="presentation"><?= Image\inline_svg('dist/images/menu-close.svg');  ?></i>
      </button>
    </div>
  </div>
</header>
<div data-header-trigger></div>
<div data-modal-overlay></div>
<?php get_template_part('templates/partials/nav-primary'); ?>
