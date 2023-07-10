<?php

namespace Lib\Helper\Image;

use Lib\Helper\Path;

/**
 * 指定したパスのインラインSVGを返す
 *
 * @param String $filepath svg ファイルパス
 * @param String $title titleタグ置換用テキスト
 * @return String インライン SVG
 */
function inline_svg(string $filepath = "", string $title = "")
{
  $svg_asset_path = ASSETS_DIR_PATH . $filepath;

  if (!file_exists($svg_asset_path)) {
    return;
  }

  // svg 取得
  $svg_source = file_get_contents($svg_asset_path);

  // titleタグ置換
  if ($title && $title !== "") {
    $pattern = "/<title>.*?<\/title>/u";
    $replace = "<title>{$title}</title>";
    $svg_source = preg_replace($pattern, $replace, $svg_source);
  }

  return $svg_source;
}

/**
 * svg スプライト表示タグを返す
 *
 * @param string $xlink - svg filename
 * @param string $classname - css class
 * @return string
 */
function svg_sprite($xlink = "", $title = "", $class = "", $attr = [], $role = "img"): string
{
  $attr = array_merge(
    [
      // 'xmlns:xlink' => 'http://www.w3.org/1999/xlink',
      "xlink:href" => "#src--images--_sprite--" . esc_attr($xlink),
    ],
    $attr
  );

  $use_attr = array_to_attr_string($attr);
  $class_name = $class ? 'class="' . esc_attr($class) . '" ' : "";

  $xml = "<svg " . $class_name . 'role="' . esc_attr($role) . '">';
  if (!empty($title)) {
    $xml .= "<title>" . esc_attr($title) . "</title>";
  }
  $xml .= "<use " . $use_attr . "></use></svg>";

  return $xml;
}

/**
 * {theme_name}/dist/ 内の画像パスから webp 表示用の picture タグを生成
 *
 * ex)メディアクエリなし
 *
 *　<?php echo Image\mq_picture($src = 'images/sample.png', $img_attrs = [], $picture_attrs = []); ?>
 *
 * ex)メディアクエリありの場合はソースパスとブレークポイントをを配列で指定
 *
 * <?php
 * $src = [
 *  'img' => 'images/sample.jpg',
 *   'source' => [
 *     ['src' => 'images/sample-lg.jpg', 'media' => MQ_LG],
 *     ['src' => 'images/sample-sm.jpg', 'media' => MQ_MD],
 *   ]
 * ];
 * echo Image\mq_picture($src, $img_attrs = [], $picture_attrs = []);
 * ?>
 *
 * @param string|array $src_path - assets/ 以下の画像パスを指定
 * @param array $img_attrs　- img タグに追加する属性。クラスやIDなど。
 * @param array $picture_attrs - picture に追加する属性。クラスやIDなど。
 * @return string
 */
function mq_picture($src_path = "" || [], $img_attrs = [], $picture_attrs = []): string
{
  $sources = false;

  if (is_array($src_path) && isset($src_path["img"])) {
    $path = $src_path["img"];
    if (isset($src_path["source"]) && count($src_path["source"])) {
      $sources = $src_path["source"];
    }
  } elseif (is_string($src_path)) {
    $path = $src_path;
  } else {
    return "";
  }

  $img_tag = make_img_tag($path, $img_attrs);
  $webp_path = preg_replace('/\.[^.]+$/', ".webp", $path);

  if (!$sources) {
    if (!file_exists(ASSETS_DIR_PATH . $webp_path)) {
      return $img_tag;
    } else {
    }
  }

  $n = "\n";
  $html = "<picture" . array_to_attr_string($picture_attrs) . ">" . $n;

  if ($sources) {
    foreach ($sources as $source) {
      if (!isset($source["src"]) || !isset($source["media"])) {
        continue;
      }
      $webp_path = preg_replace('/\.[^.]+$/', ".webp", $source["src"]);
      $html .= make_source_tag($webp_path, "image/webp", $source["media"]);
    }
    foreach ($sources as $source) {
      if (!isset($source["src"]) || !isset($source["media"])) {
        continue;
      }
      $html .= make_source_tag($source["src"], null, $source["media"]);
    }
  } else {
    $html .=
      "" . make_source_tag($webp_path, "image/webp") . make_source_tag($path);
  }

  $html .= $img_tag;
  $html .= "</picture>" . $n;

  return $html;
}

