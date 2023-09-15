<?php

namespace Lib\Plugins\PostTypeOrder;

/**
 *  post type order / taxonomy terms order の広告を非表示
 */
add_action("admin_print_styles", function () {
  echo ''
    . "<style>"
    . ' #cpt_info_box { display: none !important;'
    . "</style>";
});
