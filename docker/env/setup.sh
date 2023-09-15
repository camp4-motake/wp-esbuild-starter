#!/bin/bash

wp core install --url='http://localhost:'$WP_PORT \
                --title=$WP_SITE_TITLE \
                --admin_user=$WP_ADMIN_USER \
                --admin_password=$WP_ADMIN_PASSWORD \
                --admin_email=$WP_ADMIN_MAIL

wp site switch-language ja

wp rewrite structure /%post_id%/
wp rewrite flush --hard

wp theme activate $WP_THEME_NAME

# remove sample post
wp post delete $(wp post list --name=hello-world --post_type=post --format=ids)
wp post delete $(wp post list --name=sample-page --post_type=page --format=ids)

# remove unused plugin
wp plugin delete hello.php akismet
wp plugin activate --all

# update option
wp option update blogname $WP_SITE_TITLE
wp option update blogdescription ''
wp option update timezone_string $(wp eval "echo _x( '0', 'default GMT offset or timezone string' );")
wp option update date_format $(wp eval "echo __( 'Y-m-d' );")
wp option update time_format $(wp eval "echo __( 'H:i' );")

# update yoast seo options
wp option patch update wpseo disableadvanced_meta 0
wp option patch update wpseo content_analysis_active 0
wp option patch update wpseo keyword_analysis_active 0
wp option patch update wpseo enable_admin_bar_menu 0
wp option patch update wpseo enable_cornerstone_content 0
wp option patch update wpseo enable_text_link_counter 0
wp option patch update wpseo enable_metabox_insights 0
wp option patch update wpseo dismiss_configuration_workout_notice 1
# wp option patch update wpseo enable_enhanced_slack_sharing 0

echo 'WP Setup Complete'

exit 0
