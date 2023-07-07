<?php

namespace Lib\Helper\Content;

use Lib\Helper\Image;

/**
 * newバッジの表示判定
 *
 * デフォルトは15日間
 */
function new_badge_display($limit_day = 15, $badge_html = '<span class="badge-new">New</span>')
{
  $days = $limit_day;
  $days_int = ($days - 1) * 86400;
  $dayago = time() - get_the_time("U");
  $badge = $dayago < $days_int ? $badge_html : "";

  return $badge;
}

/**
 * 戻るボタンテンプレート
 */
function back_button($args = [])
{
  $default = [
    "icon" => false,
    "label" => "戻る",
    "link" => "",
    "class" => "",
  ];
  $cfg = array_merge([], $default, $args);

  // ボタンクラス生成
  $size_class = "button";
  if ($cfg["class"]) {
    $size_class .= " " . $cfg["class"];
  }

  // ボタンHTML生成
  $html = false;
  $html = '<a class="' . $size_class . '" href="' . $cfg["link"] . '">';
  if ($cfg["icon"]) {
    $html .= '<span class="button__icon">';
    $html .= Image\inline_svg($cfg["icon"]);
    $html .= "</span>";
  }
  $html .= "<span>" . $cfg["label"] . "</span>";
  $html .= "</a>";

  return $html;
}


/**
 * ACFのリンクフィールドからリンクタグ生成
 *
 * @param array $link ACF Link Field
 * @param string $class クラス名
 * @param string $alt リンクタイトルの代替テキスト
 * @param string $attr 追加属性
 * @return string
 */
function make_acf_link($link, $class = "", $alt = "", $attr = "")
{
  if (empty($link) || !isset($link["url"])) {
    return false;
  }
  $link_target = isset($link["target"]) ? $link["target"] : "_self";
  $link_title  = isset($link["title"]) && !empty($link["title"]) ? $link["title"] : $alt;
  $link_rel    = $link_target === "_blank" ? ' rel="noopener"' : "";
  $link_title  = esc_html($link_title);
  $link_href   = esc_url($link["url"]);
  $link_attr   = esc_attr($attr);
  $class       = esc_attr($class);

  $html = "<a href=\"{$link_href}\" class=\"{$class}\" target=\"{$link_target}\"{$link_rel} {$link_attr}>";
  $html .= "<span>{$link_title}</span>";
  $html .= "</a>";

  return $html;
}
