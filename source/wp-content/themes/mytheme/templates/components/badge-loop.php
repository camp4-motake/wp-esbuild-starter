<?php

// badge loop

$ctx   = wp_parse_args( $args, array( 'tax' => 'category-shop' ) );
$terms = get_the_terms( get_the_ID(), $ctx['tax'] );

if ( ! $terms ) {
	return;
}

?>
<?php foreach ( $terms as $term ) : ?>
	<span class="badge" style="--color-theme:<?php the_field( 'color', $term ); ?>;--color-theme-text:<?php the_field( 'color_text', $term ); ?>;"><?php echo esc_html( $term->name ); ?></span>
<?php endforeach; ?>
