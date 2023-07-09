# WP theme starter

[Docker の初期設定](docker/README.md)

```sh
# 初期化
npm ci

# dev（docker などで WP 環境を起動している場合のみ）
npm run dev

# build
npm run build
```

- `source/wp-content/themes` 以下のテーマディレクトリがデプロイ対象です。
- テーマディレクトリは [workspaces](https://docs.npmjs.com/cli/v7/using-npm/workspaces) です。
