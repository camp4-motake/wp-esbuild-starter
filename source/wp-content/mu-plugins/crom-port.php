<?php

// Docker に合わせてポートを変更
add_filter('cron_request', function ($cron_request) {
  $port = parse_url($cron_request['url'], PHP_URL_PORT);
  $cron_request['url'] = str_replace($port, '80', $cron_request['url']);
  return $cron_request;
}, 9999);
