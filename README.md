# wp theme build starter

WP テーマ開発用ボイラープレート

## Feature

- WP : Local Dev WP (docker-compose) | Twig Template (Timber)
- Frontend : [Vite](https://vitejs.dev/config/) | [Postcss](https://preset-env.cssdb.org/features/) | [TypeScript](https://www.typescriptlang.org/docs/)

## 必要環境

- Node.js >=16
- [docker クライアント](https://www.docker.com/get-started)

### 必要プラグイン

- [Timber](https://ja.wordpress.org/plugins/timber-library/)（Twig テンプレートの表示に必須）

## 初期設定

環境変数ファイルを作成

```sh
cp ./docker/.env-example ./.env
```

ACF Pro のライセンスキーがある場合は、`.env`にライセンスキーを追記（任意）

```diff
+ ACF_PRO_KEY='{key}'
```

依存 node_module パッケージをインストール

```sh
npm install
```

WordPress のローカルサーバーを自動セットアップ

```sh
npm run wp-setup
```

完了後は <http://localhost:8888/> で WP が表示できます。

> 注: ポート番号　は環境変数 `.env` で設定されている `LOCAL_SERVER_PORT`値になります。

## コマンド

### フロントエンド

ウォッチを起動 -> <http://localhost:3000/> で作業用のブラウザープレビューを表示します。

```sh
npm run dev
```

ビルド

```sh
npm run build
```

### デプロイ

ビルド後にテーマディレクトリをアップしてください。

- 注 1: `npm run dev`実行時はアセットファイルが空になるので、公開時はかならずビルドしてください。
- 注 2: セキュリティ上の理由から、`node_modules`ディレクトリは、公開サーバーにはアップしないでください。

## ダッシュボードへのアクセス

ローカルサーバー起動後に次の URL を開いてください。

<http://localhost:8888/wp-admin/>

- user: `admin`
- password: `admin`

> 別途データベースをインポートしている場合は、そのデータに登録されているユーザーアカウントでログインしてください。

## その他

- ビルド時などに画像が反映されない場合は、ルートの `.cache/` ディレクトリを削除してから再ビルドしてください。
- [workspace](https://docs.npmjs.com/cli/v7/using-npm/workspaces) を使用しているので、テーマディレクトリ以下
  に npm install でモジュールを追加する場合は `-w {テーマディレクトリ名}`をつけて実行してください。

## リソース

- [Vite](https://github.com/vitejs/vite) | [doc](https://vitejs.dev/)
- [Timber](https://github.com/timber/timber) | [doc](https://timber.github.io/docs/) | [CheatSheet](https://timber.github.io/docs/guides/cheatsheet/)
- [Twig](https://twig.symfony.com/doc/2.x/index.html) | [Timber Twig Cookbook](https://timber.github.io/docs/guides/cookbook-twig/)
