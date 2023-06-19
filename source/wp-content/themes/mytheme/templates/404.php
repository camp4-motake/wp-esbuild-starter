  <section class="error404 section container text-center">
    <h1 class="error404__heading">
      <strong class="error404__heading__status"><?= http_response_code() ?></strong>
      <span class="error404__heading__label"><?php _e('Not Found', 'mytheme'); ?></span>
    </h1>
    <p class="error404__description">
      <?php _e('Sorry, but the page you are trying to view does not exist.', 'mytheme'); ?>
    </p>
  </section>
