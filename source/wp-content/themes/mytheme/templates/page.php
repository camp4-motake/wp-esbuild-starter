<?php

get_template_part('templates/components/page-header', null, [
  'lead' => get_the_title(),
  'sub'  => get_field('sub_title')
]);

?>
<section class="section pt-md">
  <div class="entry-content">
    <?php the_content(); ?>
  </div>
</section>
