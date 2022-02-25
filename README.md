# wp theme build starter

WP ローカル開発環境（docker-compose）、Twig による WP テンプレート記述、 esbuid での高速ビルド対応の WP テーマ開発用ボイラープレート

## 必要環境

- Node.js >=16
- [docker クライアント](https://www.docker.com/get-started)

### 必要プラグイン

- [Timber](https://ja.wordpress.org/plugins/timber-library/)（Twig テンプレートの表示には必須）

## 初期設定

環境変数ファイルを作成

```sh
cp ./docker/.env-example ./.env
```

依存 node_module パッケージをインストール

```sh
npm install
```

WordPress のローカルサーバーを自動セットアップ

```sh
npm run wp-setup
```

完了後は <http://localhost:{LOCAL_SERVER_PORT}/> で WP が表示できます（{LOCAL_SERVER_PORT} は `.env` で設定された値）

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

## ダッシュボードへのアクセス

ローカルサーバー起動後に次の URL を開いてください。

<http://localhost:{LOCAL_SERVER_PORT}/wp-admin/>

- user: `admin`
- password: `admin`

> 別途データベースをインポートしている場合は、そのデータに登録されているユーザーアカウントでログインしてください。

## その他

- ビルド時などに画像が反映されない場合は、ルートの `.cache/` ディレクトリを削除してから再ビルドしてください。
- [workspace](https://docs.npmjs.com/cli/v7/using-npm/workspaces) を使用しているので、テーマディレクトリ以下
  に npm install でモジュールを追加する場合は `-w {テーマディレクトリ名}`をつけて実行してください。

## リソース

- [esbuild](https://github.com/evanw/esbuild) | [doc](https://esbuild.github.io/)
- [Timber](https://github.com/timber/timber) | [doc](https://timber.github.io/docs/) | [cheetsheet](https://timber.github.io/docs/guides/cheatsheet/)
- [Twig](https://twig.symfony.com/doc/2.x/index.html) | [Timber Twig Cookbook](https://timber.github.io/docs/guides/cookbook-twig/)
