<?php
/**
 * Theme Functions
 *
 * @package mytheme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

require_once 'inc/admin/cleanup.php';
require_once 'inc/admin/hooks.php';
require_once 'inc/admin/login-logo.php';
require_once 'inc/admin/menu-order.php';
require_once 'inc/admin/user.php';

require_once 'inc/block/helper.php';
require_once 'inc/block/register-acf-block.php';
require_once 'inc/block/register-patterns.php';

require_once 'inc/helper/conditional.php';
require_once 'inc/helper/content.php';
require_once 'inc/helper/date.php';
require_once 'inc/helper/environment.php';
require_once 'inc/helper/image.php';
require_once 'inc/helper/pagination.php';
require_once 'inc/helper/path.php';
require_once 'inc/helper/select.php';
require_once 'inc/helper/util.php';

require_once 'inc/plugins/acf.php';
require_once 'inc/plugins/post-type-order.php';
require_once 'inc/plugins/yoast-seo.php';

require_once 'inc/post-type/news.php';

require_once 'inc/assets.php';
require_once 'inc/cleanup.php';
require_once 'inc/constants.php';
require_once 'inc/editor.php';
require_once 'inc/googlefonts.php';
require_once 'inc/hooks.php';
require_once 'inc/lib/wrapper.php';
require_once 'inc/pre-get-posts.php';
require_once 'inc/preload.php';
require_once 'inc/setup.php';
require_once 'inc/shortcode.php';
require_once 'inc/siteicon.php';
require_once 'inc/tracking.php';
