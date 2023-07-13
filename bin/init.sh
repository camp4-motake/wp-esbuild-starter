#! /bin/bash

if [ ! -e .env ]; then
  cp ./docker/.env-sample ./.env
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
