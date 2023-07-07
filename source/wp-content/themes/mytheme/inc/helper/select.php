<?php

namespace Lib\Helper\Select;


/**
 * ターム一覧のセレクトボックス出力
 *
 * @param string $label デフォルトラベル
 * @param string $tax = タクソノミー
 * @return string html
 */
function get_dropdown_taxonomy(
  $tax = "news_category",
  $label = "カテゴリーを選択"
) {
  $html = "";
  $terms = get_terms($tax);

  if (!empty($terms)) {
    $html .= '<select onChange="window.location.href=this.options[this.selectedIndex].value;">' . "\n";
    $html .= "<option disabled selected>- " . $label . " -</option>" . "\n";

    foreach ($terms as $term) {
      // if ($term->parent === 0) {
      //   continue;
      // }
      $html .= sprintf(
        '<option value="%s">%s</option>' . "\n",
        get_term_link($term->term_id, $tax),
        esc_attr($term->name)
      );
    }

    $html .= "</select>";
  }

  return $html;
}

/**
 *  月別アーカイブのセレクトボックス出力
 */
function get_dropdown_yearly($post_type = "news", $type = "yearly")
{
  $option = wp_get_archives([
    "echo"      => false,
    "format"    => "option",
    "post_type" => $post_type,
    "type"      => $type,
  ]);

  $html = "";

  if ($option) {
    $html .= '<select onChange="document.location.href=this.options[this.selectedIndex].value;">';
    $html .= '<option value="">- ' . esc_attr(__("Select Year")) . " -</option>";
    $html .= $option;
    $html .= "</select>";
  }

  return $html;
}
