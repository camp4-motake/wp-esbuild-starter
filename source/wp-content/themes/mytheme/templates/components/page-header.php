<?php

$ctx = wp_parse_args(
	$args,
	array(
		'tag'   => 'h1',
		'title' => get_the_title(),
		'sub'   => '',
	)
);

$tag = esc_attr( $ctx['tag'] );

?>
<div class="page-header">
	<?php echo '<' . $tag . ' class="page-header-heading h1">'; ?>
	<span class="page-header-title"><span><?php echo esc_html( $ctx['title'] ); ?></span></span>
	<?php if ( ! empty( $ctx['sub'] ) ) : ?>
	<small class="page-header-subtitle"><span><?php echo esc_html( $ctx['sub'] ); ?></span></small>
	<?php endif; ?>
	<?php echo '</' . $tag . '>'; ?>
</div>
