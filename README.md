# WP esbuild starter

Twig による WP テンプレート記述と esbuid での高速ビルド対応テーマ

## 必要環境

- Node.js >=16
- [docker クライアント](https://www.docker.com/get-started)

> Local、MAMP などを使用する場合は、テーマディレクトリにシンボリックリンクを設定してください。

### 必要プラグイン

- [Timber](https://ja.wordpress.org/plugins/timber-library/)（必須）

## 初期設定

1 - .env-sample をコピーし環境変数ファイル .env を作成します。（必要に応じ.env の内容を変更します）

```sh
cp ./.env-example ./.env
```

2 - node_modules をインストールします

```sh
npm install
```

3 - 自動セットアップを実行。docker-compose で WordPress を起動し初期状態のセットアップを実行します（docker 利用時のみ）

```sh
npm run wp-setup
```

## コマンド

### フロントエンド

ウォッチ

```sh
npm run dev
```

ビルド

```sh
npm run build
```

### wp 関連

## その他

- 画像が反映されない場合は、ルートの `.cache/` ディレクトリを削除してから再ビルドしてください。
- [workspace](https://docs.npmjs.com/cli/v7/using-npm/workspaces) を使用しているので、テーマディレクトリ以下
  に npm install でモジュールを追加する場合は `-w {テーマディレクトリ名}`をつけて実行してください。

## リソース

- [Timber](https://github.com/timber/timber) | [doc](https://timber.github.io/docs/)
- [esbuild](https://github.com/evanw/esbuild) | [doc](https://esbuild.github.io/)
- [@wordpress/env](https://github.com/WordPress/gutenberg/tree/trunk/packages/env)|[doc](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)
