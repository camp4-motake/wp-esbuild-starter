<?php

/**
 * テーマ定数
 */

// テーマドメイン （注: 翻訳のテキストドメインには使用できません）
define("THEME_DOMAIN", "mytheme");

// テーマ名
define("THEME_NAME", "mytheme");

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

// Google Tag Manager の出力表示を有効化 -> tracking.php
define("IS_ENABLE_GTM_TRACKING", false);

//　Google Webフォント URL（配列）
define("GOOGLE_FONTS", [
  'https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@400;700&display=swap'
]);
