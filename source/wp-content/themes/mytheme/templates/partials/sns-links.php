<?php

use Lib\Helper\Path;

$sns = array(
	'twitter'   => array(
		'href'  => '#0',
		'label' => 'Twitter',
	),
	'instagram' => array(
		'href'  => '#0',
		'label' => 'Instagram',
	),
	'facebook'  => array(
		'href'  => '#0',
		'label' => 'Facebook',
	),
);

?>
<ul class="sns-links">
	<?php foreach ( $sns as $k => $v ) : ?>
	<li><a title="<?php echo esc_attr( $v['label'] ); ?>" href="<?php echo esc_url( $v['href'] ); ?>" target="_blank" rel="noopener noreferrer"><img src="<?php echo Path\cache_buster( 'dist/images/sns/' . esc_attr( $k ) . '.svg' ); ?>" width="48" height="48" alt="<?php echo esc_attr( $v['label'] ); ?>" decoding="async"></a></li>
	<?php endforeach; ?>
</ul>
