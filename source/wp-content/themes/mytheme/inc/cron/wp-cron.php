<?php

namespace Lib\WpCron;

/**
 * wp-cron にカスタムスケジュール追加
 *
 * @see https://developer.wordpress.org/reference/hooks/cron_schedules/
 */
add_filter('cron_schedules', function ($schedules) {
  if (!isset($schedules["1min"])) {
    $schedules["1min"] = [
      'interval' => 60,
      'display'  => __('1分に1回')
    ];
  }
  if (!isset($schedules["2min"])) {
    $schedules["2min"] = [
      'interval' => 2 * 60,
      'display'  => __('2分に1回')
    ];
  }
  if (!isset($schedules["5min"])) {
    $schedules["5min"] = [
      'interval' => 5 * 60,
      'display'  => __('5分に1回')
    ];
  }
  if (!isset($schedules["30min"])) {
    $schedules["30min"] = [
      'interval' => 30 * 60,
      'display'  => __('30分に1回')
    ];
  }
  return $schedules;
});
