<?php

/**
 * 固定ページ
 */

get_template_part('templates/components/page-header', null, [
  'title' => get_the_title(),
]);

?>
<section class="section pt-0 entry-content">
  <?php the_content(); ?>
</section>
