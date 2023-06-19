# WP theme starter

## 初期設定

-> [WP 開発環境（Docker）の初期設定](docker/README.md)

## 作業タスク

```sh
# ライブリロード（docker などで WP 環境を起動している場合のみ）
npm run dev

# ビルド
npm run build
```

- `source/wp-content/themes` 以下のテーマディレクトリがデプロイ対象です。
- テーマディレクトリは[workspaces](https://docs.npmjs.com/cli/v7/using-npm/workspaces) 扱いのため、テーマ用の node_module 追加やスクリプト実行時は workspaces パスを指定してください。

```sh
# 例
npm i swiper -w source/wp-content/themes/mytheme
```
