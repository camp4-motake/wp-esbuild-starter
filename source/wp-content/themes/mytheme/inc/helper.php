<?php

namespace Lib\Helper;

/**
 * 開発環境判定
 *
 * @return boolean
 */
function is_dev()
{
  $host = $_SERVER["HTTP_HOST"];
  return WP_DEBUG &&
    (strpos($host, "dev.") !== false || strpos($host, "localhost") !== false);
}

/**
 * アセットパス取得ラッパー
 *
 * @param string $filepath アセットファイルパス
 * @return string パス
 */
function assets_uri($filepath = "")
{
  return ASSETS_DIR_URI . $filepath;
}

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
 * Page titles
 */
function title()
{
  if (is_home()) {
    if (get_option("page_for_posts", true)) {
      return get_the_title(get_option("page_for_posts", true));
    } else {
      return __("Latest Posts", "sage");
    }
  } elseif (is_archive()) {
    return get_the_archive_title();
  } elseif (is_search()) {
    return sprintf(__("Search Results for %s", "sage"), get_search_query());
  } elseif (is_404()) {
    return __("Not Found", "sage");
  } else {
    return get_the_title();
  }
}

/**
 * {theme_name}/dist/ 内の画像パスから webp 表示用の picture タグを生成
 *
 * ex)メディアクエリなし
 *
 *　<?php echo Helper\picture_webp($src = 'images/sample.png', $img_attrs = [], $picture_attrs = []); ?>
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
 * echo Helper\picture_webp($src, $img_attrs = [], $picture_attrs = []);
 * ?>
 *
 * @param string|array $src_path - assets/ 以下の画像パスを指定
 * @param array $img_attrs　- img タグに追加する属性。クラスやIDなど。
 * @param array $picture_attrs - picture に追加する属性。クラスやIDなど。
 * @return string
 */
function picture_webp($src_path = "" || [], $img_attrs = [], $picture_attrs = []): string
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
  $file_path = ASSETS_DIR_PATH . $path;

  if (!file_exists($file_path)) {
    return "";
  }

  $file_size = getimagesize($file_path);
  $img_attrs = array_merge(["alt" => ""], $img_attrs);

  if (
    !array_key_exists("loading", $img_attrs) &&
    !array_key_exists("decoding", $img_attrs)
  ) {
    $img_attrs = array_merge(["loading" => "lazy"], $img_attrs);
  }

  $img_tag =
    '<img src="' .
    esc_url(assets_uri($path)) .
    '"' .
    array_to_attr_string($img_attrs) .
    " " .
    $file_size[3] .
    "/>" .
    "\n";

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
  $file_path = ASSETS_DIR_PATH . $path;

  if (!file_exists($file_path)) {
    return "";
  }

  $file_type = !empty($file_type) ? $file_type : mime_content_type($file_path);
  $media_attr = !empty($media) ? ' media="' . esc_attr($media) . '"' : "";
  return "<source " .
    get_srcset_attr($path) .
    ' type="' .
    esc_attr($file_type) .
    '"' .
    $media_attr .
    ">" .
    "\n";
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
    $high_res_name = preg_replace('/\.[^.]+$/', $res . '$0', $filename);
    if (!file_exists(ASSETS_DIR_PATH . $high_res_name)) {
      continue;
    }
    $srcset[$key] = esc_url(assets_uri($high_res_name));
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

/**
 * barba.js 用の namespace を取得
 *
 * @param Object $post 投稿タイプ名
 * @return String barba.js 用の namespace 文字列
 */
function get_barba_namespace($post)
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
 * カスタムページネーション生成
 *
 * custom pagination with bootstrap .pagination class
 * source: http://www.ordinarycoder.com/paginate_links-class-ul-li-bootstrap/
 */
function custom_pagination($echo = true, $custom_query = null)
{
  global $wp_query;

  $query = !empty($custom_query) ? $custom_query : $wp_query;

  $big = 999999999; // need an unlikely integer

  $pages = paginate_links([
    "base"      => str_replace($big, "%#%", esc_url(get_pagenum_link($big))),
    "format"    => "?paged=%#%",
    "current"   => max(1, get_query_var("paged")),
    "total"     => $query->max_num_pages,
    "type"      => "array",
    "prev_next" => true,
    "prev_text" => "<span>" . __("前へ") . "</span>",
    "next_text" => "<span>" . __("次へ") . "</span>",
  ]);

  if (is_array($pages)) {
    $page_num = get_paged_number();
    $max_page_num = max_show_page_number($query);

    $pagination = '<ul class="pagination">';

    foreach ($pages as $page) {
      $link_class = "";
      if (
        strpos($page, "current") === false &&
        strpos($page, "next") === false &&
        strpos($page, "prev") === false
      ) {
        $link_class = " is-rwd";
      }
      $pagination .=
        '<li class="pagination__item' . $link_class . '">' . $page . "</li>";
    }

    $pagination .= "</ul>" . "\n";
    $pagination .= '<p class="pageNum"><small>' . $page_num . "/" . $max_page_num . "</small></p>";

    if ($echo) {
      echo $pagination;
    } else {
      return $pagination;
    }
  }
}

/**
 * 現在のページ数の取得
 */
function get_paged_number($custom_query = null)
{
  $paged = get_query_var("paged") ? get_query_var("paged") : 1;

  return $paged;
}

/**
 * 総ページ数の取得
 */
function max_show_page_number($custom_query = null)
{
  global $wp_query;

  $query = !empty($custom_query) ? $custom_query : $wp_query;

  $max_page = $query->max_num_pages;
  return $max_page;
}

/**
 * 「○件中○件を表示」を表示
 *
 * @return void
 */
