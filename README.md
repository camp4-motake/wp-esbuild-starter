# WP esbuild starter

wp-env の開発環境、Twig による WP テンプレート記述、 esbuid での高速ビルド対応のテーマ開発用ボイラープレート

## 必要環境

- Node.js >=16
- [docker クライアント](https://www.docker.com/get-started)

### 必要プラグイン

- [Timber](https://ja.wordpress.org/plugins/timber-library/)（必須）

## 初期設定

依存パッケージのインストール

```sh
npm install
```

ローカルサーバーで WordPress を起動（wp-env）

```sh
npm run wp-env start
```

<!--
### [ACF Pro](https://www.advancedcustomfields.com/pro/) の設定

ACF Pro を使用する場合は、ソースコードを次のように変更してください。

`.wp-env.override.json`:

```diff
+{
+	"config": {
+		"ACF_PRO_LICENSE": "SET_YOUR_KEY"
+	}
+}
```

`package.json`:

```diff
-	"//postinstall": "bin/install-acf-pro.mjs"
+	"postinstall": "bin/install-acf-pro.mjs"
```

`.wp-env.json`:

```diff
{
	"plugins": [
+		"./plugins/advanced-custom-fields-pro",
		"..."
	],
	...
}
```

設定後に次のコマンドを実行します。

```bash
npm install
```
-->

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

> 納品やデプロイ時は、ビルド後にテーマディレクトリのみアップします。テーマディレクトリの内の node_modules は対象から除外してくだささい。

### wp-env

wp-env の詳細は[公式の document](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)を参照してください。

wp cli の実行

```sh
npm run wp-env cli {wp-cliコマンド}
```

### セットアップ

次のコマンドを実行すると、自動的に WordPress の初期設定が行われます:

```bash
npm run wp-env start
bin/wp-setup.mjs
```

### データベースおよびメディアファイルのエクスポート

WordPress ローカル環境のデータベースとメディアファイルの状態を `bin/snapshot` ディレクトリに出力できます。これを Git リポジトリにコミットすることで、別のローカル環境でも同様の状態を再現できるようになります。

```bash
npm run wp-env start
bin/wp-export.mjs
```

### データベースおよびメディアファイルのインポート

`bin/snapshot` ディレクトリに前回の状態が保存されていれば、データベースとメディアファイルを復元できます。

```bash
npm run wp-env start
bin/wp-import.mjs
```

### ダッシュボードへのアクセス

wp-env の起動後に次の URL を開いてください。

<http://localhost:8888/wp-admin/>

- user: `admin`
- password: `password`

## その他

- ビルド時などに画像が反映されない場合は、ルートの `.cache/` ディレクトリを削除してから再ビルドしてください。
- [workspace](https://docs.npmjs.com/cli/v7/using-npm/workspaces) を使用しているので、テーマディレクトリ以下
  に npm install でモジュールを追加する場合は `-w {テーマディレクトリ名}`をつけて実行してください。

## リソース

- [@wordpress/env](https://github.com/WordPress/gutenberg/tree/trunk/packages/env)|[doc](https://ja.wordpress.org/team/handbook/block-editor/reference-guides/packages/packages-env/)
- [esbuild](https://github.com/evanw/esbuild) | [doc](https://esbuild.github.io/)
- [Timber](https://github.com/timber/timber) | [doc](https://timber.github.io/docs/) | [Twig ex](https://twig.symfony.com/doc/2.x/index.html)
