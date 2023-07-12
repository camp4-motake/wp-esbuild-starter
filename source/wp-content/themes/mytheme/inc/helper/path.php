<?php

namespace Lib\Helper\Path;

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
  $asset_path = get_theme_file_path($path);
  $asset_uri = get_theme_file_uri($path);
  $hash_id = file_exists($asset_path) ? "?id=" . hash_file("fnv132", $asset_path) : "";

  return $asset_uri . $hash_id;
}

/**
 * アセットパス取得ラッパー
 *
 * @param string $filepath アセットファイルパス
 * @return string パス
 */
function assets_uri($filepath = "")
{
  return get_theme_file_uri('dist/' . $filepath);
}
