#!/bin/bash

# wp core force update
wp core install --url='http://localhost:'$LOCAL_SERVER_PORT \
                --title=$WORDPRESS_SITE_TITLE \
                --admin_user=$WORDPRESS_ADMIN_USER \
                --admin_password=$WORDPRESS_ADMIN_PASSWORD \
                --admin_email=$WORDPRESS_ADMIN_MAIL \
                --allow-root

# instal jp core]
wp core update --locale=ja --allow-root
wp core language install ja --activate --allow-root
wp site switch-language ja --allow-root

# copy root index.php | .htaccess
if [ -e /html${WP_CORE_DIR}/index.php ] && [ -e /html${WP_CORE_DIR}/.htaccess ] && [ ! -e /html/index.php ] && [ ! -e /html/.htaccess ]; then
 cp /html${WP_CORE_DIR}/.htaccess /html/.htaccess
 cp /html${WP_CORE_DIR}/index.php /html/index.php
 sed -i -e 's/\/wp-blog-header\.php/\'$WP_CORE_DIR'\/wp-blog-header.php/g' /html/index.php
fi

# update option
wp option update siteurl --allow-root 'http://localhost:'{$LOCAL_SERVER_PORT}${WP_CORE_DIR}
wp option update home --allow-root 'http://localhost:'$LOCAL_SERVER_PORT
wp option update home --allow-root ''
wp option update permalink_structure '/%post_id%/' --allow-root
wp option update blogname --allow-root ''$WORDPRESS_SITE_TITLE
wp option update blogdescription --allow-root ''
wp option update timezone_string --allow-root $(wp eval --allow-root "echo _x( '0', 'default GMT offset or timezone string' );")
wp option update date_format --allow-root $(wp eval --allow-root "echo __( 'Y-m-d' );")
wp option update time_format --allow-root $(wp eval --allow-root "echo __( 'H:i' );")

# remove sample post
wp post delete --allow-root $(wp post list --allow-root --name=hello-world --post_type=post --format=ids)
wp post delete --allow-root $(wp post list --allow-root --name=sample-page --post_type=page --format=ids)

# activate theme
if [ -e /html${WP_CORE_DIR}/wp-content/themes/$WP_THEME_NAME ]; then
  wp theme activate $WP_THEME_NAME --allow-root
fi

# remove official theme
if [ -e /html${WP_CORE_DIR}/wp-content/themes/twentysixteen ]; then
  wp theme delete twentysixteen --allow-root
fi

if [ -e /html${WP_CORE_DIR}/wp-content/themes/twentyseventeen ]; then
  wp theme delete twentyseventeen --allow-root
fi

if [ -e /html${WP_CORE_DIR}/wp-content/themes/twentyeighteen ]; then
  wp theme delete twentyeighteen --allow-root
fi

if [ -e /html${WP_CORE_DIR}/wp-content/themes/twentynineteen ]; then
  wp theme delete twentynineteen --allow-root
fi

if [ -e /html${WP_CORE_DIR}/wp-content/themes/twentytwenty ]; then
  wp theme delete twentytwenty --allow-root
fi

if [ -e /html${WP_CORE_DIR}/wp-content/themes/twentytwentyone ]; then
  wp theme delete twentytwentyone --allow-root
fi

if [ -e /html${WP_CORE_DIR}/wp-content/themes/twentytwentytwo ]; then
  wp theme delete twentytwentytwo --allow-root
fi

# remove default plugin
wp plugin delete hello.php akismet --allow-root

# install plugin
while read line
do
  wp plugin install --allow-root $line
done < /html/plugin.txt
wait

# install ACF Pro - require license key
if [ -n "$ACF_PRO_KEY" ]; then
  wp plugin install --allow-root "http://connect.advancedcustomfields.com/index.php?p=pro&a=download&k=${ACF_PRO_KEY}"
  # wp plugin activate advanced-custom-fields-pro --allow-root
  # wp eval 'acf_pro_update_license("'$ACF_PRO_KEY'");' --allow-root
fi

# update language
wp language plugin install --all ja --allow-root

# import db
if [ -e /html/.dump/import.sql ]; then
  wp db reset --yes --allow-root
  wp db import /html/.dump/import.sql --allow-root
fi

# fixed permission -> www-data
chown -R www-data:www-data /html

echo 'WP Setup Complete'

exit 0
