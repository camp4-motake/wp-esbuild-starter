<nav>
	<?php

	if ( has_nav_menu( 'nav_primary' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => 'nav_primary',
				'menu_class'     => 'nav-primary',
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
