<?php

namespace Lib\Block\Helper;

/**
 * 記事なし表示
 *
 * @return void
 */
function no_posts_display() {
	if ( is_admin() ) {
		echo '<div class="empty-area">';
		get_template_part(
			'templates/components/no-posts',
			null,
			array(
				'no_post_label' => __( '該当する記事がありません', 'mytheme' ),
			)
		);
		echo '</div>';
		return;
	}
	get_template_part( 'templates/components/no-posts' );
}

/**
 * 画像なし表示
 *
 * @return void
 */
function no_image_entry() {
	if ( is_admin() ) {
		echo '<div class="empty-area">';
		get_template_part(
			'templates/components/no-posts',
			null,
			array(
				'no_post_label' => __( '画像の登録がありません', 'mytheme' ),
			)
		);
		echo '</div>';
	}
}