function display_current_article_result_count()
{
  global $wp_query;

  $paged = get_query_var("paged") - 1;
  $ppp = get_query_var("posts_per_page");
  $count = $total = $wp_query->post_count;
  $from = 0;
  if (0 < $ppp) {
    $total = $wp_query->found_posts;
    if (0 < $paged) {
      $from = $paged * $ppp;
    }
  }
  $count_from = 1 < $count ? $from + 1 . "〜" : "";
  $count_to = $from + $count;
  return "<strong>" .
    $total .
    "</strong> <small>件中</small> <strong>" .
    $count_from .
    $count_to .
    "</strong><small> 件目を表示</small>";
}

/**
 * アーカイブのページ番号出力
 */
function display_page_num()
{
  // ページ番号出力
  $page_number = show_page_number();
  $max_show_page_number = max_show_page_number();

  return $page_number && $max_show_page_number
    ? $page_number . " / " . $max_show_page_number
    : false;
}

function show_page_number()
{
  global $wp_query;
  $paged = get_query_var("paged") ? get_query_var("paged") : 1;
  $max_page = $wp_query->max_num_pages;
  echo $paged;
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
    $html .= inline_svg($cfg["icon"]);
    $html .= "</span>";
  }
  $html .= "<span>" . $cfg["label"] . "</span>";
  $html .= "</a>";

  return $html;
}

/**
 * background-image のインラインスタイルの文字列をesc_urlして返す関数.
 *
 * @param string $uri ソースパス
 * @return string インラインスタイル
 */
function bg_uri($uri = null)
{
  if (!$uri) {
    return "";
  }

  return 'style="background-image:url(' . esc_url($uri) . ')"';
}
/**
 * background-image 用 lagyload data属性を生成返す関数.
 *
 * @param string $uri ソースパス
 * @return string
 */
function bg_lazy($uri = null)
{
  if (!$uri) {
    return "";
  }

  return 'data-bg="url(' . esc_url($uri) . ')"';
}

/**
 * 固定ページの子ページ判定
 *
 * @param [type] $slug 固定ページスラッグ
 * @return boolean
 */
function is_page_child($slug = null)
{
  if (!is_page()) {
    return false;
  }

  global $post;

  $parent_id = $post->post_parent;
  $parent_slug = get_post($parent_id)->post_name;

  if ($parent_slug === $slug) {
    return is_page() && $post->post_parent;
  }
  return false;
}

/**
 * [new]バッジの表示判定.
 * デフォルトは15日間
 */
function new_badge_display($badge_html = '<span class="badge-new">New</span>')
{
  $days = get_option("news_badge_display_date", "") ?: 15;
  $days_int = ($days - 1) * 86400;
  $dayago = time() - get_the_time("U");
  $badge = $dayago < $days_int ? $badge_html : "";

  return $badge;
}

/**
 * 外部リンクの場合にtarget="_blank" rel="noopener noreferrer"'属性を返す
 *
 * @param [type] $url
 * @return String
 */
function get_external_attr($url)
{
  if (!is_string($url)) {
    return false;
  }

  $host = $_SERVER["HTTP_HOST"];
  $target = "";

  if (intval(strpos(home_url(), $host)) && !intval(strpos($url, $host))) {
    $target = ' target="_blank" rel="noopener noreferrer"';
  }

  return $target;
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
 * 子ページ判定
 *
 * @param string $slug 固定ページスラッグ
 * @return boolean
 */
function is_child_of($slug = "")
{
  $get_page_id = get_page_by_path($slug);

  if (!empty($get_page_id->ID)) {
    return is_page() && $get_page_id->ID === get_post()->post_parent;
  }

  return false;
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
 * 固定ページの親子判定
 */
function is_page_ancestor_of($slug)
{
  global $post;

  $page = get_page_by_path($slug);
  $result = false;

  if (isset($page)) {
    foreach ($post->ancestors as $ancestor) {
      if ($ancestor == $page->ID) {
        $result = true;
      }
    }
  }
  return $result;
}

/**
 * 空判定
 */
function set_check($parm = null, $alt = false)
{
  return isset($parm) ? $parm : $alt;
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
 * ターム一覧のドロップダウン出力
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
 *  月別アーカイブ
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

/**
 * 固定ページの存在確認
 *
 * @param [type] $slug
 * @return boolean
 */
function is_exist_page($slug)
{
  $post_id = get_page_by_path("/${slug}");
  return !empty($post_id);
}

/**
 * ランダムテキスト
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
 * yorst seo breadcrumb
 * https://yoast.com/help/implement-wordpress-seo-breadcrumbs/
 */
function get_yoast_seo_breadcrumb()
{
  if (!function_exists("yoast_breadcrumb")) {
    return "";
  }

  /**
   * パンくずの矢印用タグ置換
   * 置換するには、Yoast SEO のパンくず設定で、パンくずリストの間の区切りをに %arrow を指定してください
   */
  $arrow_html = ">";

  ob_start();
  yoast_breadcrumb('<div class="breadcrumb">', "</div>" . "\n");
  $breadcrumb = ob_get_contents();
  ob_end_clean();

  $breadcrumb = str_replace("%arrow", $arrow_html, $breadcrumb);

  return $breadcrumb;
}


/**
 * テーマアセット用キャッシュバスター
 *
 * @param string $path テーマ内のパス
 * @return string ハッシュ ID クエリ付きURL
 */
function cache_buster($path = "")
{
  if (!$path) {
    return "";
  }

  $asset_path = get_template_directory() . $path;
  $asset_uri = get_template_directory_uri() . $path;
  $hash_id = file_exists($asset_path)
    ? "?id=" . hash_file("fnv132", $asset_path)
    : "";

  return $asset_uri . $hash_id;
}
