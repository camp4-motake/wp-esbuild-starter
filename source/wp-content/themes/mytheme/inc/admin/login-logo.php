<?php

namespace Lib\Admin\LoginLogo;

/**
 *  ログインページのロゴ変更.
 */
add_action("login_enqueue_scripts", function () {
  $logo = "dist/images/logo-brand.svg";

  if (!file_exists(get_theme_file_path($logo))) {
    return;
  }

  $logo = get_theme_file_uri($logo);

  echo <<<EOF
  <style type="text/css">
    body.login #login h1 a {
      background-image: none, url({$logo}) !important;
      background-size: contain;
      width: 86%;
      height: 40px;
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
