# mytheme

Docker の初期設定 -> [docker/README.md](docker/README.md)

```sh
# install deps
npm ci

# start wp-env  (or "npx wp-env start")
npm start

# dev
npm run dev

# build
npm run build
```

- `source/wp-content/themes` 以下のテーマディレクトリがデプロイ対象です。
- テーマディレクトリは npm [workspaces](https://docs.npmjs.com/cli/v7/using-npm/workspaces) です。
  - テーマへのモジュールの追加などは個別に workspaces を指定してください。