/**
 * img タグ生成
 *
 * @param string $path
 * @param array $img_attrs
 * @return string
 */
function make_img_tag($path = "", $img_attrs = [])
{
  $file_path = get_theme_file_path($path);

  if (!file_exists($file_path)) {
    return "";
  }

  $file_size = getimagesize($file_path);
  $img_attrs = array_merge(["alt" => ""], $img_attrs);
  $img_attrs = array_merge(["decoding" => "async"], $img_attrs);
  $img_tag = '<img src="' . esc_url(Path\cache_buster($path)) . '"' . array_to_attr_string($img_attrs) . " " . $file_size[3] . "/>" . "\n";

  return $img_tag;
}

/**
 * source タグ生成
 *
 * @param string $path
 * @param string $file_type
 * @param string $media
 * @return string
 */
function make_source_tag($path = "", $file_type = null, $media = null)
{
  $file_path = get_theme_file_path($path);

  if (!file_exists($file_path)) {
    return "";
  }

  $file_type = !empty($file_type) ? $file_type : mime_content_type($file_path);
  $media_attr = !empty($media) ? ' media="' . esc_attr($media) . '"' : "";
  return "<source " . get_srcset_attr($path) . ' type="' . esc_attr($file_type) . '"' . $media_attr . ">" . "\n";
}

/**
 * srcset 文字列を生成
 *
 * @param string $filename
 * @param array $resolution
 * @param boolean $non_1x
 * @return string
 */
function get_srcset_attr($filename = "", $resolution = [], $non_1x = false): string
{
  $resolution = array_merge(["1x" => "", "2x" => "@2x"], $resolution);
  $srcset = [];
  $srcset_string = "";

  foreach ($resolution as $key => $res) {
    if ($key === "1x" && $non_1x === true) {
      continue;
    }
    $high_res_name = preg_replace('/\.[^.]s+$/', $res . '$0', $filename);
    if (!file_exists(ASSETS_DIR_PATH . $high_res_name)) {
      continue;
    }
    $srcset[$key] = esc_url(Path\cache_buster($high_res_name));
  }

  $srcset_string_arr = [];

  foreach ($srcset as $key => $url) {
    $srcset_string_arr[] = $url . " " . $key;
  }

  $srcset_string = implode(",", $srcset_string_arr);

  return $srcset_string ? 'srcset="' . $srcset_string . '"' : "";
}

/**
 * 連想配列を HTML タグ属性文字列に変換
 *
 * ex)
 * ['alt' => 'text', 'loading' => 'lazy'] -> 'alt="text" loading="lazy"'
 *
 * @param array $attrs
 * @return string
 */
function array_to_attr_string($attrs = [], $spacer = " "): string
{
  $attr_string = "";
  foreach ($attrs as $key => $attr) {
    $attr_string .= esc_attr($key) . '="' . esc_attr($attr) . '"';
    if ($attr !== end($attrs)) {
      $attr_string .= " ";
    }
  }
  return $attr_string ? $spacer . $attr_string : "";
}

/**
 * wp_kses_allowed_html にpictureなどのタグを追加
 */
function kses_post_extend($context = "post")
{
  $wp_allowed_html = wp_kses_allowed_html($context);

  return array_merge($wp_allowed_html, [
    "source" => [
      "media"  => true,
      "sizes"  => true,
      "src"    => true,
      "srcset" => true,
      "type"   => true,
    ],
    "picture" => [
      "class"  => true,
      "id"     => true,
      "media"  => true,
      "srcset" => true,
      "type"   => true,
    ],
  ]);
}
