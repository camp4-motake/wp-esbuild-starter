# 開発用 WordPress 設定

[wp-env](https://github.com/WordPress/gutenberg/tree/HEAD/packages/env#readme) で ローカル開発環境を起動し、必要な設定を行います。

## 必要要件

- Node.js ^18 || >=20
- [docker クライアント](https://www.docker.com/get-started)

## WordPress のセットアップ

以降の手順はワークスペースルートで実行します。

1, node_modules をインストールします。同時にプロジェクトルートに`auth.json`、`.wp-env.override.json`が作成されます。

```sh
npm ci
```

必要に応じ、`.wp-env.override.json` に設定を追加します（例：[ポート番号変更](https://github.com/WordPress/gutenberg/tree/HEAD/packages/env#custom-port-numbers), [etc](https://github.com/WordPress/gutenberg/tree/HEAD/packages/env#examples)など）

2, [auth.json](https://www.advancedcustomfields.com/resources/installing-acf-pro-with-composer/) の `username` キーに ACF Pro のライセンスキーを指定します。

```json
{
 "http-basic": {
  "connect.advancedcustomfields.com": {
   "username": "{ACF_PRO_KEY}",
   "password": "https://camp4.jp/"
  }
 }
}
```

3, 以下の手順で自動セットアップを実行します。

```sh
npm run setup
```
