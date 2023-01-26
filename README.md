# wp starter

## Feature

- docker-compose | wp-cli | Twig Template (use [Timber](https://wordpress.org/plugins/timber-library/))
- [Vite](https://vitejs.dev/config/) | [Postcss Prest Env](https://preset-env.cssdb.org/features/) | Scss | [TypeScript](https://www.typescriptlang.org/docs/)

## 必要環境

- Node.js 16 || 18
- [docker クライアント](https://www.docker.com/get-started)（`npm run dev`での作業時のみ必須）

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

Docker Compose で WordPress のローカルサーバーを起動し自動セットアップ

```sh
npm run wp-setup
```

完了後は <http://localhost:{LOCAL_SERVER_PORT}/> で WP が表示できます。

> 注: `LOCAL_SERVER_PORT`は、`.env` で設定されている環境変数になります。
> もし wp-env などの他の WP 環境を使用する場合は、自動セットアップは不要です。

## コマンド

### dev

Docker などでローカル WP 起動している場合、その WP の URL (<http://localhost:{LOCAL_SERVER_PORT}/>)で、vite でライブリロードや自動コンパイルを実行します。

```sh
npm run dev
```

> CLI に Vite サーバーの URL （localhost:5173 など）が表示されることがありますが無視してください。

### ビルド

納品要にビルドします。デプロイ時はビルド後にテーマディレクトリをアップしてください。

```sh
npm run build
```

アップ後に表示が崩れたり CSS が反映されない場合は、WP 管理画面でキャッシュプラグインのキャッシュを削除してください。

> 注 1: `npm run dev`実行時はアセットファイルが空になるので、公開時はかならず事前にビルドしてください。
> 注 2: `node_modules`ディレクトリは、公開サーバーにはアップしないでください。

## ダッシュボードへのアクセス

ローカルサーバー起動後に次の URL を開いてください。

<http://localhost:{LOCAL_SERVER_PORT}/wp-admin/>

- user: `admin`
- password: `admin`

> 別途データベースをインポートしている場合は、そのデータに登録されているユーザーアカウントでログインしてください。

## その他

- [workspace](https://docs.npmjs.com/cli/v7/using-npm/workspaces) を使用しているため、テーマディレクトリ内にモジュールを追加する場合は `npm i {module_name} -w themes/{WP_THEME_NAME}`のように、workspace の対象ディレクトリ名を指定して実行してください。
- 画像が正しく反映されない場合は、ルートの `.cache/` ディレクトリを削除してから再ビルドしてください。

## 関連リソース

- [Timber](https://github.com/timber/timber) | [doc](https://timber.github.io/docs/) | [CheatSheet](https://timber.github.io/docs/guides/cheatsheet/) | [Twig](https://twig.symfony.com/doc/2.x/index.html)
