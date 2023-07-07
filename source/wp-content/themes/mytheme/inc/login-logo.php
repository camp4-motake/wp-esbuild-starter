<?php

namespace Lib\Login\Logo;

/**
 *  ログインページのロゴ変更.
 */
add_action("login_enqueue_scripts", function () {
  $logo = "images/logo-brand-serif.svg";

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
      margin-bottom: 0.5rem;
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
