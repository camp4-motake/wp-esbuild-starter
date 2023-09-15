<?php

/**
 * テンプレートラッパー
 *
 * @description https://scribu.net/wordpress/theme-wrappers.html
 */

namespace Lib\Wrapper;

function template_path()
{
  return TemplateWrapping::$main_template;
}

function template_base()
{
  return TemplateWrapping::$base;
}

class TemplateWrapping
{
  /**
   * Stores the full path to the main template file
   */
  public static $main_template;

  /**
   * Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
   */
  public static $base;

  public static function wrap($template)
  {
    self::$main_template = $template;

    self::$base = substr(basename(self::$main_template), 0, -4);

    if ('index' == self::$base) {
      self::$base = false;
    }

    $templates = array('base.php');

    if (self::$base) {
      array_unshift($templates, sprintf('base-%s.php', self::$base));
    }

    return locate_template($templates);
  }
}

add_filter('template_include', [__NAMESPACE__ . '\\TemplateWrapping', 'wrap'], 99);
