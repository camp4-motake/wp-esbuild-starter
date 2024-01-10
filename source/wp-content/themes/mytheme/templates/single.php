<?php
/**
 * Single Template
 *
 * @package mytheme
 */

?>
<article class="content-single section">
	<div class="container -max-entry">
	<header class="content-single__header">
		<h1 class="content-single__heading">
		<?php the_title(); ?>
		</h1>
		<div class="content-single-meta container -max-entry">
		<?php get_template_part( 'templates/components/entry-meta' ); ?>
		</div>
	</header>
	<?php if ( has_post_thumbnail() ) : ?>
		<figure class="entry-thumbnail">
		<?php the_post_thumbnail(); ?>
		</figure>
	<?php endif; ?>
	</div>
	<div class="section entry-content">
	<?php the_content(); ?>
	</div>
</article>
