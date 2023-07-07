<?php

namespace Lib\Helper;

/**
 * namespace 生成（barba.js、swup のようなPjaxライブラリで使用するなど）
 *
 * @param Object $post 投稿タイプ名
 * @return String barba.js 用の namespace 文字列
 */
function get_namespace($post)
{
  // フロントページ
  if (is_front_page()) {
    return "home";
  }
  if (is_page()) {
    global $post;
    return $post->post_name ?: "";
  }
  // その他（投稿タイプ名）
  return esc_html(get_post_type($post)) ?: "other";
}


/**
 * 固定ページの親スラッグ取得
 *
 * @return string slug
 */
function get_parent_slug()
{
  global $post;

  if (isset($post->post_parent)) {
    $post_data = get_post($post->post_parent);
    return $post_data->post_name;
  }
}

/**
 * SNSシェアボタンリンク配列を返す
 */
function get_share_links()
{
  $title = urlencode(get_the_title());
  $current_url = urlencode(get_the_permalink());

  return [
    [
      "prefix" => "twitter",
      "link"   => "http://twitter.com/share?url={$current_url}&text={$title}",
    ],
    [
      "prefix" => "facebook",
      "link"   => "https://www.facebook.com/sharer/sharer.php?u={$current_url}",
    ],
    [
      "prefix" => "hatena",
      "link"   => "http://b.hatena.ne.jp/add?mode=confirm&url={$current_url}&title={$title}",
    ],
    [
      "prefix" => "line",
      "link"   => "http://line.me/R/msg/text/?{$current_url}",
    ],
  ];
}

/**
 * 空判定
 */
function set_check($parm = null, $alt = false)
{
  return isset($parm) ? $parm : $alt;
}

/**
 * URL文字列をリンクに変換
 * https://qiita.com/sukobuto/items/b6cdfa966b29823c62f0
 *
 * @param string $body
 * @param string $link_title
 * @return string
 */
function url2link($body = "", $link_title = null)
{
  $pattern = '/(?<!href=")https?:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:@&=+$,%#]+/';
  $body = preg_replace_callback(
    $pattern,
    function ($matches) use ($link_title) {
      $link_title = $link_title ?: $matches[0];
      $link = esc_url($matches[0]);
      $target = "";
      if (
        isset($_SERVER["HTTP_HOST"]) &&
        strpos($matches[0], $_SERVER["HTTP_HOST"]) === false
      ) {
        $target = ' target="_blank" rel="noopener"';
      }
      return "<a href=\"{$link}\"{$target}>$link_title</a>";
    },
    $body
  );

  return $body;
}

/**
 * iframe などの src 属性から URL だけを抽出
 *
 * @param string $html 対象のiframeタグ
 * @return array preg_match
 */
function extract_src_url($html = "")
{
  $matches = false;
  if ($html) {
    preg_match('/<*src *= *["\']?([^"\']*)/i', $html, $matches);
  }
  return $matches;
}

/**
 * タームリストから、Yoast SEO のメインタームに設定されているタームがあれば取得
 * メインタームがない場合０番目のタームを返す
 *
 * @param [type] $term_list
 * @return object $main_term
 */
function get_main_term($term_list, $post = null)
{
  if (empty($term_list)) {
    return null;
  }

  if (!$post) {
    global $post;
  }

  $main_term = null;

  foreach ($term_list as $term) {
    if (get_post_meta($post->ID, "_yoast_wpseo_primary_category", true) === $term->term_id) {
      $main_term = $term;
    }
  }

  if (!$main_term) {
    $main_term = $term_list[0];
  }

  return $main_term;
}

/**
 *  YouTubeのIDを正規表現で抽出し返す
 *
 * @param [type] $url
 * @return void
 */
function get_youtube_id_from_url($url = "")
{
  preg_match(
    "/(http(s|):|)\/\/(www\.|)yout(.*?)\/(embed\/|watch.*?v=|)([a-z_A-Z0-9\-]{11})/i",
    $url,
    $results
  );
  return $results[6];
}


/**
 * ランダムテキスト生成
 */
function random_text(string $string = "", int $min = 0, int $max = 10): string
{
  $text = $string;
  $length = rand($min, $max);

  for ($i = $min; $i < $length; $i++) {
    $text .= $string;
  }

  return $text;
}
