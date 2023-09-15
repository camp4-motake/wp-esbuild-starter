<?php

/**
 * Page - 404
 */

?>
<section class="error404-section section">
  <div class="container">
    <h1 class="error404-heading">
      <strong class="error404-heading-status"><?= http_response_code() ?></strong>
      <span class="error404-heading-label"><?php _e('Not Found', 'mytheme'); ?></span>
    </h1>
    <p class="error404-description">
      <?php _e('Sorry, but the page you are trying to view does not exist.', 'mytheme'); ?>
    </p>
  </div>
</section>
