<?php

namespace Lib\Acf;

/**
 * ACF TinyMCE エディタ設定カスタマイズ
 */
add_filter("acf/fields/wysiwyg/toolbars", function ($toolbars) {
  // TinyMCE エディタにフォントサイズ設定用のドロップダウン追加
  $key = array_search("fontsizeselect", $toolbars["Full"][2]);
  if ($key !== true) {
    array_push($toolbars["Full"][2], "fontsizeselect");
  }
  return $toolbars;
});

add_filter("tiny_mce_before_init", function ($initArray) {
  // フォントサイズ変更
  $initArray["fontsize_formats"] = "0.625rem 0.75rem 0.875rem 1em 1.125rem 1.25rem 1.5rem 1.75rem 2.5rem 4rem";
  return $initArray;
});

/**
 * WORKAROUND: ACFのデータが preview で反映されない現象対策
 * 参考: https://gist.github.com/ChrisLTD/892eccf385752dadaf5f
 */
add_filter("_wp_post_revision_fields", function ($fields) {
  $fields["debug_preview"] = "debug_preview";
  return $fields;
});

add_action("edit_form_after_title", function () {
  echo '<input type="hidden" name="debug_preview" value="debug_preview">';
});
