<?php

namespace Lib\Helper\Env;

/**
 * 本番環境判定
 *
 * @return boolean
 */
function in_production()
{
  return wp_get_environment_type() === 'production';
}

/**
 * ステージング環境判定
 *
 * @return boolean
 */
function in_staging()
{
  return wp_get_environment_type() === 'staging';
}

/**
 * ローカル環境判定
 *
 * @return boolean
 */
function in_local()
{
  return strpos($_SERVER["HTTP_HOST"], "localhost") !== false || wp_get_environment_type() === 'local';
}
