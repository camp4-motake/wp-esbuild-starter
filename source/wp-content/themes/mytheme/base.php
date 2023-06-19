<?php

/**
 * Base Layout
 */

use Lib\Wrapper;

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> x-data="root" x-bind="root">
<?php get_template_part("templates/partials/head"); ?>

<body <?php body_class(); ?>>
  <?php

  do_action('body_tag_before');
  get_template_part("templates/partials/svg-sprite");

  do_action("get_header");
  get_template_part("templates/partials/header");

  ?>
  <main class="contents">
    <?php include Wrapper\template_path(); ?>
  </main>
  <?php

  do_action("get_footer");
  get_template_part("templates/partials/footer");

  wp_footer();

  ?>
</body>

</html>
