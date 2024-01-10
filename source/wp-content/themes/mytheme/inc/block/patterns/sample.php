<?php

// サンプル
return array(
	'title'       => __( 'Button Long', 'mytheme' ),
	'categories'  => array( THEME_DOMAIN . '-custom' ),
	'description' => __( 'long center button', 'mytheme' ),
	'content'     => '
    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline isLong"} -->
    <div class="wp-block-button is-style-outline isLong"><a class="wp-block-button__link">link</a></div>
    <!-- /wp:button --></div>
    <!-- /wp:buttons -->
',
);
