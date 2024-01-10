# mytheme

- Node.js ^18 || >=20
- [docker クライアント](https://www.docker.com/get-started)

## 初期設定

1 node_modules をインストール（同時にプロジェクトルートに`auth.json`、`.wp-env.override.json`が作成されます）

```sh
npm ci
```

2 [auth.json](https://www.advancedcustomfields.com/resources/installing-acf-pro-with-composer/) の`username`に ACF Pro ライセンスキーを追加

> [必要に応じ] `.wp-env.override.json` に設定を追加（例:[ポート番号変更](https://github.com/WordPress/gutenberg/tree/HEAD/packages/env#custom-port-numbers), [etc](https://github.com/WordPress/gutenberg/tree/HEAD/packages/env#examples)）

3 WordPress の自動セットアップを実行

```sh
npm run setup
```

## 作業タスク

```sh
# start wp-env
npx wp-env start -- --xdebug

# dev
npm run dev

# build
npm run build
```

- テーマディレクトリは npm [workspaces](https://docs.npmjs.com/cli/v7/using-npm/workspaces) です。
- `source/wp-content/themes` 以下のテーマディレクトリが開発/デプロイ対象です。
- `npm run dev`時に表示される Vite の URL は使用しないので無視してください。

### resources

- [wp-env](https://github.com/WordPress/gutenberg/tree/HEAD/packages/env#readme) | [wp-scripts](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-scripts/)
- [WordPress Developer Resources](https://developer.wordpress.org/)
- [npm workspaces](https://docs.npmjs.com/cli/v10/using-npm/workspaces)
