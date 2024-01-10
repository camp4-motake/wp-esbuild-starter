<?php

$site_name = get_bloginfo( 'name' );

?>
<header class="header">
	<div class="header-container">
	<a href="<?php echo home_url(); ?>" class="header-brand" title="<?php echo esc_html( $site_name ); ?>"><?php echo esc_html( $site_name ); ?></a>
	<div class="header-body">
		<nav>
		<?php

		if ( has_nav_menu( 'nav_header_primary' ) ) {
			wp_nav_menu(
				array(
					'theme_location' => 'nav_header_primary',
					'menu_class'     => 'header-nav',
					'menu_id'        => '',
					'container'      => false,
					'link_before'    => '',
					'link_after'     => '',
					'depth'          => 1,
				)
			);
		}

		?>
		</nav>
		<?php
		/*
		<button type="button" class="menu-toggle" title="Menu Open" x-data="menuToggle" x-bind="toggle">
		<i class="menu-toggle-image -toggle" role="presentation"><?= Image\inline_svg('dist/images/menu-toggle.svg');  ?></i>
		<i class="menu-toggle-image -close" role="presentation"><?= Image\inline_svg('dist/images/menu-close.svg');  ?></i>
		</button>
		*/
		?>
	</div>
	</div>
</header>
<div data-header-trigger></div>
<div data-modal-overlay></div>
<?php get_template_part( 'templates/partials/nav-primary' ); ?>
