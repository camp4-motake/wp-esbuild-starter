#! /bin/bash

if [ ! -e .env ]; then
  echo 'COMPOSE_PROJECT_NAME=mytheme

WP_PORT=8888
WP_THEME_NAME=mytheme
WP_SITE_TITLE=mytheme
WP_ADMIN_USER=admin
WP_ADMIN_PASSWORD=admin
WP_ADMIN_MAIL=admin1@example.com
' > .env
fi

if [ ! -e auth.json ]; then
  echo '{
  "http-basic": {
    "connect.advancedcustomfields.com": {
      "username": "",
      "password": "https://camp4.jp/"
    }
  }
}' > auth.json
fi
