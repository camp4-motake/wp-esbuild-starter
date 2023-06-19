<?php

/**
 * テーマ定数
 */

// テーマドメイン
define("THEME_DOMAIN", "mytheme");

// テーマ名
define("THEME_NAME", "mytheme");

// テーマアセットのフルパスURL
define("ASSETS_DIR_URI", get_template_directory_uri() . "/dist/");

// テーマアセットディレクトのリフルパス
define("ASSETS_DIR_PATH", get_template_directory() . "/dist/");

// テストサーバードメイン
define("TEST_SERVER_DOMAIN", "");

// メディアクエリ
define("MQ_SM", "(min-width:36em)");
define("MQ_MD", "(min-width:48em)");
define("MQ_LG", "(min-width:62em)");
define("MQ_XL", "(min-width:75em)");
define("MQ_2xl", "(min-width:100em)");
define("MQ_LANDSCAPE", "(orientation: landscape)");
define("MQ_PORTRAIT", "(orientation: portrait)");

// Google Tag Manager テンプレートを有効化
define("IS_ENABLE_GOOGLE_TAG_MANAGER", false);

// Google Webフォント読み込みを有効化
define("IS_ENABLE_GOOGLE_FONTS", true);

//　Google Webフォント URL
define("GOOGLE_FONTS", "");
define("GOOGLE_FONTS_EN", "");
