<?php

namespace Lib\Helper\Paging;

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

/**
 * アーカイブのページ番号取得
 */
function show_page_number()
{
  global $wp_query;
  $paged = get_query_var("paged") ? get_query_var("paged") : 1;
  $max_page = $wp_query->max_num_pages;
  echo $paged;
}


/**
 * カスタムページネーション生成
 *
 * @see: http://www.ordinarycoder.com/paginate_links-class-ul-li-bootstrap/
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
        '<li class="pagination-item' . $link_class . '">' . $page . "</li>";
    }

    $pagination .= "</ul>" . "\n";
    $pagination .= '<p class="page-num"><small>' . $page_num . "/" . $max_page_num . "</small></p>";

    if ($echo) {
      echo $pagination;
    } else {
      return $pagination;
    }
  }
}
