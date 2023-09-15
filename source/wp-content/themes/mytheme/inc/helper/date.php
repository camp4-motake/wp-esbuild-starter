<?php

namespace Lib\Helper\Date;

/**
 * 日付の妥当性チェック
 *
 * @param string $date_string
 * @return boolean
 */
function is_valid_date_string($date_string)
{
  $date = date_parse_from_format('Y-m-d', $date_string);
  if ($date['error_count'] > 0) {
    return false;
  }
  list($year, $month, $day) = explode("-", $date_string);
  if (!isset($year) || !isset($month) || !isset($day)) {
    return false;
  }
  return checkdate($month, $day, $year);
}
