<?php
/**
 * Archive
 *
 * @package mytheme
 */

$current_post_type = get_post_type();

if ( ! $current_post_type ) {
	if ( ! empty( $wp_query->query['post_type'] ) ) {
		$current_post_type = $wp_query->query['post_type'];
	} else {
		$current_post_type = get_post_type();
	}
}

$ctx = wp_parse_args(
	$args,
	array(
		'lead_title' => '',
		'sub_title'  => '',
	)
);

get_template_part(
	'templates/components/page-header',
	null,
	array(
		'lead' => $ctx['lead_title'],
		'sub'  => $ctx['sub_title'],
	)
);

?>
<section class="section container -max-lg">
	<?php

	while ( have_posts() ) :
		the_post();
		get_template_part( 'templates/content', $current_post_type );
	endwhile;

	if ( ! have_posts() ) {
		get_template_part( 'templates/components/no-posts' );
	}

	?>
</section>

<?php get_template_part( 'templates/components/pagination' ); ?>
