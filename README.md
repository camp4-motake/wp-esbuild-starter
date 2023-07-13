# WP theme starter

Docker の初期設定 - [docker/README.md](docker/README.md)

`source/wp-content/themes` 以下のテーマディレクトリがデプロイ対象です。このテーマディレクトリは npm の [workspaces](https://docs.npmjs.com/cli/v7/using-npm/workspaces) です。

```sh
# 初期化
npm ci

# dev （dockerなどでWP環境を起動している場合のみ）
npm run dev

# build
npm run build
```
