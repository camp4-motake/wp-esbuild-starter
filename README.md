# wp starter

## Feature

- docker-compose | wp-cli | wordmove | Twig Template (use Timber)
- [Vite](https://vitejs.dev/config/) | [Postcss Prest Env](https://preset-env.cssdb.org/features/) | Scss | [TypeScript](https://www.typescriptlang.org/docs/)

## 必要環境

- Node.js >=16
- [docker クライアント](https://www.docker.com/get-started)（watch モード作業時必須）

### 必要プラグイン

- [Timber](https://ja.wordpress.org/plugins/timber-library/)（Twig テンプレート利用時必須）

## 初期設定

サンプルの雛形から環境変数ファイルを作成

```sh
cp ./docker/.env-example ./.env
```

[ACF Pro 利用時のみ] `.env`に ACFPro のライセンスキーを追記（任意）

```diff
+ ACF_PRO_KEY='{key}'
```

依存 node_module パッケージをインストール

```sh
npm ci
```

WordPress のローカルサーバーを自動セットアップ

```sh
npm run wp-setup
```

完了後は <http://localhost:{LOCAL_SERVER_PORT}/> で WP が表示できます。

> 注: `LOCAL_SERVER_PORT`は、`.env` で設定されている環境変数になります。

## コマンド

watch モードを起動 -> <http://localhost:3000/> で作業用のブラウザープレビューを表示します。

```sh
npm run dev
```

ビルド

```sh
npm run build
```

デプロイ時はビルド後にテーマディレクトリをアップしてください。

> 注 1: `npm run dev`実行時はアセットファイルが空になるので、公開時はかならず事前にビルドしてください。
> 注 2: `node_modules`ディレクトリは、公開サーバーにはアップしないでください。

## ダッシュボードへのアクセス

ローカルサーバー起動後に次の URL を開いてください。

<http://localhost:{LOCAL_SERVER_PORT}/wp-admin/>

- user: `admin`
- password: `admin`

> 別途データベースをインポートしている場合は、そのデータに登録されているユーザーアカウントでログインしてください。

## その他

- git のチェックアウト後や、画像が正しく反映されない場合などは、ルートの `.cache/` ディレクトリを削除してから再ビルドしてください。
- [workspace](https://docs.npmjs.com/cli/v7/using-npm/workspaces) を使用しています。テーマディレクトリ内にモジュールを追加する場合は `npm i {module_name} -w {theme_dir_name}`のように、workspace を指定して実行してください。

## リソース

- [Timber](https://github.com/timber/timber) | [doc](https://timber.github.io/docs/) | [CheatSheet](https://timber.github.io/docs/guides/cheatsheet/) | [Twig](https://twig.symfony.com/doc/2.x/index.html)
