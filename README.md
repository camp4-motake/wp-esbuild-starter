# mytheme

Docker の初期設定 -> [docker/README.md](docker/README.md)

```sh
# 初期化
npm ci

# dev （dockerでWP環境を起動している場合のみ）
npm run dev

# build
npm run build
```

- `source/wp-content/themes` 以下のテーマディレクトリがデプロイ対象です。
- テーマディレクトリは npm の [workspaces](https://docs.npmjs.com/cli/v7/using-npm/workspaces) です。
