<?php
/**
 * Base Layout
 *
 * @package mytheme
 */

use Lib\Wrapper;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'get_field' ) ) {
	echo 'required: ACF Pro';
	exit;
}

global $post_type;

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> x-data="app" x-bind="root">
<?php get_template_part( 'templates/partials/head' ); ?>

<body <?php body_class(); ?>>
	<?php

	wp_body_open();

	do_action( 'get_header' );
	get_template_part( 'templates/partials/header', $post_type );

	?>
	<main class="contents">
	<?php require Wrapper\template_path(); ?>
	</main>
	<?php

	do_action( 'get_footer' );
	get_template_part( 'templates/partials/footer', $post_type );

	wp_footer();

	?>
</body>

</html>
