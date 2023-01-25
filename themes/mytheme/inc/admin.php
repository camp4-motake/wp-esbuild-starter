<?php

namespace Lib\Admin;

use Lib\Helper;

/**
 * 管理画面の不要メニューを管理者権限以外は非表示
 */
add_action("admin_menu", function () {
  global $menu;
  unset($menu[5]); // 投稿
  unset($menu[25]); // コメント

  if (!current_user_can("administrator")) {
    // unset($menu[2]);  // ダッシュボード
    // unset($menu[4]);  // メニューの線1
    // unset($menu[5]);  // 投稿
    // unset($menu[10]); // メディア
    // unset($menu[15]); // リンク
    // unset($menu[20]); // ページ
    // unset($menu[25]); // コメント
    // unset($menu[59]); // メニューの線2
    // unset($menu[60]); // テーマ
    // unset($menu[65]); // プラグイン
    // unset($menu[70]); // プロフィール
    unset($menu[75]); // ツール
    // unset($menu[80]); // 設定
    // unset($menu[90]); // メニューの線3

    remove_menu_page("wpcf7");
    remove_menu_page("edit.php?post_type=mw-wp-form");
  }
});

/**
 * 不要なメニューを削除
 */
add_action(
  "admin_bar_menu",
  function ($wp_admin_bar) {
    //WordPressアイコン
    // $wp_admin_bar->remove_menu( 'wp-logo' );
    // //WordPressアイコン -> WordPress について
    // $wp_admin_bar->remove_menu( 'about' );
    // //WordPressアイコン -> WordPress.org
    // $wp_admin_bar->remove_menu( 'wporg' );
    // //WordPressアイコン -> ドキュメンテーション
    // $wp_admin_bar->remove_menu( 'documentation' );
    // //WordPressアイコン -> サポートフォーラム
    // $wp_admin_bar->remove_menu( 'support-forums' );
    // //WordPressアイコン -> フィードバック
    // $wp_admin_bar->remove_menu( 'feedback' );

    // //サイト情報
    // $wp_admin_bar->remove_menu( 'site-name' );
    // //サイト情報 -> ダッシュボード
    // $wp_admin_bar->remove_menu( 'dashboard' );
    // //サイト情報 -> テーマ
    // $wp_admin_bar->remove_menu( 'themes' );
    // //サイト情報 -> ウィジェット
    // $wp_admin_bar->remove_menu( 'widgets' );
    // //サイト情報 -> メニュー
    // $wp_admin_bar->remove_menu( 'menus' );
    // //サイト情報 -> ヘッダー
    // $wp_admin_bar->remove_menu( 'header' );

    // //カスタマイズ
    // $wp_admin_bar->remove_menu( 'customize' );

    //コメント
    $wp_admin_bar->remove_menu("comments");

    // //新規
    // $wp_admin_bar->remove_menu( 'new-content' );
    // //新規 -> 投稿
    // $wp_admin_bar->remove_menu( 'new-post' );
    // //新規 -> メディア
    // $wp_admin_bar->remove_menu( 'new-media' );
    // //新規 -> 固定ページ
    // $wp_admin_bar->remove_menu( 'new-page' );
    // //新規 -> ユーザー
    // $wp_admin_bar->remove_menu( 'new-user' );

    // //〜の編集
    // $wp_admin_bar->remove_menu( 'edit' );

    // //こんにちは、[ユーザー名]　さん
    // $wp_admin_bar->remove_menu( 'my-account' );
    // //ユーザー -> ユーザー名・アイコン
    // $wp_admin_bar->remove_menu( 'user-info' );
    // //ユーザー -> プロフィールを編集
    // $wp_admin_bar->remove_menu( 'edit-profile' );
    // //ユーザー -> ログアウト
    // $wp_admin_bar->remove_menu( 'logout' );

    // //検索
    // $wp_admin_bar->remove_menu( 'search' );
  },
  99
);

/**
 *  ログインページのロゴ変更.
 */
add_action("login_enqueue_scripts", function () {
  $logo = "images/logo-brand.svg";

  if (!file_exists(ASSETS_DIR_PATH . $logo)) {
    return;
  }

  $logo = ASSETS_DIR_URI . $logo;

  echo <<<EOF
  <style type="text/css">
    body.login #login h1 a {
      background-image: none, url({$logo}) !important;
      background-size: contain;
      width: 80%;
      height: 60px;
      margin-bottom: 0;
    }
  </style>
EOF;
});

/**
 * ログインページロゴのリンク先を指定.
 */
add_filter("login_headerurl", function () {
  return get_bloginfo("url");
});

/**
 * ログインページロゴのtitle変更.
 */
add_filter("login_headertext", function () {
  return get_option("blogname");
});

/**
 * 不要なダッシュボードウィジットを削除
 */
add_action("wp_dashboard_setup", function () {
  // remove_meta_box( 'dashboard_right_now', 'dashboard', 'normal' ); // 概要
  // remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' ); // アクティビティ
  remove_meta_box("dashboard_quick_press", "dashboard", "side"); // クイックドラフト
  remove_meta_box("dashboard_primary", "dashboard", "side"); // WordPressニュース
});

/**
 * 固定ページ一覧にスラッグ表示用カラムを追加
 */
add_filter("manage_pages_columns", __NAMESPACE__ . "\\add_page_column_title");
// add_filter('manage_[post_type]_posts_columns', __NAMESPACE__ . '\\add_page_column_title');
function add_page_column_title($columns)
{
  $columns["slug"] = "スラッグ";
  return $columns;
}

/**
 * 固定ページ一覧にスラッグを表示
 */
add_action(
  "manage_pages_custom_column",
  __NAMESPACE__ . "\\add_page_column",
  10,
  2
);
// add_action('manage_[post_type]_posts_custom_column', __NAMESPACE__ . '\\add_page_column', 10, 2);
function add_page_column($column_name, $post_id)
{
  if ($column_name == "slug") {
    $post = get_post($post_id);
    $uri = get_permalink($post_id);
    $slug = $post->post_name;

    $error = "";
    if (strpos(esc_attr($slug), "%") !== false) {
      $error =
        '<strong class="error" style="color:red;">【!】パーマリンクのURLスラッグを半角英数字のみに修正してから公開してください。</strong>';
    }

    echo $error .
      '<a href="' .
      esc_url($uri) .
      '" target="_blank" rel="noopener">' .
      esc_attr($slug) .
      " </a>";
  }
}

/**
 * ページリストの投稿表示数を変更
 */
add_filter("edit_posts_per_page", function ($posts_per_page) {
  return 100;
});

/**
 * 管理画面カスタマイズ用追加インラインCSS
 */
add_action("admin_print_styles", function () {
  $style = "<style>";

  // プラグインの広告を隠す
  // - Yorst SEO の右サイド広告
  // - Taxonomy Order の上の広告
  $style .= '
  #sidebar.yoast-sidebar,
  #cpt_info_box,.yoast_premium_upsell,
  .yoast-notification.notice.notice-warning.is-dismissible { display: none !important; }';

  // 管理バー左上タイトルにローカルホスト・開発サーバー識別文字を追加
  if (
    TEST_SERVER_DOMAIN &&
    strpos($_SERVER["HTTP_HOST"], TEST_SERVER_DOMAIN) !== false
  ) {
    $style .=
      '#wp-admin-bar-site-name .ab-item:after { content:"（開発サーバー）"; }';
  } elseif (strpos($_SERVER["HTTP_HOST"], "localhost") !== false) {
    $style .=
      '#wp-admin-bar-site-name .ab-item:after { content:"（ローカル）"; }';
  }

  $style .= "</style>";

  echo $style;
});
