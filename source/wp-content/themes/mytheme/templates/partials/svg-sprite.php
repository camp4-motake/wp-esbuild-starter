<?php

use Lib\Helper\Image;

if ( ! file_exists( get_theme_file_path( 'dist/images/svg-sprite.svg' ) ) ) {
	return;
}

?>
<div style="display:none"><?php echo Image\inline_svg( 'dist/images/svg-sprite.svg' ); ?></div>
